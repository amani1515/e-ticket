<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bus Queue Display</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <style>
        @keyframes spin-slow {
            0% { transform: rotate(0deg);}
            100% { transform: rotate(360deg);}
        }
        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }
        @keyframes bus-move {
            0% { right: -100px; opacity: 0; }
            10% { opacity: 1; }
            80% { opacity: 1; }
            100% { right: 100%; opacity: 0; }
        }
        .animate-bus-move {
            animation: bus-move 6s linear infinite;
            position: absolute;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="container mx-auto px-2 py-8">
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
        $destArray = $destinations->values(); // Ensure it's a collection with numeric keys
    @endphp

    <div id="card-rotator" class="grid grid-cols-1 md:grid-cols-2 gap-10">
        {{-- Cards will be injected here --}}
    </div>
    <!-- Pagination Indicator -->
    <div class="flex justify-center mt-10">
        <span id="page-indicator" class="text-xl font-bold text-yellow-800 bg-yellow-200 px-6 py-3 rounded-full shadow-lg tracking-wide"></span>
    </div>
</div>

<script>
    // Prepare destinations data for JS
    const destinations = @json($destArray);
    const busColors = @json($busColors);

    let currentIndex = 0;
    const cardsPerView = 4; // 2x2 grid
    const totalPages = Math.ceil(destinations.length / cardsPerView);
    const intervalMs = 15000; // 15 seconds

    function renderCards() {
        const container = document.getElementById('card-rotator');
        container.innerHTML = '';
        for (let i = 0; i < cardsPerView; i++) {
            const idx = (currentIndex + i) % destinations.length;
            const dest = destinations[idx];
            const color = busColors[idx % busColors.length];

            // Build schedules HTML
            let schedulesHtml = '';
            if (dest.schedules && dest.schedules.length > 0) {
                dest.schedules.forEach(schedule => {
                    if (['queued', 'on loading'].includes(schedule.status)) {
                        schedulesHtml += `
                        <li class="bg-gray-100 rounded px-5 py-3 flex flex-col md:flex-row justify-between group hover:bg-yellow-50 transition text-lg">
                            <div class="flex flex-col md:flex-row gap-2 md:items-center">
                                <span class="font-semibold text-gray-900">Targa:</span>
                                <span>${schedule.bus?.targa ?? 'N/A'}</span>
                                <span class="text-base text-gray-400">${schedule.created_at_human ?? ''}</span>
                            </div>
                            <div class="flex items-center gap-3 mt-2 md:mt-0">
                                ${
                                    schedule.status === 'queued'
                                    ? `<span class="bg-yellow-200 text-yellow-900 px-3 py-1 rounded-full text-base font-bold animate-pulse">Queued</span>`
                                    : `<span class="bg-green-200 text-green-900 px-3 py-1 rounded-full text-base font-bold animate-bounce">On Loading</span>`
                                }
                            </div>
                        </li>`;
                    }
                });
                if (!schedulesHtml) {
                    schedulesHtml = `<li class="text-gray-400 italic text-lg">No queued buses.</li>`;
                }
            } else {
                schedulesHtml = `<li class="text-gray-400 italic text-lg">No queued buses.</li>`;
            }

            // Card HTML (larger size)
            container.innerHTML += `
            <div class="bg-white shadow-2xl rounded-3xl p-8 border-2 border-yellow-300 hover:border-yellow-500 transition relative overflow-hidden min-h-[350px] flex flex-col justify-between">
                <div class="absolute -top-8 -right-14 w-32 h-20 pointer-events-none animate-bus-move opacity-70">
                    <svg viewBox="0 0 64 32" class="w-full h-full">
                        <rect x="4" y="10" width="56" height="14" rx="4" fill="${color}"/>
                        <rect x="8" y="14" width="12" height="6" rx="2" fill="#fff"/>
                        <rect x="24" y="14" width="12" height="6" rx="2" fill="#fff"/>
                        <rect x="40" y="14" width="12" height="6" rx="2" fill="#fff"/>
                        <circle cx="16" cy="26" r="4" fill="#374151"/>
                        <circle cx="48" cy="26" r="4" fill="#374151"/>
                        <rect x="56" y="18" width="4" height="6" rx="1" fill="#f59e42"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold mb-4 flex flex-wrap items-center gap-3">
                    <span class="text-yellow-700">
                        <svg class="inline w-7 h-7 animate-spin-slow" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h.01" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h.01" />
                        </svg>
                    </span>
                    <span>${dest.start_from}</span>
                    <span class="mx-2 text-gray-400">➝</span>
                    <span>${dest.destination_name}</span>
                </h3>
                <p class="mb-4 text-lg text-gray-700">
                    <span class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-800 rounded-full font-bold animate-pulse text-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 17l4 4 4-4m0-5V3" />
                        </svg>
                        Total Queued Buses: ${dest.schedules ? dest.schedules.filter(s => ['queued', 'on loading'].includes(s.status)).length : 0}
                    </span>
                </p>
                <ul class="space-y-3">
                    ${schedulesHtml}
                </ul>
            </div>
            `;
        }

        // Update page indicator
        const pageIndicator = document.getElementById('page-indicator');
        const currentPage = Math.floor(currentIndex / cardsPerView) + 1;
        pageIndicator.textContent = `${currentPage} of ${totalPages}`;
    }

    // Helper: convert created_at to human readable (if not already)
    if (destinations.length && destinations[0].schedules && destinations[0].schedules.length) {
        destinations.forEach(dest => {
            dest.schedules.forEach(sch => {
                if (!sch.created_at_human && sch.created_at) {
                    // fallback: just show date string
                    sch.created_at_human = sch.created_at;
                }
            });
        });
    }

    renderCards();
    setInterval(() => {
        currentIndex = (currentIndex + cardsPerView) % destinations.length;
        renderCards();
    }, intervalMs);
</script>

</body>
</html>
