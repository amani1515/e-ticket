@extends('admin.layout.app')

@section('content')
<div x-data="dashboardData()" class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    <!-- Top Navigation Bar -->
    <div class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold bg-gradient-to-r from-slate-800 to-slate-600 bg-clip-text text-transparent">Admin Dashboard</h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="w-64 pl-10 pr-4 py-2 bg-white/60 backdrop-blur-sm border border-slate-200/60 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500/40 transition-all duration-200">
                        <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center shadow-lg cursor-pointer hover:shadow-xl transition-all duration-200">
                        <span class="text-white font-semibold text-sm">{{ substr(Auth::user()->name, 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h2>
            <p class="text-slate-600">Here's what's happening with your e-ticket system today.</p>
        </div>

        <!-- Quick Filters -->
        <div class="mb-8">
            <div class="bg-white/60 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20">
                <h3 class="text-lg font-semibold text-slate-800 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Time Filters
                </h3>
                <div class="flex flex-wrap gap-3">
                    <button @click="setActiveFilter('today')" :class="activeFilter === 'today' ? 'bg-blue-500 text-white shadow-lg' : 'bg-white/80 text-slate-700 hover:bg-blue-50'" 
                        class="px-4 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 border border-slate-200/60">
                        Today
                    </button>
                    <button @click="setActiveFilter('week')" :class="activeFilter === 'week' ? 'bg-blue-500 text-white shadow-lg' : 'bg-white/80 text-slate-700 hover:bg-blue-50'" 
                        class="px-4 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 border border-slate-200/60">
                        This Week
                    </button>
                    <button @click="setActiveFilter('month')" :class="activeFilter === 'month' ? 'bg-blue-500 text-white shadow-lg' : 'bg-white/80 text-slate-700 hover:bg-blue-50'" 
                        class="px-4 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 border border-slate-200/60">
                        This Month
                    </button>
                    <button @click="setActiveFilter('year')" :class="activeFilter === 'year' ? 'bg-blue-500 text-white shadow-lg' : 'bg-white/80 text-slate-700 hover:bg-blue-50'" 
                        class="px-4 py-2 rounded-xl font-medium transition-all duration-200 transform hover:scale-105 border border-slate-200/60">
                        This Year
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="group bg-white/60 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20 hover:shadow-xl hover:bg-white/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Passengers Today</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1 counter" data-target="{{ $passengersToday ?? 0 }}">0</p>
                        <p class="text-blue-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +12% from yesterday
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group bg-white/60 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20 hover:shadow-xl hover:bg-white/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1"><span class="counter" data-target="{{ $totalRevenue ?? 0 }}">0</span> ETB</p>
                        <p class="text-teal-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +8% from last month
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group bg-white/60 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20 hover:shadow-xl hover:bg-white/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Active Users</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1 counter" data-target="{{ $totalUsers ?? 0 }}">0</p>
                        <p class="text-purple-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            +5% this week
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="group bg-white/60 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/20 hover:shadow-xl hover:bg-white/80 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-slate-600 text-sm font-medium">Destinations</p>
                        <p class="text-3xl font-bold text-slate-800 mt-1 counter" data-target="{{ $totalDestinations ?? 0 }}">0</p>
                        <p class="text-indigo-500 text-sm mt-1 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            All active
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Passengers by Destination -->
            <div class="bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-slate-200/60">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        Passengers by Destination
                    </h3>
                </div>
                <div class="p-6">
                    <canvas id="passengerChart" height="300"></canvas>
                </div>
            </div>

            <!-- Gender Distribution -->
            <div class="bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-slate-200/60">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-pink-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Gender Distribution
                    </h3>
                </div>
                <div class="p-6 flex justify-center">
                    <canvas id="genderChart" width="300" height="300"></canvas>
                </div>
            </div>

            <!-- Age Distribution -->
            <div class="bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-slate-200/60">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        Age Distribution
                    </h3>
                </div>
                <div class="p-6">
                    <canvas id="ageChart" height="300"></canvas>
                </div>
            </div>

            <!-- Accessibility Status -->
            <div class="bg-white/60 backdrop-blur-md rounded-2xl shadow-lg border border-white/20 hover:shadow-xl transition-all duration-300">
                <div class="p-6 border-b border-slate-200/60">
                    <h3 class="text-xl font-bold text-slate-800 flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-br from-teal-500 to-teal-600 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        Accessibility Status
                    </h3>
                </div>
                <div class="p-6 flex justify-center">
                    <canvas id="accessibilityChart" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function dashboardData() {
        return {
            activeFilter: 'today',
            setActiveFilter(filter) {
                this.activeFilter = filter;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Counter Animation
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-target'));
            const increment = target / 100;
            let current = 0;
            
            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.textContent = Math.ceil(current);
                    setTimeout(updateCounter, 20);
                } else {
                    counter.textContent = target;
                }
            };
            
            setTimeout(updateCounter, 500);
        });

        // Progress Ring Animation
        const progressRings = document.querySelectorAll('.progress-ring');
        progressRings.forEach(ring => {
            ring.style.strokeDasharray = '0, 100';
            setTimeout(() => {
                ring.style.transition = 'stroke-dasharray 2s ease-in-out';
                const dashArray = ring.getAttribute('stroke-dasharray');
                ring.style.strokeDasharray = dashArray;
            }, 1000);
        });

        // Chart.js Global Configuration
        Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
        Chart.defaults.color = '#64748b';

        // 1. Passengers by Destination - Interactive Bar Chart
        const ctx = document.getElementById('passengerChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($destinationLabels ?? ['Addis Ababa', 'Dire Dawa', 'Hawassa', 'Bahir Dar']) !!},
                datasets: [{
                    label: 'Passengers',
                    data: {!! json_encode($passengerCounts ?? [120, 85, 95, 70]) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgb(59, 130, 246)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                    hoverBackgroundColor: 'rgba(59, 130, 246, 1)',
                    hoverBorderColor: 'rgb(37, 99, 235)'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#f1f5f9',
                        bodyColor: '#f1f5f9',
                        borderColor: 'rgba(59, 130, 246, 0.5)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 12
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                },
                onHover: (event, activeElements) => {
                    event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                }
            }
        });

        // 2. Gender Distribution - Animated Donut Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($genderLabels ?? ['Male', 'Female']) !!},
                datasets: [{
                    data: {!! json_encode($genderCounts ?? [60, 40]) !!},
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(236, 72, 153, 0.8)'
                    ],
                    borderColor: [
                        'rgb(59, 130, 246)',
                        'rgb(236, 72, 153)'
                    ],
                    borderWidth: 3,
                    hoverBackgroundColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(236, 72, 153, 1)'
                    ],
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true,
                    duration: 2000
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 14,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#f1f5f9',
                        bodyColor: '#f1f5f9',
                        borderColor: 'rgba(236, 72, 153, 0.5)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed * 100) / total).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // 3. Age Distribution - Vertical Histogram
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        new Chart(ageCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ageStatusLabels ?? ['Baby', 'Adult', 'Middle Aged', 'Senior']) !!},
                datasets: [{
                    label: 'Passengers',
                    data: {!! json_encode($ageStatusCounts ?? [15, 120, 80, 25]) !!},
                    backgroundColor: [
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(139, 92, 246, 0.8)',
                        'rgba(6, 182, 212, 0.8)',
                        'rgba(162, 28, 175, 0.8)'
                    ],
                    borderColor: [
                        'rgb(251, 191, 36)',
                        'rgb(139, 92, 246)',
                        'rgb(6, 182, 212)',
                        'rgb(162, 28, 175)'
                    ],
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 2000,
                    easing: 'easeInOutBounce'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#f1f5f9',
                        bodyColor: '#f1f5f9',
                        borderColor: 'rgba(139, 92, 246, 0.5)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 12
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(148, 163, 184, 0.1)'
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#64748b'
                        }
                    }
                }
            }
        });

        // 4. Accessibility Status - Pie Chart
        const accessibilityCtx = document.getElementById('accessibilityChart').getContext('2d');
        new Chart(accessibilityCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($disabilityLabels ?? ['No Disability', 'Physical', 'Visual', 'Hearing']) !!},
                datasets: [{
                    data: {!! json_encode($disabilityCounts ?? [85, 8, 4, 3]) !!},
                    backgroundColor: [
                        'rgba(20, 184, 166, 0.8)',
                        'rgba(239, 68, 68, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(168, 85, 247, 0.8)'
                    ],
                    borderColor: [
                        'rgb(20, 184, 166)',
                        'rgb(239, 68, 68)',
                        'rgb(245, 158, 11)',
                        'rgb(168, 85, 247)'
                    ],
                    borderWidth: 3,
                    hoverBackgroundColor: [
                        'rgba(20, 184, 166, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(245, 158, 11, 1)',
                        'rgba(168, 85, 247, 1)'
                    ],
                    hoverBorderWidth: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    animateRotate: true,
                    duration: 2000
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 14,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleColor: '#f1f5f9',
                        bodyColor: '#f1f5f9',
                        borderColor: 'rgba(20, 184, 166, 0.5)',
                        borderWidth: 1,
                        cornerRadius: 12,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed * 100) / total).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                onHover: (event, activeElements) => {
                    event.native.target.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
                }
            }
        });
    });
</script>
@endsection