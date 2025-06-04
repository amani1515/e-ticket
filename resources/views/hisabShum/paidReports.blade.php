@extends('hisabShum.layouts.app')

@section('title', 'Paid Reports')

@section('content')
    <h2 class="text-xl font-bold mb-4">Paid Bus Schedules</h2>
    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="px-4 py-2">Bus Targa</th>
                <th class="px-4 py-2">Bus Level</th>
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
                    <td class="border px-4 py-2">{{ $schedule->bus->level ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->destination->destination_name ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($schedule->status) }}</td>
                    <td class="border px-4 py-2">{{ $schedule->scheduled_at }}</td>
                    <td class="border px-4 py-2 space-x-2">
                        <a href="{{ route('hisabShum.certificate', $schedule->id) }}"
                           class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded"
                           target="_blank">
                            Certificate
                        </a>
                        <a href="{{ route('hisabShum.pay.schedule', $schedule->id) }}"
                          class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                            Pay
                        </a>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">No paid schedules found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
