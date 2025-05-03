@extends('mahberat.layout.app')

@section('content')
<div class="ml-64 px-6 py-6"> {{-- Adjust for sidebar --}}
    <h2 class="text-2xl font-bold mb-6">Schedule Queues by Destination</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($destinations as $destination)
            <div class="bg-white shadow rounded p-4">
                <h3 class="text-xl font-semibold mb-2">{{ $destination->start_from }} ➝ {{ $destination->destination_name }}</h3>
                <p class="mb-2 text-sm text-gray-600">Total Queued Buses: {{ $destination->schedules->count() }}</p>
                <ul class="list-disc pl-5 text-sm text-gray-700 space-y-1">
                    @foreach ($destination->schedules as $schedule)
                        <li>
                            <strong>Targa:</strong> {{ $schedule->bus->targa ?? 'N/A' }} —
                            <strong>Status:</strong> {{ ucfirst($schedule->status) }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</div>
@endsection
