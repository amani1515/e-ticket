@extends('admin.layout.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-yellow-700 mb-6">🚌 Passenger Report</h2>

    <!-- Filter Form -->
    <form method="GET" class="flex flex-wrap gap-4 mb-6 bg-yellow-50 p-4 rounded shadow-md">
        <input type="text" name="search" placeholder="Search by ID" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ request('search') }}">

        <select name="gender" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="">All Genders</option>
            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
        </select>

        <select name="destination_id" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="">All Destinations</option>
            @foreach($destinations as $dest)
                <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                    {{ $dest->destination_name }}
                </option>
            @endforeach
        </select>

        <select name="date_filter" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="">All Dates</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="this_week">This Week</option>
            <option value="this_month">This Month</option>
            <option value="this_year">This Year</option>
        </select>

        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded transition duration-300">🔍 Filter</button>
    </form>

    <!-- Export Button -->
    <div class="mb-4">
        <a href="{{ route('admin.passenger.report.export', request()->all()) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded transition duration-300 shadow">
            📥 Export to Excel
        </a>
    </div>

    <!-- Table -->
    @if($tickets->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm bg-white border border-yellow-300 shadow-md rounded">
                <thead class="bg-yellow-200 text-yellow-900">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Gender</th>
                        <th class="border px-4 py-2">Destination</th>
                        <th class="border px-4 py-2">Age Status</th>
                        <th class="border px-4 py-2">Bus ID</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-yellow-100 transition">
                            <td class="border px-4 py-2">{{ $ticket->id }}</td>
                            <td class="border px-4 py-2 font-medium text-gray-800">{{ $ticket->passenger_name }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $ticket->gender }}</td>
                            <td class="border px-4 py-2">{{ $ticket->destination->destination_name ?? '-' }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $ticket->age_status }}</td>
                            <td class="border px-4 py-2">{{ $ticket->bus_id }}</td>
                            <td class="border px-4 py-2 space-x-2">
                                <a href="{{ route('admin.passenger-report.show', $ticket->id) }}" class="text-blue-600 hover:underline">View</a>
                                <form action="{{ route('admin.passenger-report.destroy', $ticket->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tickets->links() }}
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded shadow mt-4">
            No passengers found based on the current filters.
        </div>
    @endif
</div>
@endsection
