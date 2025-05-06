@extends('admin.layout.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Passenger Report</h2>

    <form method="GET" class="flex flex-wrap gap-4 mb-6">
        <input type="text" name="search" placeholder="Search by ID" class="p-2 border rounded" value="{{ request('search') }}">
        
        <select name="gender" class="p-2 border rounded">
            <option value="">All Genders</option>
            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
        </select>

        <select name="destination_id" class="p-2 border rounded">
            <option value="">All Destinations</option>
            @foreach($destinations as $dest)
                <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                    {{ $dest->destination_name }}
                </option>
            @endforeach
        </select>

        <select name="date_filter" class="p-2 border rounded">
            <option value="">All Dates</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="this_week">This Week</option>
            <option value="this_month">This Month</option>
            <option value="this_year">This Year</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
    </form>
   
    <a href="{{ route('admin.passenger.report.export', request()->all()) }}" class="btn btn-success">Export to Excel</a>
     

    @if($tickets->count())
        <table class="w-full border text-sm bg-white shadow">
            <thead class="bg-gray-200">
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
                    <tr>
                        <td class="border px-4 py-2">{{ $ticket->id }}</td>
                        <td class="border px-4 py-2">{{ $ticket->passenger_name }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($ticket->gender) }}</td>
                        <td class="border px-4 py-2">{{ $ticket->destination->destination_name ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($ticket->age_status) }}</td>
                        <td class="border px-4 py-2">{{ $ticket->bus_id }}</td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('admin.passenger-report.show', $ticket->id) }}" class="text-blue-500 hover:underline">View</a>
                            <form action="{{ route('admin.passenger-report.destroy', $ticket->id) }}" method="POST" class="inline-block ml-2">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Are you sure?')" class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $tickets->links() }}
        </div>
    @else
        <p>No passengers found.</p>
    @endif
</div>
@endsection
