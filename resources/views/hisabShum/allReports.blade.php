<!-- filepath: resources/views/hisabShum/allReports.blade.php -->
@extends('hisabShum.layouts.app')

@section('title', 'All Reports')

@section('content')
    <h2 class="text-xl font-bold mb-4">Departed Schedules</h2>

    <!-- Filter Form -->
    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
        <div>
            <label class="block text-sm">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="border rounded px-2 py-1">
        </div>
        <div>
            <label class="block text-sm">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="border rounded px-2 py-1">
        </div>
        <div>
            <label class="block text-sm">Bus</label>
            <select name="bus_id" class="border rounded px-2 py-1">
                <option value="">All</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}" @selected(request('bus_id') == $bus->id)>{{ $bus->targa }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">Destination</label>
            <select name="destination_id" class="border rounded px-2 py-1">
                <option value="">All</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}" @selected(request('destination_id') == $destination->id)>{{ $destination->destination_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm">HisabShum</label>
            <select name="departed_by" class="border rounded px-2 py-1">
                <option value="">All</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @selected(request('departed_by') == $user->id)>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
            <a href="{{ route('hisabshum.allReports') }}" class="ml-2 text-sm text-gray-600 underline">Reset</a>
        </div>
    </form>

    <!-- Total Count Card -->
    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow">
        <strong>Total Departed Schedules:</strong> {{ $schedules->total() }}
    </div>

    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="px-4 py-2">Bus Targa</th>
                <th class="px-4 py-2">From</th>
                <th class="px-4 py-2">To</th>
                <th class="px-4 py-2">Capacity</th>
                <th class="px-4 py-2">Boarding</th>
                <th class="px-4 py-2">Departed By</th>
                <th class="px-4 py-2">Departed At</th>
                <th class="px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="border px-4 py-2">{{ $schedule->bus->targa ?? '-' }}</td>
                    <td class="border px-4 py-2">{{  $schedule->destination->start_from ?? '-'  }}</td>
                    <td class="border px-4 py-2">{{ $schedule->destination->destination_name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->capacity ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->boarding ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->departedBy->name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->departed_at ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($schedule->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">No departed schedules found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $schedules->withQueryString()->links() }}
    </div>
@endsection