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

        <!-- Quick Filter Buttons -->
        <div class="mb-4 flex flex-wrap gap-2">
            <button onclick="setDateFilter('today')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition">Today</button>
            <button onclick="setDateFilter('yesterday')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition">Yesterday</button>
            <button onclick="setDateFilter('thisweek')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm transition">This Week</button>
            <button onclick="setDateFilter('thismonth')" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-sm transition">This Month</button>
            <button onclick="setDateFilter('last3months')" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded text-sm transition">Last 3 Months</button>
            <button onclick="setDateFilter('thisyear')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">This Year</button>
            <button onclick="setDateFilter('lastyear')" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1 rounded text-sm transition">Last Year</button>
        </div>

        <!-- Date Filter Form -->
        <form id="filterForm" method="GET" class="mb-6 flex flex-wrap gap-4 items-end bg-yellow-50 p-4 rounded shadow">
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
            <button type="button" id="exportTelegram" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition duration-300 flex items-center gap-2">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0C5.374 0 0 5.373 0 12s5.374 12 12 12 12-5.373 12-12S18.626 0 12 0zm5.568 8.16l-1.61 7.59c-.12.54-.44.67-.89.42l-2.46-1.81-1.19 1.14c-.13.13-.24.24-.49.24l.17-2.43 4.47-4.03c.19-.17-.04-.27-.3-.1L8.95 12.48l-2.38-.75c-.52-.16-.53-.52.11-.77l9.28-3.57c.43-.16.81.11.67.77z"/>
                </svg>
                Export to Telegram
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('exportTelegram').addEventListener('click', function() {
            const fromDate = document.getElementById('from_date').value;
            const toDate = document.getElementById('to_date').value;
            
            // Show loading
            Swal.fire({
                title: 'Exporting to Telegram...',
                text: 'Please wait while we send the report',
                icon: 'info',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Send request
            fetch('{{ route("admin.total.reports.telegram") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    from_date: fromDate,
                    to_date: toDate
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Success!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#10B981'
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: data.error || 'Failed to export to Telegram',
                        icon: 'error',
                        confirmButtonColor: '#EF4444'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'Network error occurred',
                    icon: 'error',
                    confirmButtonColor: '#EF4444'
                });
            });
        });

        function setDateFilter(period) {
            const today = new Date();
            let fromDate, toDate;
            
            switch(period) {
                case 'today':
                    fromDate = toDate = today.toISOString().split('T')[0];
                    break;
                case 'yesterday':
                    const yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    fromDate = toDate = yesterday.toISOString().split('T')[0];
                    break;
                case 'thisweek':
                    const startOfWeek = new Date(today);
                    startOfWeek.setDate(today.getDate() - today.getDay());
                    fromDate = startOfWeek.toISOString().split('T')[0];
                    toDate = today.toISOString().split('T')[0];
                    break;
                case 'thismonth':
                    fromDate = new Date(today.getFullYear(), today.getMonth(), 1).toISOString().split('T')[0];
                    toDate = today.toISOString().split('T')[0];
                    break;
                case 'last3months':
                    const threeMonthsAgo = new Date(today);
                    threeMonthsAgo.setMonth(threeMonthsAgo.getMonth() - 3);
                    fromDate = threeMonthsAgo.toISOString().split('T')[0];
                    toDate = today.toISOString().split('T')[0];
                    break;
                case 'thisyear':
                    fromDate = new Date(today.getFullYear(), 0, 1).toISOString().split('T')[0];
                    toDate = today.toISOString().split('T')[0];
                    break;
                case 'lastyear':
                    fromDate = new Date(today.getFullYear() - 1, 0, 1).toISOString().split('T')[0];
                    toDate = new Date(today.getFullYear() - 1, 11, 31).toISOString().split('T')[0];
                    break;
            }
            
            document.getElementById('from_date').value = fromDate;
            document.getElementById('to_date').value = toDate;
            
            // Use window.location to navigate with GET parameters
            const url = new URL(window.location.href);
            url.searchParams.set('from_date', fromDate);
            url.searchParams.set('to_date', toDate);
            window.location.href = url.toString();
        }
    </script>
@endsection