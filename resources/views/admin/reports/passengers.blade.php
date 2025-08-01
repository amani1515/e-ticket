@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100 py-6 px-4">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-amber-900 mb-2">🚌 Passenger Reports</h1>
            <p class="text-amber-700 text-lg">View and manage passenger information</p>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter Options
                </h2>
            </div>
            
            <form method="GET" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                    <div>
                        <label for="search" class="block text-sm font-semibold text-amber-800 mb-2">🔍 Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50"
                            placeholder="Search by ID or Name">
                    </div>

                    <div>
                        <label for="gender" class="block text-sm font-semibold text-amber-800 mb-2">👤 Gender</label>
                        <select name="gender" id="gender" class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                            <option value="">All Genders</option>
                            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label for="destination_id" class="block text-sm font-semibold text-amber-800 mb-2">📍 Destination</label>
                        <select name="destination_id" id="destination_id" class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                            <option value="">All Destinations</option>
                            @foreach($destinations as $dest)
                                <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                                    {{ $dest->destination_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date_filter" class="block text-sm font-semibold text-amber-800 mb-2">📅 Date</label>
                        <select name="date_filter" id="date_filter" class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                            <option value="">All Dates</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                            <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year" {{ request('date_filter') == 'this_year' ? 'selected' : '' }}>This Year</option>
                        </select>
                    </div>

                    <div>
                        <label for="age_status" class="block text-sm font-semibold text-amber-800 mb-2">👶 Age</label>
                        <select name="age_status" id="age_status" class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 bg-amber-50">
                            <option value="">All Ages</option>
                            <option value="baby" {{ request('age_status') == 'baby' ? 'selected' : '' }}>Child</option>
                            <option value="adult" {{ request('age_status') == 'adult' ? 'selected' : '' }}>Adult</option>
                            <option value="middle_aged" {{ request('age_status') == 'middle_aged' ? 'selected' : '' }}>Middle-aged</option>
                            <option value="senior" {{ request('age_status') == 'senior' ? 'selected' : '' }}>Senior</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="flex-1 sm:flex-none bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Results
                    </button>
                    <a href="{{ route('admin.passenger.report.export', request()->all()) }}" class="flex-1 sm:flex-none bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Excel
                    </a>
                    <a href="{{ request()->url() }}" class="flex-1 sm:flex-none bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Passengers Table -->
        @if($tickets->count())
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden" id="printable-table">
                <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Passenger Records ({{ $tickets->total() }})
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-amber-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">Passenger Name</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">Gender</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">Destination</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">Age Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">Bus ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-amber-800">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100">
                            @foreach($tickets as $ticket)
                                <tr class="hover:bg-amber-50 transition-colors duration-200">
                                    <td class="px-4 py-3 text-sm font-medium text-amber-900">#{{ $ticket->id }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $ticket->passenger_name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 capitalize">
                                        @if($ticket->gender == 'male')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                👨 Male
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                                👩 Female
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $ticket->destination->destination_name ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700 capitalize">
                                        @if($ticket->age_status == 'baby')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                👶 Child
                                            </span>
                                        @elseif($ticket->age_status == 'adult')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                👨 Adult
                                            </span>
                                        @elseif($ticket->age_status == 'middle_aged')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                👩 Middle-aged
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                👴 Senior
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm font-mono text-gray-700">{{ $ticket->bus_id }}</td>
                                    <td class="px-4 py-3">
                                        @if($ticket->ticket_status === 'created')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                                Created
                                            </span>
                                        @elseif($ticket->ticket_status === 'confirmed')
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                                Confirmed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                                {{ ucfirst($ticket->ticket_status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            <a href="{{ route('admin.passenger-report.show', $ticket->id) }}" class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                            
                                            <button onclick="printRow(this)" class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H9.414a1 1 0 01-.707-.293l-2-2A1 1 0 005.586 6H4a2 2 0 00-2 2v4a2 2 0 002 2h2m3 4h6m-6 0l3-3m-3 3l3 3"></path>
                                                </svg>
                                                Print
                                            </button>
                                            
                                            <form id="refundForm-{{ $ticket->id }}" action="{{ route('admin.passenger-report.refund', $ticket->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" onclick="confirmRefund({{ $ticket->id }})" class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                    </svg>
                                                    Refund
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 bg-amber-50 border-t border-amber-100">
                    {{ $tickets->withQueryString()->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-amber-900 mb-2">No Passengers Found</h3>
                <p class="text-amber-700 mb-6">No passengers match your current filter criteria.</p>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function printRow(btn) {
    const row = btn.closest('tr').cloneNode(true);
    const table = document.createElement('table');
    table.className = 'w-full text-sm bg-white border border-amber-300 shadow-md rounded';
    const thead = btn.closest('table').querySelector('thead').cloneNode(true);
    table.appendChild(thead);
    const tbody = document.createElement('tbody');
    tbody.appendChild(row);
    table.appendChild(tbody);

    const printWindow = window.open('', '', 'height=400,width=600');
    printWindow.document.write('<html><head><title>Print Passenger Info</title>');
    printWindow.document.write('<style>table{width:100%;border-collapse:collapse;}th,td{border:1px solid #aaa;padding:6px;text-align:left;font-size:14px;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h3>Passenger Information</h3>');
    printWindow.document.write(table.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}

function confirmRefund(ticketId) {
    Swal.fire({
        title: 'Confirm Refund',
        text: 'Are you sure you want to refund this ticket?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, refund it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('refundForm-' + ticketId).submit();
        }
    });
}
</script>
@endsection