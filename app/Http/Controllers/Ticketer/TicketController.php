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
        'disability_status' => 'required|in:None,Blind / Visual Impairment,Deaf / Hard of Hearing,Speech Impairment',
    ]);

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
        $schedule->ticket_created_by = auth()->id();

        // Count only tickets with status 'created' or 'confirmed'
        $boardingCount = Ticket::where('schedule_id', $schedule->id)
            ->whereIn('ticket_status', ['created', 'confirmed'])
            ->count();

        $schedule->boarding = $boardingCount;

        if ($boardingCount >= $schedule->capacity) {
            $schedule->status = 'full';
        } elseif ($schedule->status === 'queued') {
            $schedule->status = 'on loading';
        }
        $schedule->save();
    }

    return redirect()->route('ticketer.tickets.receipt', $ticket->id);
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

    $ticket = Ticket::where('ticket_code', $request->ticket_code)->first();

    if (!$ticket) {
        return redirect()->back()->with('error', 'Ticket not found.');
    }

    if ($ticket->ticket_status !== 'created') {
        return redirect()->back()->with('error', 'Ticket is not in a scannable state.');
    }

    $ticket->ticket_status = 'confirmed';
    $ticket->save();

    return redirect()->back()->with('success', 'Ticket confirmed successfully.');
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
            } elseif ($boardingCount === 0) {
                $schedule->status = 'queued';
            } else {
                $schedule->status = 'on loading';
            }
            $schedule->save();
        }
    }

    return back()->with('success', 'Ticket cancelled successfully.');
}


}
