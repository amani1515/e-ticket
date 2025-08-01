<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @extends('admin.layout.app')
</head>

<body>
    @section('content')
        <div class="min-h-screen bg-gray-50 p-8">
            <div class="max-w-7xl mx-auto">
                <!-- Welcome Header -->
                <h2 class="text-3xl font-bold text-gray-800 mb-6">👋 Welcome, {{ Auth::user()->name }}</h2>

                <!-- Quick Filter Buttons -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <button type="button" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200"
                        onclick="setQuickRange('today')">Today</button>
                    <button type="button" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200"
                        onclick="setQuickRange('this_month')">This Month</button>
                    <button type="button" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200"
                        onclick="setQuickRange('last_month')">Last Month</button>
                    <button type="button" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200"
                        onclick="setQuickRange('last_3_months')">Last 3 Months</button>
                    <button type="button" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200"
                        onclick="setQuickRange('this_week')">This Week</button>
                    <button type="button" class="bg-blue-100 text-blue-700 px-3 py-1 rounded hover:bg-blue-200"
                        onclick="setQuickRange('this_year')">This Year</button>
                </div>

                <!-- Date Filter -->
                <form id="filterForm" method="GET" class="mb-6 flex flex-col sm:flex-row sm:items-end gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition">
                            Filter
                        </button>
                    </div>
                </form>

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

                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 mt-8">
                    <h4 class="text-xl font-semibold text-gray-700 mb-4">👫 Passengers by Gender (Today)</h4>
                    <canvas id="genderChart" style="width:200px; height:200px; max-width:200px; max-height:200px;"></canvas>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition duration-300 mt-8">
                    <h4 class="text-xl font-semibold text-gray-700 mb-4">🧑‍🦱 Passengers by Age Status (Today)</h4>
                    <canvas id="ageStatusChart" height="80"></canvas>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Passengers by Destination
                const ctx = document.getElementById('passengerChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($destinationLabels) !!},
                        datasets: [{
                            label: 'Passengers',
                            data: {!! json_encode($passengerCounts) !!},
                            backgroundColor: {!! json_encode(
                                collect($destinationLabels)->map(function ($label, $i) {
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
                                }),
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

                // Passengers by Gender
                const genderCtx = document.getElementById('genderChart').getContext('2d');
                new Chart(genderCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($genderLabels) !!},
                        datasets: [{
                            data: {!! json_encode($genderCounts) !!},
                            backgroundColor: ['#3B82F6', '#F43F5E'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });

                // Passengers by Age Status
                const ageStatusCtx = document.getElementById('ageStatusChart').getContext('2d');
                new Chart(ageStatusCtx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($ageStatusLabels) !!},
                        datasets: [{
                            label: 'Passengers',
                            data: {!! json_encode($ageStatusCounts) !!},
                            backgroundColor: '#10B981',
                            borderRadius: 6
                        }]
                    },
                    options: {
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

                // Quick Filter Button Handler
                window.setQuickRange = function(type) {
                    const today = new Date();
                    let start, end;

                    if (type === 'today') {
                        start = end = today;
                    } else if (type === 'this_month') {
                        start = new Date(today.getFullYear(), today.getMonth(), 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    } else if (type === 'last_month') {
                        start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                        end = new Date(today.getFullYear(), today.getMonth(), 0);
                    } else if (type === 'last_3_months') {
                        start = new Date(today.getFullYear(), today.getMonth() - 2, 1);
                        end = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                    } else if (type === 'this_week') {
                        const day = today.getDay() || 7;
                        start = new Date(today);
                        start.setDate(today.getDate() - day + 1);
                        end = new Date(today);
                    } else if (type === 'this_year') {
                        start = new Date(today.getFullYear(), 0, 1);
                        end = new Date(today.getFullYear(), 11, 31);
                    }

                    // Format as yyyy-mm-dd
                    function fmt(d) {
                        return d.toISOString().slice(0, 10);
                    }
                    document.getElementById('start_date').value = fmt(start);
                    document.getElementById('end_date').value = fmt(end);

                    // Automatically submit the form
                    document.getElementById('filterForm').submit();
                }
            });
        </script>
    @endsection
</body>

</html>
