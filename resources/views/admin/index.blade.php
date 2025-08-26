<!--
    Admin Dashboard View
    -------------------
    This Blade file displays the main admin dashboard, including:
    - Welcome header for the logged-in admin
    - Quick filter buttons for date ranges
    - Date filter form for custom range
    - Summary cards for key statistics (passengers, users, revenue, etc.)
    - Multiple charts (using Chart.js) for visualizing:
        - Passengers by destination
        - Passengers by gender
        - Passengers by age status (with Amharic translation)
        - Passengers by disability status
    - JavaScript for chart rendering and quick filter logic
    All data is injected from the AdminController.
-->
@extends('admin.layout.app')

@section('content')
    @php
        // Amharic translations for age status, used in the age status chart
        $ageStatusAmharic = [
            'baby' => 'ታዳጊ',
            'adult' => 'ወጣት',
            'middle_aged' => 'ጎልማሳ',
            'senior' => 'አዛዉንት',
        ];
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100 p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Header -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-amber-900 mb-2">🎯 Admin Dashboard</h1>
                <p class="text-amber-700 text-lg">Welcome back, <span class="font-semibold">{{ Auth::user()->name }}</span></p>
                <p class="text-amber-600 text-sm">{{ date('l, F j, Y') }}</p>
            </div>

            <!-- Quick Filter Buttons -->
            <div class="flex flex-wrap gap-2 mb-6">
                <button type="button" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl hover:bg-amber-200 transition-colors duration-200 font-medium shadow-sm"
                    onclick="setQuickRange('today')">Today</button>
                <button type="button" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl hover:bg-amber-200 transition-colors duration-200 font-medium shadow-sm"
                    onclick="setQuickRange('this_month')">This Month</button>
                <button type="button" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl hover:bg-amber-200 transition-colors duration-200 font-medium shadow-sm"
                    onclick="setQuickRange('last_month')">Last Month</button>
                <button type="button" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl hover:bg-amber-200 transition-colors duration-200 font-medium shadow-sm"
                    onclick="setQuickRange('last_3_months')">Last 3 Months</button>
                <button type="button" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl hover:bg-amber-200 transition-colors duration-200 font-medium shadow-sm"
                    onclick="setQuickRange('this_week')">This Week</button>
                <button type="button" class="bg-amber-100 text-amber-700 px-4 py-2 rounded-xl hover:bg-amber-200 transition-colors duration-200 font-medium shadow-sm"
                    onclick="setQuickRange('this_year')">This Year</button>
            </div>



            <!-- Date Filter Form -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Date Filter
                    </h2>
                </div>
                <div class="p-6">
                    <form id="filterForm" method="GET" class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="start_date" class="block text-sm font-semibold text-amber-800 mb-2">Start Date</label>
                            <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}"
                                class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                        </div>
                        <div class="flex-1">
                            <label for="end_date" class="block text-sm font-semibold text-amber-800 mb-2">End Date</label>
                            <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}"
                                class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg">
                                Apply Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-blue-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Passengers Today</h3>
                            <p class="text-3xl font-bold text-blue-600 mt-2">{{ $passengersToday }}</p>
                            <p class="text-xs text-gray-400 mt-1">Active travelers</p>
                        </div>
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-green-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Total Users</h3>
                            <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalUsers }}</p>
                            <p class="text-xs text-gray-400 mt-1">System accounts</p>
                        </div>
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-purple-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Total Destinations</h3>
                            <p class="text-3xl font-bold text-purple-600 mt-2">{{ $totalDestinations }}</p>
                            <p class="text-xs text-gray-400 mt-1">Available routes</p>
                        </div>
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->usertype !== 'headoffice')
                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-amber-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Today's Tax</h3>
                            <p class="text-3xl font-bold text-amber-600 mt-2">{{ $taxTotal }} <span class="text-lg">ETB</span></p>
                            <p class="text-xs text-gray-400 mt-1">Government tax</p>
                        </div>
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-indigo-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Service Fee</h3>
                            <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $serviceFeeTotal }} <span class="text-lg">ETB</span></p>
                            <p class="text-xs text-gray-400 mt-1">Platform fee</p>
                        </div>
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 border-l-4 border-red-500 hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Total Revenue</h3>
                            <p class="text-3xl font-bold text-red-600 mt-2">{{ $totalRevenue }} <span class="text-lg">ETB</span></p>
                            <p class="text-xs text-gray-400 mt-1">Today's earnings</p>
                        </div>
                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Passengers by Destination -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Passengers by Destination
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="passengerChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Gender Distribution -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Gender Distribution
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="genderChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Age Distribution -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Age Distribution
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="ageStatusChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Accessibility Status -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Accessibility Status
                        </h3>
                    </div>
                    <div class="p-6">
                        <canvas id="disabilityChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Passengers by Destination
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
                                    '#3B82F6',
                                    '#F59E42',
                                    '#10B981',
                                    '#F43F5E',
                                    '#6366F1',
                                    '#FBBF24',
                                    '#06B6D4',
                                    '#A21CAF',
                                    '#84CC16',
                                    '#E11D48',
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

            // 2. Passengers by Gender
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

            // ✅ 3. Passengers by Age Status (custom colors per status)
            const ageColors = {
                'baby': '#FBBF24',
                'adult': '#3B82F6',
                'middle_aged': '#06B6D4',
                'senior': '#A21CAF'
            };

            // English labels from backend
            const ageStatusLabels = {!! json_encode($ageStatusLabels) !!}; // e.g., ['baby', 'adult', ...]
            const ageStatusCounts = {!! json_encode($ageStatusCounts) !!}; // e.g., [3, 10, 4, 1]

            // Amharic translation map
            const ageStatusTranslations = {!! json_encode($ageStatusAmharic) !!}; // { baby: "ህጻን", ... }

            // Translate labels
            const translatedLabels = ageStatusLabels.map(label => ageStatusTranslations[label] || label);
            const ageStatusColors = ageStatusLabels.map(label => ageColors[label] || '#999');

            const ageStatusCtx = document.getElementById('ageStatusChart').getContext('2d');
            new Chart(ageStatusCtx, {
                type: 'bar',
                data: {
                    labels: translatedLabels,
                    datasets: [{
                        label: 'ተሳፋሪዎች', // 'Passengers' in Amharic
                        data: ageStatusCounts,
                        backgroundColor: ageStatusColors,
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

            // 4. Passengers by Disability Status
            const disabilityCtx = document.getElementById('disabilityChart').getContext('2d');
            new Chart(disabilityCtx, {
                type: 'pie',
                data: {
                    labels: {!! json_encode($disabilityLabels) !!},
                    datasets: [{
                        data: {!! json_encode($disabilityCounts) !!},
                        backgroundColor: ['#3B82F6', '#F59E42', '#10B981', '#F43F5E'],
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

            // Export filtered data
            window.exportFilteredData = function() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                
                let url = '/admin/dashboard/export?';
                if (startDate) url += 'start_date=' + startDate + '&';
                if (endDate) url += 'end_date=' + endDate;
                
                window.location.href = url;
            }

            // Export PDF
            window.exportPDF = function() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                
                let url = '/admin/dashboard/export-pdf?';
                if (startDate) url += 'start_date=' + startDate + '&';
                if (endDate) url += 'end_date=' + endDate;
                
                window.location.href = url;
            }
        });
    </script>
@endsection
