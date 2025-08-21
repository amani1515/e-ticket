<?php

namespace App\Http\Controllers\Ticketer;

use App\Models\Ticket;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Bus;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Schedule;
use Barryvdh\DomPDF\Facade\Pdf;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class TicketController extends Controller
{
    // Show the create ticket form

    
    public function index(Request $request)
{
    $query = Ticket::query();

    if ($request->filled('destination_id')) {
        $query->where('destination_id', $request->destination_id);
    }

    if ($request->filled('ticket_status')) {
        $query->where('ticket_status', $request->ticket_status);
    }

    if ($request->filled('targa')) {
        $query->whereHas('bus', function ($q) use ($request) {
            $q->where('targa_number', 'like', '%' . $request->targa . '%');
        });
    }

    $tickets = $query->with(['destination', 'bus'])->latest()->paginate(10);
    $destinations = Destination::all();

    return view('ticketer.reports.index', compact('tickets', 'destinations'));
}
    public function create()
{
    $user = auth()->user()->load('destinations');
    $destinations = $user->destinations;
    
    // Only get destinations assigned to this user
    $destinations = $user->destinations;


    return view('ticketer.tickets.create', compact('user', 'destinations'));
}

    // Store the ticket data and generate a ticket code

public function store(Request $request)
{
    $request->validate([
        'passenger_name' => 'required|string|max:255',
        'gender' => 'required|in:male,female',
        'age_status' => 'required|in:baby,adult,senior,middle_aged',
        'destination_id' => 'required|exists:destinations,id',
        'bus_id' => 'required|string|max:255', // This is targa from the form!
        'departure_datetime' => 'required|date',
        'phone_no' => 'nullable|digits:10|unique:tickets,phone_no',
        'fayda_id' => 'nullable|digits:16|unique:tickets,fayda_id',
        'disability_status' => 'required|in:None,Blind / Visual Impairment,Deaf / Hard of Hearing,Speech Impairment',
    ]);

    // Find the first queued or on loading schedule for this destination
    $activeSchedule = Schedule::where('destination_id', $request->destination_id)
        ->whereIn('status', ['queued', 'on loading'])
        ->orderBy('scheduled_at')
        ->first();
    
    // If there's an active schedule with a ticketer assigned, only that ticketer can create tickets
    if ($activeSchedule && $activeSchedule->ticketer_id && $activeSchedule->ticketer_id !== auth()->id()) {
        $ticketerName = User::find($activeSchedule->ticketer_id)->name ?? 'Another ticketer';
        return back()->withErrors(['destination_id' => $ticketerName . ' is already creating tickets for this destination. Please wait until they finish.']);
    }

    $destination = Destination::findOrFail($request->destination_id);

    // Find the bus by targa
    $bus = Bus::where('targa', $request->bus_id)->first();
    if (!$bus) {
        return back()->withErrors(['bus_id' => 'Bus not found.']);
    }

    // Find the related schedule (status queued or on loading)
    $schedule = Schedule::where('bus_id', $bus->id)
        ->where('destination_id', $request->destination_id)
        ->whereIn('status', ['queued', 'on loading'])
        ->first();

    $ticket = Ticket::create([
        'cargo_id' => $request->cargo_id,
        'passenger_name' => $request->passenger_name,
        'gender' => $request->gender,
        'age_status' => $request->age_status,
        'destination_id' => $request->destination_id,
        'bus_id' => $bus->id,
        'schedule_id' => $schedule ? $schedule->id : null,
        'departure_datetime' => $request->departure_datetime,
        'ticket_code' => 'SE' . now()->format('Ymd') . strtoupper(uniqid()),
        'creator_user_id' => auth()->id(),
        'tax' => $destination->tax,
        'service_fee' => $destination->service_fee,
        'ticket_status' => 'created',
        'disability_status' => $request->disability_status,
        'phone_no' => $request->phone_no,
        'fayda_id' => $request->fayda_id,
    ]);

    // Update cargo status to 'paid' if cargo is attached
    if ($request->cargo_id) {
        \App\Models\Cargo::where('id', $request->cargo_id)->update(['status' => 'paid']);
    }

    if ($schedule) {
        // Set ticketer ownership when first ticket is created for this schedule
        if (!$schedule->ticketer_id) {
            $schedule->ticketer_id = auth()->id();
        }

        // Count only tickets with status 'created' or 'confirmed'
        $boardingCount = Ticket::where('schedule_id', $schedule->id)
            ->whereIn('ticket_status', ['created', 'confirmed'])
            ->count();

        $schedule->boarding = $boardingCount;

        if ($boardingCount >= $schedule->capacity) {
            $schedule->status = 'full';
            // Clear ticketer ownership when schedule is full
            $schedule->ticketer_id = null;
        } elseif ($schedule->status === 'queued') {
            $schedule->status = 'on loading';
        }
        $schedule->save();
        
        // Trigger sync for schedule update
        $schedule->syncUpdate();
    }

    return redirect()->route('ticketer.tickets.receipt', $ticket->id);
}

public function checkPhone(Request $request)
{
    $exists = Ticket::where('phone_no', $request->phone_no)->exists();
    return response()->json(['exists' => $exists]);
}

public function checkFaydaId(Request $request)
{
    $exists = Ticket::where('fayda_id', $request->fayda_id)->exists();
    return response()->json(['exists' => $exists]);
}

    // Optional: Show the ticket receipt after it's created
   public function receipt($id)
{
    $ticket = Ticket::with(['destination', 'cargo', 'bus.mahberat'])->findOrFail($id);
    return view('ticketer.tickets.receipt', compact('ticket'));
}



    public function report(Request $request)
{
    $query = Ticket::query();

    // Filter tickets created by the current user
    $query->where('creator_user_id', auth()->id());

    if ($request->filled('destination_id')) {
        $query->where('destination_id', $request->destination_id);
    }

    if ($request->filled('ticket_status')) {
        $query->where('ticket_status', $request->ticket_status);
    }

    if ($request->filled('search')) {
    $search = $request->search;

    $query->where(function ($q) use ($search) {
        $q->where('id', $search) // Exact ticket ID match
          ->orWhereHas('bus', function ($busQuery) use ($search) {
              $busQuery->where('bus_id', 'like', '%' . $search . '%'); // Partial match on bus targa
          });
    });
}


    if ($request->filled('date_filter')) {
        switch ($request->date_filter) {
            case 'today':
                $query->whereDate('departure_datetime', now()->toDateString());
                break;
            case 'yesterday':
                $query->whereDate('departure_datetime', now()->subDay()->toDateString());
                break;
            case 'this_week':
                $query->whereBetween('departure_datetime', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'two_days_before':
                $query->whereDate('departure_datetime', now()->subDays(2)->toDateString());
                break;
        }
    }

    // Fetch destinations assigned to the current user
    $user = auth()->user()->load('destinations');
    $destinations = $user->destinations;

    $tickets = $query->with(['destination', 'bus'])->latest()->paginate(10);

    return view('ticketer.tickets.report', compact('tickets', 'destinations'));
}
public function showScanForm()
{
    return view('ticketer.tickets.scan');
}
 public function export(Request $request)
    {
        $filters = $request->all();
        return Excel::download(new TicketsExport($filters), 'tickets_report.xlsx');
    }

public function processScan(Request $request)
{
    $request->validate([
        'ticket_code' => 'required|string'
    ]);

    $inputCode = $request->ticket_code;
    
    // Try exact match first
    $ticket = Ticket::where('ticket_code', $inputCode)->first();
    
    // If not found, try partial match (input might be truncated)
    if (!$ticket) {
        $ticket = Ticket::where('ticket_code', 'LIKE', $inputCode . '%')->first();
    }
    
    // If still not found, try reverse partial match (database might be truncated)
    if (!$ticket) {
        $ticket = Ticket::where('ticket_code', 'LIKE', '%' . $inputCode)->first();
    }

    if (!$ticket) {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Ticket not found: ' . $inputCode]);
        }
        return redirect()->back()->with('error', 'Ticket not found: ' . $inputCode);
    }

    if ($ticket->ticket_status !== 'created') {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Ticket already processed. Status: ' . $ticket->ticket_status]);
        }
        return redirect()->back()->with('error', 'Ticket already processed. Status: ' . $ticket->ticket_status);
    }

    $ticket->ticket_status = 'confirmed';
    $ticket->save();
    
    // Trigger sync for ticket confirmation
    $ticket->syncUpdate();

    if ($request->expectsJson() || $request->ajax()) {
        return response()->json(['success' => true, 'message' => 'Ticket confirmed! Passenger: ' . $ticket->passenger_name]);
    }
    return redirect()->back()->with('success', 'Ticket confirmed! Passenger: ' . $ticket->passenger_name);
}

public function debugTickets()
{
    $tickets = Ticket::latest()->take(10)->get(['id', 'ticket_code', 'ticket_status', 'passenger_name']);
    return response()->json($tickets);
}

public function scheduleBoardingInfo()
{
    $schedules = Schedule::with(['bus', 'destination', 'ticketer'])
        ->whereIn('status', ['queued', 'on loading'])
        ->get()
        ->map(function($schedule) {
            return [
                'id' => $schedule->id,
                'destination_name' => $schedule->destination->destination_name,
                'bus_targa' => $schedule->bus->targa,
                'driver_name' => $schedule->bus->driver_name,
                'capacity' => $schedule->capacity,
                'boarding' => $schedule->boarding,
                'status' => $schedule->status,
                'ticketer_name' => $schedule->ticketer ? $schedule->ticketer->name : null,
                'is_owned_by_me' => $schedule->ticketer_id === auth()->id()
            ];
        });
    
    return response()->json($schedules);
}

public function checkTicketerOwnership(Request $request)
{
    $destinationId = $request->destination_id;
    
    $activeSchedule = Schedule::where('destination_id', $destinationId)
        ->whereIn('status', ['queued', 'on loading'])
        ->with('ticketer')
        ->first();
    
    if (!$activeSchedule) {
        return response()->json(['available' => true, 'message' => 'No active schedule found']);
    }
    
    if (!$activeSchedule->ticketer_id) {
        return response()->json(['available' => true, 'message' => 'Schedule available for ticketing']);
    }
    
    if ($activeSchedule->ticketer_id === auth()->id()) {
        return response()->json(['available' => true, 'message' => 'You own this schedule']);
    }
    
    return response()->json([
        'available' => false, 
        'message' => 'Schedule is being handled by ' . ($activeSchedule->ticketer->name ?? 'another ticketer')
    ]);
}




public function getFirstBus($destinationId)
{
    $schedule = Schedule::with('bus')
        ->where('destination_id', $destinationId)
        ->where('status', 'queued')
        ->orderBy('scheduled_at', 'asc')
        ->first();

    if (!$schedule) {
        return response()->json(null);
    }

    $bus = $schedule->bus;
    $soldSeats = Ticket::where('bus_id', $bus->targa)
        ->where('destination_id', $destinationId)
        ->count();

    return response()->json([
        'targa' => $bus->targa,
        'total_seats' => $bus->total_seats,
        'remaining_seats' => $bus->total_seats - $soldSeats,
    ]);
}
public function getFirstQueuedBus($destinationId)
{
    $schedule = Schedule::where('destination_id', $destinationId)
        ->where('status', 'queued')
        ->orderBy('scheduled_at')
        ->with('bus') // make sure you have this relation in Schedule
        ->first();

    if ($schedule && $schedule->bus) {
        $sold = Ticket::where('bus_id', $schedule->bus->id)
            ->where('destination_id', $destinationId)
            ->count();

        return response()->json([
            'bus_id' => $schedule->bus->id,
            'available_seats' => $schedule->bus->total_seats - $sold
        ]);
    }

    return response()->json([]);
}




        public function firstQueuedBus($destinationId)
        {
            $bus = \App\Models\Schedule::where('destination_id', $destinationId)
                ->whereIn('status', ['queued', 'on loading'])
                ->orderBy('scheduled_at')
                ->with('bus')
                ->first();

            return response()->json([
                'bus_id' => $bus?->bus?->targa ?? '',
            ]);
        }

        public function cargoInfo(Request $request)
{
    // Validate the request
    $request->validate([
        'cargo_uid' => 'required|string|max:50',
    ]);
    
    $uid = $request->input('cargo_uid');
    
    // Additional security: Rate limiting and user verification
    $user = auth()->user();
    if (!$user || !in_array($user->usertype, ['admin', 'ticketer', 'cargoman'])) {
        return response()->json(['error' => 'Unauthorized access'], 403);
    }
    
    $cargo = \App\Models\Cargo::where('cargo_uid', $uid)->first();
    
    if (!$cargo) {
        // Log suspicious activity - someone trying to access non-existent cargo
        \Log::warning('Attempted access to non-existent cargo', [
            'user_id' => $user->id,
            'ip' => $request->ip(),
            'attempted_uid' => substr($uid, 0, 5) . '***', // Partially hide UID in logs
        ]);
        
        return response()->json(['error' => 'Cargo not found'], 404);
    }
    
    // Additional authorization check - users can only access cargo from their assigned destinations
    if ($user->usertype === 'ticketer') {
        $userDestinations = $user->destinations->pluck('id')->toArray();
        if (!in_array($cargo->destination_id, $userDestinations)) {
            return response()->json(['error' => 'Access denied'], 403);
        }
    }
    
    return response()->json([
        'id' => $cargo->id,
        'weight' => $cargo->weight,
        'status' => $cargo->status,
        // Don't return the actual cargo_uid in response for security
        'destination' => $cargo->destination->name ?? 'Unknown',
    ]);
}


public function update(Request $request, $id)
{
    $ticket = Ticket::findOrFail($id);

    $ticket->passenger_name = $request->passenger_name;
    $ticket->gender = $request->gender;
    $ticket->phone_no = $request->phone_no;
    $ticket->fayda_id = $request->fayda_id;
    $ticket->age_status = $request->age_status;
    $ticket->disability_status = $request->disability_status;
    $ticket->departure_datetime = $request->departure_datetime;
    // Add validation as needed
    $ticket->save();
    
    // Trigger sync for update
    $ticket->syncUpdate();

    return redirect()->back()->with('success', 'Ticket updated successfully.');
}

public function cancel($id)
{
    $ticket = Ticket::findOrFail($id);

    // Only proceed if not already cancelled
    if ($ticket->ticket_status !== 'cancelled') {
        $ticket->ticket_status = 'cancelled';
        $ticket->cancelled_at = now();
        $ticket->save();

        $schedule = $ticket->schedule;
        if ($schedule) {
            // Recalculate boarding count for only 'created' or 'confirmed' tickets
            $boardingCount = Ticket::where('schedule_id', $schedule->id)
                ->whereIn('ticket_status', ['created', 'confirmed'])
                ->count();

            $schedule->boarding = $boardingCount;

            if ($boardingCount >= $schedule->capacity) {
                $schedule->status = 'full';
                // Clear ticketer ownership when schedule is full
                $schedule->ticketer_id = null;
            } elseif ($boardingCount === 0) {
                $schedule->status = 'queued';
                // Clear ticketer ownership when no active tickets remain
                $schedule->ticketer_id = null;
            } else {
                $schedule->status = 'on loading';
                // Keep ticketer ownership while there are active tickets
            }
            $schedule->save();
            
            // Trigger sync for schedule update
            $schedule->syncUpdate();
        }
        
        // Trigger sync for cancellation
        $ticket->syncUpdate();
    }

    return back()->with('success', 'Ticket cancelled successfully.');
}

public function receiptPdf($id)
{
    $ticket = Ticket::with(['destination', 'cargo', 'bus.mahberat', 'creator'])->findOrFail($id);
    
    $pdf = Pdf::loadView('ticketer.tickets.receipt-pdf', compact('ticket'))
        ->setPaper([0, 0, 226.77, 566.93], 'portrait') // 58mm x 200mm
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
            'enable_php' => true
        ]);
    
    return $pdf->stream('receipt-' . $ticket->id . '.pdf');
}

public function receiptPdfDownload($id)
{
    $ticket = Ticket::with(['destination', 'cargo', 'bus.mahberat', 'creator'])->findOrFail($id);
    
    $pdf = Pdf::loadView('ticketer.tickets.receipt-pdf', compact('ticket'))
        ->setPaper([0, 0, 226.77, 566.93], 'portrait') // 58mm x 200mm
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'DejaVu Sans',
            'enable_php' => true
        ]);
    
    return $pdf->download('receipt-' . $ticket->id . '.pdf');
}

public function receiptImage($id)
{
    $ticket = Ticket::with(['destination', 'cargo', 'bus.mahberat', 'creator'])->findOrFail($id);
    
    $manager = new ImageManager(new Driver());
    
    // Create image canvas (58mm = 220px at 96dpi)
    $image = $manager->create(220, 800)->fill('#ffffff');
    
    // Add text content
    $y = 20;
    $image->text('E-TICKET', 110, $y, function($font) {
        $font->size(16);
        $font->color('#000000');
        $font->align('center');
        $font->valign('top');
    });
    
    $y += 30;
    $image->text('--------------------------------', 110, $y, function($font) {
        $font->size(12);
        $font->color('#000000');
        $font->align('center');
    });
    
    $y += 25;
    $lines = [
        'ሰሌዳ ቁጥር: ' . ($ticket->bus->targa ?? $ticket->bus_id),
        'የተጓዥ ስም: ' . $ticket->passenger_name,
        'ጾታ: ' . ucfirst($ticket->gender),
        'ፋይዳ ቁጥር: ' . $ticket->fayda_id,
        'የተጓዥ ስልክ: ' . $ticket->phone_no,
        'መነሻ: ' . $ticket->destination->start_from,
        'መድረሻ: ' . $ticket->destination->destination_name,
        'የመነሻ ቀን: ' . \Carbon\Carbon::parse($ticket->departure_datetime)->format('Y-m-d'),
        'የመሳፈሪያ ሰዓት: ' . \Carbon\Carbon::parse($ticket->departure_datetime)->format('H:i'),
        'የትኬት መለያ ቁጥር: ' . $ticket->id,
        'ትኬት ወኪል: ' . ($ticket->creator ? $ticket->creator->name : 'N/A'),
        'ታሪፍ: ' . $ticket->destination->tariff,
        'አገልግሎት ክፍያ: ' . $ticket->destination->service_fee,
    ];
    
    if ($ticket->cargo) {
        $lines[] = 'የእቃ ክብደት: ' . $ticket->cargo->weight . ' kg';
        $lines[] = 'የእቃ ክፍያ: ' . number_format($ticket->cargo->total_amount, 2) . ' ብር';
    }
    
    $lines[] = 'አጠቃላይ ክፍያ: ' . ($ticket->destination->tariff + $ticket->destination->tax + $ticket->destination->service_fee + ($ticket->cargo ? $ticket->cargo->total_amount : 0)) . ' ብር';
    
    foreach ($lines as $line) {
        $image->text($line, 10, $y, function($font) {
            $font->size(10);
            $font->color('#000000');
            $font->align('left');
        });
        $y += 20;
    }
    
    $y += 10;
    $image->text('--------------------------------', 110, $y, function($font) {
        $font->size(12);
        $font->color('#000000');
        $font->align('center');
    });
    
    $y += 25;
    $image->text('ስለመረጡን እናመሰግናለን', 110, $y, function($font) {
        $font->size(12);
        $font->color('#000000');
        $font->align('center');
    });
    
    $y += 20;
    $image->text('ለአንድ ጊዜ ጉዞ ብቻ የተፈቀደ', 110, $y, function($font) {
        $font->size(12);
        $font->color('#000000');
        $font->align('center');
    });
    
    $filename = 'receipt-' . $ticket->id . '.png';
    $path = storage_path('app/public/receipts/' . $filename);
    
    // Ensure directory exists
    if (!file_exists(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }
    
    $image->save($path);
    
    return response()->download($path)->deleteFileAfterSend(true);
}

public function receiptText($id)
{
    $ticket = Ticket::with(['destination', 'cargo', 'bus.mahberat', 'creator'])->findOrFail($id);
    
    $ageStatusAmharic = [
        'baby' => 'ህጻን',
        'adult' => 'ወጣት', 
        'middle_aged' => 'ጎልማሳ',
        'senior' => 'ሽማግሌ',
    ];
    
    $disabilityStatusAmharic = [
        'None' => 'የለም',
        'Blind / Visual Impairment' => 'ማየት የተሳነው',
        'Deaf / Hard of Hearing' => 'መስማት የተሳነው', 
        'Speech Impairment' => 'መናገር የተሳነው',
    ];
    
    $content = "E-TICKET\n";
    $content .= "--------------------------------\n";
    $content .= "ሰሌዳ ቁጥር: " . ($ticket->bus->targa ?? $ticket->bus_id) . "\n";
    $content .= "የተጓዥ ስም: " . $ticket->passenger_name . "\n";
    $content .= "ጾታ: " . ucfirst($ticket->gender) . "\n";
    $content .= "ፋይዳ ቁጥር: " . $ticket->fayda_id . "\n";
    $content .= "የተጓዥ ስልክ: " . $ticket->phone_no . "\n";
    $content .= "የእድሜ ሁኔታ: " . ($ageStatusAmharic[$ticket->age_status] ?? $ticket->age_status) . "\n";
    $content .= "የአካል ጉዳት: " . ($disabilityStatusAmharic[$ticket->disability_status] ?? $ticket->disability_status) . "\n";
    $content .= "መነሻ: " . $ticket->destination->start_from . "\n";
    $content .= "መድረሻ: " . $ticket->destination->destination_name . "\n";
    $content .= "የመነሻ ቀን: " . \Carbon\Carbon::parse($ticket->departure_datetime)->format('Y-m-d') . "\n";
    $content .= "የመሳፈሪያ ሰዓት: " . \Carbon\Carbon::parse($ticket->departure_datetime)->format('H:i') . "\n";
    $content .= "የትኬት መለያ ቁጥር: " . $ticket->id . "\n";
    $content .= "ትኬት ወኪል: " . ($ticket->creator ? $ticket->creator->name : 'N/A') . "\n";
    $content .= "የማህበር ስም: " . ($ticket->bus && $ticket->bus->mahberat ? $ticket->bus->mahberat->name : 'N/A') . "\n";
    $content .= "ታሪፍ: " . $ticket->destination->tariff . "\n";
    $content .= "አገልግሎት ክፍያ: " . $ticket->destination->service_fee . "\n";
    
    if ($ticket->cargo) {
        $content .= "የእቃ ክብደት: " . $ticket->cargo->weight . " kg\n";
        $content .= "የእቃ ክፍያ: " . number_format($ticket->cargo->total_amount, 2) . " ብር\n";
    }
    
    $total = $ticket->destination->tariff + $ticket->destination->tax + $ticket->destination->service_fee + ($ticket->cargo ? $ticket->cargo->total_amount : 0);
    $content .= "አጠቃላይ ክፍያ: " . $total . " ብር\n";
    $content .= "--------------------------------\n";
    $content .= "ስለመረጡን እናመሰግናለን\n";
    $content .= "ለአንድ ጊዜ ጉዞ ብቻ የተፈቀደ\n";
    $content .= "\n";
    $content .= "ለተጨማሪ መረጃ: 0956407670\n";
    
    return response($content, 200, [
        'Content-Type' => 'text/plain; charset=utf-8'
    ]);
}


}
