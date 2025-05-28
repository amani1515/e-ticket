@extends('admin.layout.app')
@section('content')
    <style>
        /* Card Animations & Hover Effects */
        .destination-card {
            transition: transform 0.25s cubic-bezier(.4,2,.6,1), box-shadow 0.25s;
            box-shadow: 0 2px 8px 0 rgba(255,193,7,0.10), 0 1.5px 4px 0 rgba(0,0,0,0.04);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }
        .destination-card:hover {
            transform: translateY(-8px) scale(1.04) rotate(-1deg);
            box-shadow: 0 8px 24px 0 rgba(255,193,7,0.18), 0 4px 12px 0 rgba(0,0,0,0.10);
            background: linear-gradient(120deg, #fffbe6 80%, #ffe082 100%);
        }
        .destination-card::after {
            content: '';
            display: block;
            position: absolute;
            left: -60px;
            top: 0;
            width: 40px;
            height: 100%;
            background: rgba(255, 235, 59, 0.08);
            transform: skewX(-20deg);
            transition: left 0.3s;
        }
        .destination-card:hover::after {
            left: 110%;
        }
        .destination-card .text-4xl {
            transition: color 0.2s;
        }
        .destination-card:hover .text-4xl {
            color: #f59e42;
        }
    </style>

    <div class="p-8">
        <h2 class="text-2xl font-bold mb-6">Total Report</h2>

        <!-- Date Filter Form -->
        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end bg-yellow-50 p-4 rounded shadow">
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700">From</label>
                <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}"
                    class="border border-yellow-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700">To</label>
                <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}"
                    class="border border-yellow-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded transition duration-300">
                Filter
            </button>
        </form>

        <!-- Total Summary Card -->
        <div class="mb-8">
            <div class="bg-yellow-200 border-2 border-yellow-400 rounded-lg shadow p-8 flex flex-col items-center w-full destination-card" style="box-shadow:0 4px 24px 0 #ffe08255;">
                <div class="text-xl font-bold mb-2 text-yellow-900">All Destinations Summary</div>
                <div class="text-5xl font-extrabold text-yellow-700 mb-1">
                    {{ $totalTickets ?? 0 }}
                </div>
                <div class="text-gray-700 mb-2">Total Passengers</div>
                <div class="w-full text-base text-gray-800 flex flex-wrap justify-center gap-8">
                    <div>👨 Male: <span class="font-semibold">{{ $totalMale ?? 0 }}</span></div>
                    <div>👩 Female: <span class="font-semibold">{{ $totalFemale ?? 0 }}</span></div>
                    <div>👥 Total: <span class="font-semibold">{{ ($totalMale ?? 0) + ($totalFemale ?? 0) }}</span></div>
                    <div>🚌 Total KM Covered: <span class="font-semibold">{{ $totalKm ?? 0 }}</span> km</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($destinations as $destination)
                <div class="bg-yellow-100 border border-yellow-300 rounded-lg shadow p-6 flex flex-col items-center destination-card">
                    <div class="text-sm text-gray-700 mb-1">
                        <span class="font-semibold">From:</span> {{ $destination->start_from ?? '-' }}
                        <span class="mx-2">→</span>
                        <span class="font-semibold">To:</span> {{ $destination->destination_name }}
                    </div>
                    <div class="text-4xl font-bold text-yellow-700 mb-1">
                        {{ $destination->tickets_count }}
                    </div>
                    <div class="text-gray-700 mb-2">Passengers</div>
                    <div class="w-full text-sm text-gray-800">
                        <div>👨 Male: <span class="font-semibold">{{ $destination->male_count ?? 0 }}</span></div>
                        <div>👩 Female: <span class="font-semibold">{{ $destination->female_count ?? 0 }}</span></div>
                        <div>👥 Total: <span class="font-semibold">{{ ($destination->male_count ?? 0) + ($destination->female_count ?? 0) }}</span></div>
                        <div>🚌 Total KM Covered: <span class="font-semibold">{{ $destination->total_km ?? 0 }}</span> km</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection