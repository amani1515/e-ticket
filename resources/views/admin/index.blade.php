@extends('admin.layout.app')

@section('content')
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-6">Welcome, {{ Auth::user()->name }}</h2>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            <div class="bg-white p-4 rounded shadow">
                <h4 class="text-lg font-semibold">Passengers Today</h4>
                <p class="text-xl">{{ $passengersToday }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h4 class="text-lg font-semibold">Total Users</h4>
                <p class="text-xl">{{ $totalUsers }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h4 class="text-lg font-semibold">Total Destinations</h4>
                <p class="text-xl">{{ $totalDestinations }}</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h4 class="text-lg font-semibold">Today's Tax Total</h4>
                <p class="text-xl">{{ $taxTotal }} ETB</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h4 class="text-lg font-semibold">Today's Service Fee</h4>
                <p class="text-xl">{{ $serviceFeeTotal }} ETB</p>
            </div>
            <div class="bg-white p-4 rounded shadow">
                <h4 class="text-lg font-semibold">Total Revenue Today</h4>
                <p class="text-xl">{{ $totalRevenue }} ETB</p>
            </div>
        </div>

        <!-- Graph Section -->
        <div class="bg-white p-6 rounded shadow">
            <h4 class="text-lg font-semibold mb-4">Passengers by Destination (Today)</h4>
            <canvas id="passengerChart" height="100"></canvas>
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
                    backgroundColor: '#3B82F6',
                }]
            }
        });
    </script>
@endsection
