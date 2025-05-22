@extends('hisabShum.layouts.app')

@section('title', 'Paid Reports')

@section('content')
    <h2 class="text-xl font-bold mb-4">Paid Bus Schedules</h2>
    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="px-4 py-2">Bus Targa</th>
                <th class="px-4 py-2">Destination</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Scheduled At</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="border px-4 py-2">{{ $schedule->bus->targa ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->destination->destination_name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($schedule->status) }}</td>
                    <td class="border px-4 py-2">{{ $schedule->scheduled_at }}</td>
                  <td class="border px-4 py-2">
                        <a href="{{ route('hisabShum.certificate', $schedule->id) }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded"
                        target="_blank">
                            Give Departed Certificate
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">No paid schedules found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection