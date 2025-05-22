@extends('ticketer.layout.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Schedule Report</h2>
    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="px-4 py-2">Bus Targa</th>
                <th class="px-4 py-2">Destination</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Capacity</th>
                <th class="px-4 py-2">Boarding</th>
                <th class="px-4 py-2">Scheduled At</th>
                <!-- Add more columns as needed -->
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="border px-4 py-2">{{ $schedule->bus->targa ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->destination->destination_name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($schedule->status) }}</td>
                    <td class="border px-4 py-2">{{ $schedule->capacity }}</td>
                    <td class="border px-4 py-2">{{ $schedule->boarding }}</td>
                    <td class="border px-4 py-2">{{ $schedule->scheduled_at }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No schedules found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection