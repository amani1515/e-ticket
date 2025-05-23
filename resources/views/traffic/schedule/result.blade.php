{{-- resources/views/traffic/schedule/result.blade.php --}}

@extends('traffic.layout.app')

@section('content')
<div class="max-w-xl mx-auto mt-12 p-8 bg-white shadow-lg rounded-2xl">
    <h2 class="text-3xl font-extrabold text-blue-700 mb-6 text-center tracking-wide">Schedule Details</h2>

    <div class="divide-y divide-gray-200">
        <div class="flex justify-between py-4">
            <span class="font-semibold text-gray-600">Schedule UID:</span>
            <span class="text-gray-900">{{ $schedule->schedule_uid }}</span>
            <span class="text-gray-900 font-bold px-3 py-1 rounded-full 
                @if($schedule->status === 'Active') bg-green-100 text-green-700 
                @elseif($schedule->status === 'Pending') bg-yellow-100 text-yellow-700 
                @elseif($schedule->status === 'Cancelled') bg-red-100 text-red-700 
                @else bg-gray-200 text-gray-700 @endif
                animate-bounce
            ">
                {{ ucfirst($schedule->status) }}
            </span>
        </div>
        <div class="flex justify-between py-4">
            <span class="font-semibold text-gray-600">Date:</span>
            <span class="text-gray-900">{{ $schedule->date ?? ($schedule->scheduled_at ?? '-') }}</span>
        </div>
        <div class="flex justify-between py-4">
            <span class="font-semibold text-gray-600">Departure:</span>
            <span class="text-gray-900">
                {{ $schedule->departure ?? ($schedule->destination->start_from ?? '-') }}
            </span>
        </div>

        <div class="py-4">
            <span class="font-semibold text-gray-600 block mb-1">Bus Information:</span>
            @if(isset($schedule->bus) && is_object($schedule->bus))
                <div class="ml-4 space-y-1 text-gray-800">
                    <div><span class="font-semibold">Targa:</span> {{ $schedule->bus->targa }}</div>
                    <div><span class="font-semibold">Driver Name:</span> {{ $schedule->bus->driver_name }}</div>
                    <div><span class="font-semibold">Driver Phone:</span> {{ $schedule->bus->driver_phone }}</div>
                    <div><span class="font-semibold">Redat Name:</span> {{ $schedule->bus->redat_name }}</div>
                    <div><span class="font-semibold">Level:</span> {{ $schedule->bus->level }}</div>
                    <div><span class="font-semibold">Total Seats:</span> {{ $schedule->bus->total_seats }}</div>
                    <div><span class="font-semibold">Model Year:</span> {{ $schedule->bus->model_year }}</div>
                    <div><span class="font-semibold">Model:</span> {{ $schedule->bus->model }}</div>
                    <div><span class="font-semibold">Bolo ID:</span> {{ $schedule->bus->bolo_id }}</div>
                    <div><span class="font-semibold">Motor Number:</span> {{ $schedule->bus->motor_number }}</div>
                    <div><span class="font-semibold">Color:</span> {{ $schedule->bus->color }}</div>
                </div>
            @else
                <span class="text-gray-400">No bus info</span>
            @endif
        </div>
        <div class="py-4">
            <span class="font-semibold text-gray-600 block mb-1">Destination Details:</span>
            @if(isset($schedule->destination) && is_object($schedule->destination))
                <div class="ml-4 space-y-1 text-gray-800">
                    <div><span class="font-semibold">Name:</span> {{ $schedule->destination->destination_name }}</div>
                    <div><span class="font-semibold">From:</span> {{ $schedule->destination->start_from }}</div>
                    <div><span class="font-semibold">Tariff:</span> {{ $schedule->destination->tariff }}</div>
                    <div><span class="font-semibold">Tax:</span> {{ $schedule->destination->tax }}</div>
                    <div><span class="font-semibold">Service Fee:</span> {{ $schedule->destination->service_fee }}</div>
                </div>
            @else
                <span class="text-gray-400">No destination info</span>
            @endif
        </div>

        @if($schedule->status === 'departed')
        <div class="py-6 flex justify-center">
            <form id="wellgo-form" action="{{ route('traffic.wellgo', $schedule->id) }}" method="POST" class="w-full max-w-xs">
                @csrf
                <div id="slider-container" class="relative w-full h-12 bg-blue-100 rounded-full flex items-center cursor-pointer select-none">
                    <div id="slider-btn" class="absolute left-0 top-0 h-12 w-12 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-lg transition-all duration-300 z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <span class="w-full text-center text-blue-700 font-semibold tracking-wide text-lg z-0">Slide to WellGo</span>
                </div>
                <button id="hidden-submit" type="submit" class="hidden"></button>
            </form>
        </div>
        <script>
            const sliderBtn = document.getElementById('slider-btn');
            const sliderContainer = document.getElementById('slider-container');
            const hiddenSubmit = document.getElementById('hidden-submit');
            let isDragging = false, startX = 0;

            sliderBtn.addEventListener('mousedown', function(e) {
                isDragging = true;
                startX = e.clientX;
                document.body.style.userSelect = 'none';
            });

            document.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                let dx = e.clientX - startX;
                dx = Math.max(0, Math.min(dx, sliderContainer.offsetWidth - sliderBtn.offsetWidth));
                sliderBtn.style.left = dx + 'px';
                if (dx >= sliderContainer.offsetWidth - sliderBtn.offsetWidth - 5) {
                    isDragging = false;
                    hiddenSubmit.click();
                }
            });

            document.addEventListener('mouseup', function() {
                if (!isDragging) return;
                sliderBtn.style.left = '0px';
                isDragging = false;
                document.body.style.userSelect = '';
            });

            // Refresh page after form submit
            document.getElementById('wellgo-form').addEventListener('submit', function() {
                setTimeout(function() {
                    window.location.reload();
                }, 500);
            });
        </script>
        @endif
    </div>
</div>
@endsection
