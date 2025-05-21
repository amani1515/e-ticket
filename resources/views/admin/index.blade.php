@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gray-50 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Welcome Header -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">👋 Welcome, {{ Auth::user()->name }}</h2>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h4 class="text-lg font-semibold text-gray-700">Passengers Today</h4>
                <p class="text-2xl text-blue-600 mt-2 font-bold">{{ $passengersToday }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h4 class="text-lg font-semibold text-gray-700">Total Users</h4>
                <p class="text-2xl text-blue-600 mt-2 font-bold">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h4 class="text-lg font-semibold text-gray-700">Total Destinations</h4>
                <p class="text-2xl text-blue-600 mt-2 font-bold">{{ $totalDestinations }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h4 class="text-lg font-semibold text-gray-700">Today's Tax Total</h4>
                <p class="text-2xl text-blue-600 mt-2 font-bold">{{ $taxTotal }} ETB</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h4 class="text-lg font-semibold text-gray-700">Today's Service Fee</h4>
                <p class="text-2xl text-blue-600 mt-2 font-bold">{{ $serviceFeeTotal }} ETB</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
                <h4 class="text-lg font-semibold text-gray-700">Total Revenue Today</h4>
                <p class="text-2xl text-blue-600 mt-2 font-bold">{{ $totalRevenue }} ETB</p>
            </div>
        </div>

        <!-- Graph Section -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300">
            <h4 class="text-xl font-semibold text-gray-700 mb-4">📊 Passengers by Destination (Today)</h4>
            <canvas id="passengerChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('passengerChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($destinationLabels) !!},
            datasets: [{
                label: 'Passengers',
                data: {!! json_encode($passengerCounts) !!},
                backgroundColor: {!! json_encode(
    collect($destinationLabels)->map(function($label, $i) {
        $colors = [
            '#3B82F6', // blue
            '#F59E42', // orange
            '#10B981', // green
            '#F43F5E', // pink/red
            '#6366F1', // indigo
            '#FBBF24', // yellow
            '#06B6D4', // cyan
            '#A21CAF', // purple
            '#84CC16', // lime
            '#E11D48', // rose
        ];
        return $colors[$i % count($colors)];
    })
) !!},
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#4B5563'
                    }
                },
                x: {
                    ticks: {
                        color: '#4B5563'
                    }
                }
            }
        }
    });
</script>
@endsection
