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
            'age_status' => 'required|in:baby,adult,senior',
            'destination_id' => 'required|exists:destinations,id',
            'bus_id' => 'required|string|max:255',
            'departure_datetime' => 'required|date',
        ]);
    
        $destination = Destination::findOrFail($request->destination_id);
    
        $ticket = Ticket::create([
            'passenger_name' => $request->passenger_name,
            'age_status' => $request->age_status,
            'destination_id' => $request->destination_id,
            'bus_id' => $request->bus_id,
            'departure_datetime' => $request->departure_datetime,
            'ticket_code' => 'SE' . now()->format('Ymd') . strtoupper(uniqid()),
            'creator_user_id' => auth()->id(),
            'tax' => $destination->tax,
            'service_fee' => $destination->service_fee,
            'ticket_status' => 'created',
        ]);
    
        // 👇 Paste here — AFTER ticket is created
        $schedule = Schedule::where('bus_id', $request->bus_id)
            ->where('destination_id', $request->destination_id)
            ->whereIn('status', ['queued', 'on loading'])
            ->first();
    
        if ($schedule) {
            if ($schedule->status !== 'on loading') {
                $schedule->status = 'on loading';
                $schedule->save();
            }
    
            $sold = Ticket::where('bus_id', $request->bus_id)
                ->where('destination_id', $request->destination_id)
                ->count();
    
            if ($sold >= $schedule->bus->total_seats) {
                $schedule->status = 'departed';
                $schedule->save();
            }
        }
    
        return redirect()->route('ticketer.tickets.receipt', $ticket->id);
    }
    
    

    // Optional: Show the ticket receipt after it's created
    public function receipt($id)
    {
        $ticket = Ticket::with('destination')->findOrFail($id);
        return view('ticketer.tickets.receipt', compact('ticket'));
    }


    public function report()
{
    $tickets = Ticket::with('destination')
        ->where('creator_user_id', Auth::id())
        ->latest()
        ->get();

    return view('ticketer.tickets.report', compact('tickets'));
}
public function showScanForm()
{
    return view('ticketer.tickets.scan');
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

    $ticket->ticket_status = 'confirmed'; // or 'completed' if that's your final status
    $ticket->save();

    return redirect()->back()->with('success', 'Ticket status updated successfully.');
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


// tickets report for filter purpose
public function reports(Request $request)
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

    if ($request->filled('targa')) {
        $query->whereHas('bus', function ($q) use ($request) {
            $q->where('bus_id', 'like', '%' . $request->targa . '%');
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

}
