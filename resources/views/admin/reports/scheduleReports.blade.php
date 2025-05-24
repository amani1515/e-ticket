@extends('admin.layout.app')

@section('title', 'Schedule Reports')

@section('content')
    <h2 class="text-2xl font-bold mb-4">All Schedules</h2>
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