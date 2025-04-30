@extends('ticketer.layout.app')

@section('content')
<div class="container mx-auto mt-6 px-4">
    <h2 class="text-2xl font-semibold mb-6">Ticket Report</h2>

    @if($tickets->count())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow rounded border">
                <thead class="bg-gray-100">
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
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $ticket->id }}</td>
                            <td class="border px-4 py-2">{{ $ticket->passenger_name }}</td>
                            <td class="border px-4 py-2">{{ ucfirst($ticket->age_status) }}</td>
                            <td class="border px-4 py-2">
                                {{ $ticket->destination->start_from }} → {{ $ticket->destination->destination_name }}
                            </td>
                            <td class="border px-4 py-2">{{ $ticket->bus_id }}</td>
                            <td class="border px-4 py-2">{{ $ticket->departure_datetime }}</td>
                            <td class="border px-4 py-2">
                                @if($ticket->ticket_status === 'created')
                                    <span class="bg-red-100 text-red-700 text-sm px-3 py-1 rounded-full">Created</span>
                                @elseif($ticket->ticket_status === 'confirmed')
                                    <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">Confirmed</span>
                                @else
                                    <span class="bg-gray-100 text-gray-700 text-sm px-3 py-1 rounded-full">{{ ucfirst($ticket->ticket_status) }}</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ $ticket->ticket_code }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-center text-gray-500">No tickets found.</p>
    @endif
</div>
@endsection
