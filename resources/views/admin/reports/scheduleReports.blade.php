@extends('admin.layout.app')

@section('title', 'Schedule Reports')

@section('content')
    <h2 class="text-2xl font-bold mb-4">All Schedules</h2>
    <form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-xs">Search (ID, UID, Bus ID)</label>
        <input type="text" name="search" value="{{ request('search') }}" class="border rounded px-2 py-1" placeholder="Search...">
    </div>
    <div>
        <label class="block text-xs">Destination</label>
        <select name="destination_id" class="border rounded px-2 py-1">
            <option value="">All</option>
            @foreach($destinations as $destination)
                <option value="{{ $destination->id }}" @selected(request('destination_id') == $destination->id)>{{ $destination->destination_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs">Bus</label>
        <select name="bus_id" class="border rounded px-2 py-1">
            <option value="">All</option>
            @foreach($buses as $bus)
                <option value="{{ $bus->id }}" @selected(request('bus_id') == $bus->id)>{{ $bus->targa }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs">Status</label>
        <select name="status" class="border rounded px-2 py-1">
            <option value="">All</option>
            @foreach(['queued','on loading','full','departed','cancelled','paid'] as $status)
                <option value="{{ $status }}" @selected(request('status') == $status)>{{ ucfirst($status) }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs">Scheduled By</label>
        <select name="scheduled_by" class="border rounded px-2 py-1">
            <option value="">All</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @selected(request('scheduled_by') == $user->id)>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-xs">From Date</label>
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="border rounded px-2 py-1">
    </div>
    <div>
        <label class="block text-xs">To Date</label>
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="border rounded px-2 py-1">
    </div>
    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
        <a href="{{ route('admin.schedule.reports') }}" class="ml-2 text-xs text-gray-600 underline">Reset</a>
    </div>
</form>
<form method="GET" class="mb-4 flex flex-wrap gap-4 items-end">
    <!-- ...existing filters... -->
    <div>
        <label class="block text-xs">Per Page</label>
        <select name="per_page" class="border rounded px-2 py-1" onchange="this.form.submit()">
            @foreach([10,20,30,40,100,200] as $size)
                <option value="{{ $size }}" @selected(request('per_page', 20) == $size)>{{ $size }}</option>
            @endforeach
        </select>
    </div>
    <!-- ...submit/reset buttons... -->
</form>
    <table class="min-w-full bg-white shadow rounded text-xs">
        <thead>
            <tr>
                <th class="px-2 py-1">ID</th>
                <th class="px-2 py-1">UID</th>
                <th class="px-2 py-1">Bus</th>
                <th class="px-2 py-1">Destination</th>
                <th class="px-2 py-1">Status</th>
                <th class="px-2 py-1">Capacity</th>
                <th class="px-2 py-1">Boarding</th>
                <th class="px-2 py-1">Scheduled By</th>
                <th class="px-2 py-1">Scheduled At</th>
                <th class="px-2 py-1">Paid By</th>
                <th class="px-2 py-1">Paid At</th>
                <th class="px-2 py-1">Departed By</th>
                <th class="px-2 py-1">Departed At</th>
                <th class="px-2 py-1">Created At</th>
                <th class="px-2 py-1">Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="border px-2 py-1">{{ $schedule->id }}</td>
                    <td class="border px-2 py-1">{{ $schedule->schedule_uid }}</td>
                    <td class="border px-2 py-1">{{ $schedule->bus->targa ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $schedule->destination->destination_name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $schedule->status }}</td>
                    <td class="border px-2 py-1">{{ $schedule->capacity }}</td>
                    <td class="border px-2 py-1">{{ $schedule->boarding }}</td>
                    <td class="border px-2 py-1">{{ $schedule->scheduledBy->name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $schedule->scheduled_at }}</td>
                    <td class="border px-2 py-1">{{ $schedule->paidBy->name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $schedule->paid_at ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $schedule->departedBy->name ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $schedule->departed_at ?? '-' }}</td>
                    <td class="border px-2 py-1">{{ $schedule->created_at }}</td>
                    <td class="border px-2 py-1">{{ $schedule->updated_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="15" class="text-center py-4">No schedules found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $schedules->links() }}
    </div>
@endsection