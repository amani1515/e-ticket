<?php

namespace App\Http\Controllers\Ticketer;

use App\Models\Ticket;
use App\Models\Destination;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Show the create ticket form
    public function create()
    {
        $destinations = Destination::all(); // Get all destinations
        return view('ticketer.tickets.create', compact('destinations'));
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
}
