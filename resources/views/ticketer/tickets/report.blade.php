@extends('ticketer.layout.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 p-6">
        <h2 class="text-2xl font-semibold mb-6">Ticket Report</h2>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('ticketer.tickets.report') }}" class="mb-6 flex space-x-4">
            <div>
                <label for="destination_id" class="block text-sm font-medium text-gray-700">Destination</label>
                <select name="destination_id" id="destination_id" class="w-full p-2 border rounded">
                    <option value="">All Destinations</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                            {{ $destination->destination_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="ticket_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="ticket_status" id="ticket_status" class="w-full p-2 border rounded">
                    <option value="">All Statuses</option>
                    <option value="created" {{ request('ticket_status') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="confirmed" {{ request('ticket_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                </select>
            </div>

            <div>
                <label for="targa" class="block text-sm font-medium text-gray-700">Targa</label>
                <input type="text" name="targa" id="targa" value="{{ request('targa') }}" class="w-full p-2 border rounded" placeholder="Search by Targa">
            </div>

            <div>
                <label for="date_filter" class="block text-sm font-medium text-gray-700">Date</label>
                <select name="date_filter" id="date_filter" class="w-full p-2 border rounded">
                    <option value="">All Dates</option>
                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="two_days_before" {{ request('date_filter') == 'two_days_before' ? 'selected' : '' }}>2 Days Before</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
            </div>
        </form>

        <!-- Ticket Table -->
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
            {{ $tickets->links() }} <!-- Pagination links -->
        @else
            <p class="text-center text-gray-500">No tickets found.</p>
        @endif
    </div>
</div>
@endsection