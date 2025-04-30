@extends('ticketer.layout.app')

@section('content')
<div class="container mx-auto mt-6">
    <h2 class="text-xl font-bold mb-4">Ticket Report</h2>

    @if($tickets->count())
        <table class="min-w-full bg-white border">
            <thead>
                <tr>
                    <th class="border px-4 py-2">Ticket ID</th>
                    <th class="border px-4 py-2">Passenger Name</th>
                    <th class="border px-4 py-2">Age</th>
                    <th class="border px-4 py-2">Destination</th>
                    <th class="border px-4 py-2">Bus</th>
                    <th class="border px-4 py-2">Departure</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Code</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td class="border px-4 py-2">{{ $ticket->id }}</td>
                        <td class="border px-4 py-2">{{ $ticket->passenger_name }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($ticket->age_status) }}</td>
                        <td class="border px-4 py-2">{{ $ticket->destination->start_from }} → {{ $ticket->destination->destination_name }}</td>
                        <td class="border px-4 py-2">{{ $ticket->bus_id }}</td>
                        <td class="border px-4 py-2">{{ $ticket->departure_datetime }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($ticket->ticket_status) }}</td>
                        <td class="border px-4 py-2">{{ $ticket->ticket_code }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tickets found.</p>
    @endif
</div>
@endsection
