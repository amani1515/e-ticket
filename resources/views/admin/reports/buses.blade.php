@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 p-2 sm:p-4 lg:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-4 sm:mb-8">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-amber-900 mb-2">🚌 Bus Management</h1>
            <p class="text-sm sm:text-base text-amber-700">Manage all buses and their information</p>
            <!-- Debug info -->
            <div class="text-xs text-gray-500 mt-2">
                Debug: {{ count($mahberats ?? []) }} mahberats, {{ $buses->count() }} buses
            </div>
        </div>

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex gap-4">
                <div class="bg-white rounded-lg shadow px-4 py-2">
                    <div class="text-sm text-amber-600">Total Buses</div>
                    <div class="text-2xl font-bold text-amber-900">{{ $buses->total() }}</div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-xl lg:rounded-2xl shadow-xl p-4 sm:p-6 mb-4 sm:mb-6">
            <form method="GET" action="{{ route('admin.buses.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="sm:col-span-2 lg:col-span-2">
                        <label class="block text-sm font-medium text-amber-700 mb-2">Search Buses</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search buses..."
                                   class="w-full pl-10 pr-4 py-2 text-sm border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">Status</label>
                        <select name="status_filter" class="w-full px-3 py-2 text-sm border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status_filter') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status_filter') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="maintenance" {{ request('status_filter') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                    
                    <!-- Mahberat Filter -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">Mahberat</label>
                        <select name="mahberat_filter" class="w-full px-3 py-2 text-sm border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Mahberats</option>
                            @if(isset($mahberats))
                                @foreach($mahberats as $mahberat)
                                    <option value="{{ $mahberat->id }}" {{ request('mahberat_filter') == $mahberat->id ? 'selected' : '' }}>
                                        {{ $mahberat->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.buses.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- Mobile Card View --}}
        <div class="block lg:hidden space-y-4">
            @if($buses->count() > 0)
                @foreach($buses as $index => $bus)
                    <div class="bg-white rounded-xl shadow-lg p-4 border border-amber-100">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg text-amber-900">{{ $bus->targa }}</h3>
                                <p class="text-sm text-amber-600">{{ $bus->driver_name }}</p>
                                @if($bus->unique_bus_id)
                                    <p class="text-xs text-amber-500">ID: {{ $bus->unique_bus_id }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                @if($bus->status === 'active')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        ✓ Active
                                    </span>
                                @elseif($bus->status === 'maintenance')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        ⚠ Maintenance
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ✗ Inactive
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                            <div>
                                <span class="text-amber-600 font-medium">Phone:</span>
                                <p class="text-amber-900">{{ $bus->driver_phone }}</p>
                            </div>
                            <div>
                                <span class="text-amber-600 font-medium">Seats:</span>
                                <p class="text-amber-900">{{ $bus->total_seats }}</p>
                            </div>
                            <div class="col-span-2">
                                <span class="text-amber-600 font-medium">Mahberat:</span>
                                <p class="text-amber-900">{{ $bus->mahberat->name ?? 'Not assigned' }}</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('admin.buses.show', $bus->id) }}"
                               class="flex-1 text-center px-3 py-2 text-sm bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                                View
                            </a>
                            <button onclick="printRow(this)" 
                                    class="flex-1 px-3 py-2 text-sm bg-green-500 text-white rounded-lg hover:bg-green-600">
                                Print
                            </button>
                            <a href="{{ route('admin.buses.banner', $bus->id) }}"
                               class="flex-1 text-center px-3 py-2 text-sm bg-amber-500 text-white rounded-lg hover:bg-amber-600">
                                QR
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12 bg-white rounded-xl">
                    <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-amber-900">No buses found</h3>
                    <p class="mt-1 text-sm text-amber-600">Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>

        {{-- Desktop Table View --}}
        <div class="hidden lg:block bg-white rounded-2xl shadow-xl overflow-hidden">
            @if($buses->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Targa</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Driver</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Phone</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Seats</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Mahberat</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100">
                            @foreach($buses as $index => $bus)
                            <tr class="hover:bg-amber-50 transition-colors duration-200">
                                <td class="px-6 py-4 text-sm text-amber-900 font-medium">
                                    {{ ($buses->currentPage() - 1) * $buses->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-amber-900">{{ $bus->targa }}</div>
                                    @if($bus->unique_bus_id)
                                        <div class="text-xs text-amber-600">ID: {{ $bus->unique_bus_id }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-amber-900">{{ $bus->driver_name }}</td>
                                <td class="px-6 py-4 text-sm text-amber-700">{{ $bus->driver_phone }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $bus->total_seats }} seats
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($bus->status === 'active')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Active
                                        </span>
                                    @elseif($bus->status === 'maintenance')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Maintenance
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Inactive
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-amber-700">
                                    {{ $bus->mahberat->name ?? 'Not assigned' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.buses.show', $bus->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View Details
                                        </a>
                                        <button onclick="printRow(this)" title="Print" class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                            </svg>
                                            Print
                                        </button>
                                        <a href="{{ route('admin.buses.banner', $bus->id) }}" 
                                            class="inline-flex items-center px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium rounded-md transition-colors duration-200" 
                                            title="Print QR">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                            </svg>
                                            QR
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-amber-900">No buses found</h3>
                    <p class="mt-1 text-sm text-amber-600">Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($buses->hasPages())
        <div class="mt-4 sm:mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow px-4 sm:px-6 py-3 sm:py-4 w-full sm:w-auto">
                {{ $buses->links() }}
            </div>
        </div>
        @endif
    </div>
</div>


<script>
function printRow(btn) {
    // Clone the row and table headers for printing
    const row = btn.closest('tr').cloneNode(true);
    const table = document.createElement('table');
    table.className = 'w-full border text-sm bg-white shadow';
    const thead = btn.closest('table').querySelector('thead').cloneNode(true);
    table.appendChild(thead);
    const tbody = document.createElement('tbody');
    tbody.appendChild(row);
    table.appendChild(tbody);

    // Open print window
    const printWindow = window.open('', '', 'height=400,width=600');
    printWindow.document.write('<html><head><title>Print Bus Info</title>');
    printWindow.document.write('<style>table{width:100%;border-collapse:collapse;}th,td{border:1px solid #aaa;padding:6px;text-align:left;font-size:14px;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h3>Bus Information</h3>');
    printWindow.document.write(table.outerHTML);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>
@endsection