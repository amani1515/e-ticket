@extends('mahberat.layout.app')

@section('content')
<div class="px-2 py-6">
    <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
        <svg class="w-7 h-7 text-yellow-500 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h.01" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h.01" />
        </svg>
        Schedule Queues by Destination
    </h2>

    @php
        $busColors = ['#fbbf24', '#60a5fa', '#34d399', '#f87171', '#a78bfa', '#f472b6', '#facc15', '#38bdf8', '#fb7185', '#4ade80'];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        @forelse ($schedules as $destinationId => $groupedSchedules)
            @php
                $destination = $groupedSchedules->first()->destination;
                $busColor = $busColors[$loop->index % count($busColors)];
            @endphp
            <div class="bg-white shadow-lg rounded-xl p-4 sm:p-6 hover:shadow-2xl transition duration-300 group relative border border-yellow-100 hover:border-yellow-400 overflow-hidden">
                <!-- Animated Bus/Car SVG -->
                <div class="absolute -top-6 -right-10 w-20 h-12 sm:w-24 sm:h-16 pointer-events-none select-none animate-bus-move opacity-70">
                    <svg viewBox="0 0 64 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
                        <rect x="4" y="10" width="56" height="14" rx="4" fill="{{ $busColor }}"/>
                        <rect x="8" y="14" width="12" height="6" rx="2" fill="#fff"/>
                        <rect x="24" y="14" width="12" height="6" rx="2" fill="#fff"/>
                        <rect x="40" y="14" width="12" height="6" rx="2" fill="#fff"/>
                        <circle cx="16" cy="26" r="4" fill="#374151"/>
                        <circle cx="48" cy="26" r="4" fill="#374151"/>
                        <rect x="56" y="18" width="4" height="6" rx="1" fill="#f59e42"/>
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold mb-2 flex flex-wrap items-center gap-2">
                    <span class="transition group-hover:text-yellow-700">{{ $destination->start_from }}</span>
                    <span class="mx-2 text-gray-400">➝</span>
                    <span class="transition group-hover:text-yellow-700">{{ $destination->destination_name }}</span>
                </h3>
                <p class="mb-3 text-xs sm:text-sm text-gray-600 flex items-center gap-2 flex-wrap">
                    <span class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold animate-pulse">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3" />
                        </svg>
                        Total Queued Buses: {{ $groupedSchedules->count() }}
                    </span>
                </p>
                <ul class="space-y-2">
                    @forelse ($groupedSchedules as $schedule)
                        <li class="flex flex-col sm:flex-row sm:items-center justify-between bg-gray-50 rounded px-3 py-2 hover:bg-yellow-50 transition group">
                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                                <span class="font-semibold text-gray-800">Targa:</span>
                                <span class="text-gray-700">{{ $schedule->bus->targa ?? 'N/A' }}</span>
                                <span class="text-xs text-gray-400">{{ $schedule->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-2 sm:mt-0">
                                @if($schedule->status === 'queued')
                                    <span title="Queued" class="inline-flex items-center px-2 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-bold animate-pulse shadow">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="10"/></svg>
                                        <span class="hidden sm:inline">Queued</span>
                                    </span>
                                @elseif($schedule->status === 'on loading')
                                    <span title="On Loading" class="inline-flex items-center px-2 py-1 bg-green-200 text-green-800 rounded-full text-xs font-bold animate-bounce shadow">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><rect width="20" height="20" rx="5"/></svg>
                                        <span class="hidden sm:inline">On Loading</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-bold">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                @endif
                            </div>
                        </li>
                    @empty
                        <li class="text-gray-400 italic">No queued buses.</li>
                    @endforelse
                </ul>
            </div>
        @empty
            <p class="text-gray-500">No schedules found for your Mahberat.</p>
        @endforelse
    </div>
</div>

<style>
@keyframes spin-slow {
    0% { transform: rotate(0deg);}
    100% { transform: rotate(360deg);}
}
.animate-spin-slow {
    animation: spin-slow 3s linear infinite;
}
@keyframes bus-move {
    0% {
        right: -100px;
        opacity: 0;
    }
    10% {
        opacity: 1;
    }
    80% {
        opacity: 1;
    }
    100% {
        right: 100%;
        opacity: 0;
    }
}
.animate-bus-move {
    animation: bus-move 6s linear infinite;
    position: absolute;
}
</style>
@endsection
