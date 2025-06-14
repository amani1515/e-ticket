{{-- resources/views/traffic/schedule/result.blade.php --}}

@extends('traffic.layout.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 md:p-8 bg-white shadow-xl rounded-2xl">
    <h2 class="text-2xl md:text-3xl font-extrabold text-blue-700 mb-6 text-center tracking-wide">Schedule Details</h2>

    @if(isset($schedule))
        @if($schedule->status === 'departed')
        <div class="flex justify-center mb-8">
            <form id="wellgo-form" action="{{ route('traffic.wellgo', $schedule->id) }}" method="POST" class="w-full max-w-xs">
                @csrf
                <div id="slider-container" class="relative w-full h-12 bg-blue-100 rounded-full flex items-center cursor-pointer select-none shadow-inner">
                    <div id="slider-btn" class="absolute left-0 top-0 h-12 w-12 bg-gradient-to-br from-blue-600 to-blue-400 rounded-full flex items-center justify-center text-white text-xl font-bold shadow-lg transition-all duration-300 z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </div>
                    <span class="w-full text-center text-blue-700 font-semibold tracking-wide text-lg z-0">Slide to WellGo</span>
                </div>
                <button id="hidden-submit" type="submit" class="hidden"></button>
            </form>
        </div>
        <div id="confetti-container" class="fixed inset-0 pointer-events-none z-50" style="display:none;">
            <div class="flex items-center justify-center h-full">
                <div class="text-4xl md:text-5xl font-extrabold text-pink-600 drop-shadow-lg animate-bounce bg-white bg-opacity-80 px-6 py-4 rounded-xl">🎉 WellGo Success! 🎉</div>
            </div>
        </div>
        <style>
            .confetti {
                position: absolute;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                opacity: 0.8;
                animation: confetti-fall 1.5s linear forwards;
            }
            @keyframes confetti-fall {
                to {
                    transform: translateY(100vh) rotate(360deg);
                    opacity: 0.7;
                }
            }
        </style>
        <script>
            const sliderBtn = document.getElementById('slider-btn');
            const sliderContainer = document.getElementById('slider-container');
            const hiddenSubmit = document.getElementById('hidden-submit');
            let isDragging = false, startX = 0;

            sliderBtn.addEventListener('touchstart', function(e) {
                isDragging = true;
                startX = e.touches[0].clientX;
                document.body.style.userSelect = 'none';
            });

            sliderBtn.addEventListener('mousedown', function(e) {
                isDragging = true;
                startX = e.clientX;
                document.body.style.userSelect = 'none';
            });

            document.addEventListener('touchmove', function(e) {
                if (!isDragging) return;
                let dx = e.touches[0].clientX - startX;
                dx = Math.max(0, Math.min(dx, sliderContainer.offsetWidth - sliderBtn.offsetWidth));
                sliderBtn.style.left = dx + 'px';
                if (dx >= sliderContainer.offsetWidth - sliderBtn.offsetWidth - 5) {
                    isDragging = false;
                    showConfetti();
                    setTimeout(() => {
                        hiddenSubmit.click();
                    }, 1200);
                }
            });

            document.addEventListener('mousemove', function(e) {
                if (!isDragging) return;
                let dx = e.clientX - startX;
                dx = Math.max(0, Math.min(dx, sliderContainer.offsetWidth - sliderBtn.offsetWidth));
                sliderBtn.style.left = dx + 'px';
                if (dx >= sliderContainer.offsetWidth - sliderBtn.offsetWidth - 5) {
                    isDragging = false;
                    showConfetti();
                    setTimeout(() => {
                        hiddenSubmit.click();
                    }, 1200);
                }
            });

            document.addEventListener('touchend', function() {
                if (!isDragging) return;
                sliderBtn.style.left = '0px';
                isDragging = false;
                document.body.style.userSelect = '';
            });

            document.addEventListener('mouseup', function() {
                if (!isDragging) return;
                sliderBtn.style.left = '0px';
                isDragging = false;
                document.body.style.userSelect = '';
            });

            function showConfetti() {
                const confettiContainer = document.getElementById('confetti-container');
                confettiContainer.style.display = 'block';
                for (let i = 0; i < 40; i++) {
                    const conf = document.createElement('div');
                    conf.className = 'confetti';
                    conf.style.left = Math.random() * 100 + 'vw';
                    conf.style.top = '-20px';
                    conf.style.background = `hsl(${Math.random()*360},70%,60%)`;
                    conf.style.animationDelay = (Math.random() * 0.7) + 's';
                    confettiContainer.appendChild(conf);
                    setTimeout(() => conf.remove(), 1800);
                }
                setTimeout(() => {
                    confettiContainer.style.display = 'none';
                }, 1500);
            }
        </script>
        @endif

        <div class="divide-y divide-gray-200">
            <div class="flex flex-col md:flex-row md:justify-between items-center">
                <span class="font-semibold text-gray-600 text-xl md:text-2xl">Schedule UID:</span>
                <span class="text-gray-900 text-xl md:text-2xl break-all">{{ $schedule->schedule_uid }}</span>
                <span class="text-gray-900 font-bold px-4 py-2 text-2xl rounded-full 
                    @if($schedule->status === 'wellgo') bg-green-100 text-green-700 
                    @elseif($schedule->status === 'departed') bg-yellow-100 text-yellow-700 
                    @elseif($schedule->status === 'Cancelled') bg-red-100 text-red-700 
                    @else bg-gray-200 text-gray-700 @endif
                    animate-bounce mt-2 md:mt-0
                ">
                    {{ ucfirst($schedule->status) }}
                </span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between py-4 items-center">
                <span class="font-semibold text-gray-600 text-xl md:text-2xl">Date:</span>
                <span class="text-gray-900 text-xl md:text-2xl">{{ $schedule->date ?? ($schedule->scheduled_at ?? '-') }}</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between py-4 items-center">
                <span class="font-semibold text-gray-600 text-xl md:text-2xl">Wellgo :</span>
                <span class="text-gray-900 text-xl md:text-2xl">{{ $schedule->wellgo_at }}</span>
            </div>
            <div class="flex flex-col md:flex-row md:justify-between py-4 items-center">
                <span class="font-semibold text-gray-600 text-xl md:text-2xl">Wellgo By:</span>
                <span class="text-gray-900 text-xl md:text-2xl">{{ $schedule->traffic_name }}</span>
            </div>
           
            <div class="flex flex-col md:flex-row md:justify-between py-4 items-center">
                <span class="font-semibold text-gray-600 text-xl md:text-2xl">Destination:</span>
                <span class="text-gray-900 text-xl md:text-2xl">{{ $schedule->destination->destination_name }}</span>
            </div>
         
            <div class="py-4">
                <span class="font-semibold text-gray-600 block mb-2 text-xl md:text-2xl">Bus Information:</span>
                @if(isset($schedule->bus) && is_object($schedule->bus))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-gray-800 text-lg md:text-2xl">
                        <div><span class="font-semibold">Targa:</span> {{ $schedule->bus->targa }}</div>
                        <div><span class="font-semibold">Driver Name:</span> {{ $schedule->bus->driver_name }}</div>
                        <div><span class="font-semibold">Driver Phone:</span> {{ $schedule->bus->driver_phone }}</div>
                        <div><span class="font-semibold">Redat Name:</span> {{ $schedule->bus->redat_name }}</div>
                        <div><span class="font-semibold">Level:</span> {{ $schedule->bus->level }}</div>
                        <div><span class="font-semibold">Total Seats:</span> {{ $schedule->bus->total_seats }}</div>
                       
                        <div><span class="font-semibold">Model:</span> {{ $schedule->bus->model }}</div>
                        <div><span class="font-semibold">Bolo ID:</span> {{ $schedule->bus->bolo_id }}</div>
                        <div><span class="font-semibold">Motor Number:</span> {{ $schedule->bus->motor_number }}</div>
                        <div><span class="font-semibold">Color:</span> {{ $schedule->bus->color }}</div>
                    </div>
                @else
                    <span class="text-gray-400 text-2xl">No bus info</span>
                @endif
            </div>
            <div class="py-4">
                <span class="font-semibold text-gray-600 block mb-2 text-xl md:text-2xl">Destination Details:</span>
                @if(isset($schedule->destination) && is_object($schedule->destination))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-gray-800 text-lg md:text-2xl">
                       
                        <div><span class="font-semibold">From:</span> {{ $schedule->destination->start_from }}</div>
                         <div><span class="font-semibold">To:</span> {{ $schedule->destination->destination_name }}</div>
                        <div><span class="font-semibold">Tariff:</span> {{ $schedule->destination->tariff }} Birr</div>
                       
                    </div>
                @else
                    <span class="text-gray-400 text-2xl">No destination info</span>
                @endif
            </div>
        </div>
    @else
        <div class="text-center text-gray-500 text-xl py-12">
            <p class="mb-4">You have successfully verified the Car WellGo.</p>
            <a href="/home" class="text-blue-600 hover:underline font-semibold">Go back to schedule list</a>
        </div>
    @endif
</div>
@endsection
