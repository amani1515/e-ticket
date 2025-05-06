{{-- filepath: resources/views/admin/reports/bus_reports.blade.php --}}
@extends('admin.layout.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Bus Reports</h2>

    <table class="w-full border text-sm bg-white shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Bus</th>
                <th class="border px-4 py-2">Destination</th>
                <th class="border px-4 py-2">Scheduled By</th>
                <th class="border px-4 py-2">Scheduled At</th>
                <th class="border px-4 py-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($schedules as $schedule)
            <tr>
                <td class="border px-4 py-2">{{ $schedule->id }}</td>
                <td class="border px-4 py-2">{{ $schedule->bus->targa ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $schedule->destination->destination_name ?? '-' }}</td>
                <td class="border px-4 py-2">{{ $schedule->scheduled_by }}</td>
                <td class="border px-4 py-2">{{ $schedule->scheduled_at }}</td>
                <td class="border px-4 py-2">{{ ucfirst($schedule->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection