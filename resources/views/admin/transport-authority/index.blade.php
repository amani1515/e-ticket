@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100 p-4 sm:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">🚌 Transport Authority Dashboard</h1>
            <p class="text-amber-700">Monitor and manage transport data for authorities</p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <form method="GET" class="flex items-center gap-3">
                <label class="text-sm font-medium text-amber-700">Filter by Date:</label>
                <input type="date" name="date" value="{{ $date }}" class="px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter
                </button>
            </form>
            
            <div class="flex gap-3">
                <form method="POST" action="{{ route('admin.transport-authority.send') }}" class="inline">
                    @csrf
                    <input type="hidden" name="date" value="{{ $date }}">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Send to Authority
                    </button>
                </form>
                
                <a href="{{ route('admin.transport-authority.export', ['date' => $date]) }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Data
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Total Tickets</h3>
                        <p class="text-3xl font-bold">{{ $tickets->total() }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Total Buses</h3>
                        <p class="text-3xl font-bold">{{ $buses->count() }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl shadow-xl p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold mb-2">Total Schedules</h3>
                        <p class="text-3xl font-bold">{{ $schedules->count() }}</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs for different sections -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="border-b border-amber-200" x-data="{ activeTab: 'tickets' }">
                <nav class="flex space-x-8 px-6" aria-label="Tabs">
                    <button @click="activeTab = 'tickets'" :class="activeTab === 'tickets' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        🎫 Tickets ({{ $tickets->total() }})
                    </button>
                    <button @click="activeTab = 'buses'" :class="activeTab === 'buses' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        🚌 Buses ({{ $buses->count() }})
                    </button>
                    <button @click="activeTab = 'schedules'" :class="activeTab === 'schedules' ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                        📅 Schedules ({{ $schedules->count() }})
                    </button>
                </nav>

                <div class="p-6">
                    <!-- Tickets Tab -->
                    <div x-show="activeTab === 'tickets'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-amber-900">Tickets for {{ $date }}</h3>
                            <input type="text" id="ticketsSearch" placeholder="Search tickets..." class="px-4 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" style="width: 300px;">
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full" id="ticketsTable">
                                <thead class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 0)">ID ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 1)">Passenger ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 2)">Phone ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 3)">Route ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 4)">Tariff ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 5)">Bus ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 6)">Mahberat ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('ticketsTable', 7)">Departure ↕</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-amber-100">
                                    @forelse($tickets as $ticket)
                                    <tr class="hover:bg-amber-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#{{ $ticket->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-900">{{ $ticket->passenger_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">{{ $ticket->phone_no }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">
                                            <span class="text-gray-500">{{ $ticket->destination->start_from }}</span>
                                            <span class="mx-1">→</span>
                                            <span class="text-amber-600 font-medium">{{ $ticket->destination->destination_name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ $ticket->tariff ?? $ticket->destination->tariff }} ብር</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $ticket->bus->targa ?? $ticket->bus_id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">{{ $ticket->bus->mahberat->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">{{ $ticket->departure_datetime }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center text-amber-600">No tickets found for {{ $date }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $tickets->links() }}
                        </div>
                    </div>

                    <!-- Buses Tab -->
                    <div x-show="activeTab === 'buses'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-amber-900">All Buses</h3>
                            <input type="text" id="busesSearch" placeholder="Search buses..." class="px-4 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" style="width: 300px;">
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full" id="busesTable">
                                <thead class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('busesTable', 0)">ID ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('busesTable', 1)">Targa ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('busesTable', 2)">Level ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('busesTable', 3)">Capacity ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('busesTable', 4)">Mahberat ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('busesTable', 5)">Status ↕</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-amber-100">
                                    @foreach($buses as $bus)
                                    <tr class="hover:bg-amber-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#{{ $bus->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-900">{{ $bus->targa }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $bus->level === 'level1' ? 'bg-blue-100 text-blue-800' : ($bus->level === 'level2' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($bus->level) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">{{ $bus->capacity }} seats</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">{{ $bus->mahberat->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Active</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Schedules Tab -->
                    <div x-show="activeTab === 'schedules'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-amber-900">Schedules for {{ $date }}</h3>
                            <input type="text" id="schedulesSearch" placeholder="Search schedules..." class="px-4 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" style="width: 300px;">
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full" id="schedulesTable">
                                <thead class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('schedulesTable', 0)">ID ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('schedulesTable', 1)">Route ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('schedulesTable', 2)">Bus ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('schedulesTable', 3)">Mahberat ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('schedulesTable', 4)">Departure ↕</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider cursor-pointer" onclick="sortTable('schedulesTable', 5)">Available Seats ↕</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-amber-100">
                                    @forelse($schedules as $schedule)
                                    <tr class="hover:bg-amber-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">#{{ $schedule->id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">
                                            <span class="text-gray-500">{{ $schedule->destination->start_from }}</span>
                                            <span class="mx-1">→</span>
                                            <span class="text-amber-600 font-medium">{{ $schedule->destination->destination_name }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $schedule->bus->targa ?? $schedule->bus_id }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">{{ $schedule->bus->mahberat->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-700">{{ $schedule->departure_datetime }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $schedule->available_seats > 10 ? 'bg-green-100 text-green-800' : ($schedule->available_seats > 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $schedule->available_seats }} seats
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-amber-600">No schedules found for {{ $date }}</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
document.addEventListener('DOMContentLoaded', function() {
    const ticketsSearch = document.getElementById('ticketsSearch');
    const busesSearch = document.getElementById('busesSearch');
    const schedulesSearch = document.getElementById('schedulesSearch');
    
    if (ticketsSearch) {
        ticketsSearch.addEventListener('keyup', function() {
            searchTable('ticketsTable', this.value);
        });
    }
    
    if (busesSearch) {
        busesSearch.addEventListener('keyup', function() {
            searchTable('busesTable', this.value);
        });
    }
    
    if (schedulesSearch) {
        schedulesSearch.addEventListener('keyup', function() {
            searchTable('schedulesTable', this.value);
        });
    }
});

function searchTable(tableId, searchTerm) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const tbody = table.getElementsByTagName('tbody')[0];
    if (!tbody) return;
    
    const rows = tbody.getElementsByTagName('tr');
    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const cells = row.getElementsByTagName('td');
        let found = false;
        
        for (let j = 0; j < cells.length; j++) {
            if (cells[j].textContent.toLowerCase().includes(searchTerm.toLowerCase())) {
                found = true;
                break;
            }
        }
        
        row.style.display = found ? '' : 'none';
    }
}

// Sort functionality
function sortTable(tableId, columnIndex) {
    const table = document.getElementById(tableId);
    if (!table) return;
    
    const tbody = table.getElementsByTagName('tbody')[0];
    if (!tbody) return;
    
    const rows = Array.from(tbody.getElementsByTagName('tr'));
    if (rows.length === 0) return;
    
    const firstRowCells = rows[0].getElementsByTagName('td');
    if (firstRowCells.length <= columnIndex) return;
    
    const isNumeric = !isNaN(parseFloat(firstRowCells[columnIndex].textContent.replace(/[^0-9.-]/g, '')));
    
    rows.sort((a, b) => {
        const aCells = a.getElementsByTagName('td');
        const bCells = b.getElementsByTagName('td');
        
        if (aCells.length <= columnIndex || bCells.length <= columnIndex) return 0;
        
        const aVal = aCells[columnIndex].textContent.trim();
        const bVal = bCells[columnIndex].textContent.trim();
        
        if (isNumeric) {
            const aNum = parseFloat(aVal.replace(/[^0-9.-]/g, '')) || 0;
            const bNum = parseFloat(bVal.replace(/[^0-9.-]/g, '')) || 0;
            return aNum - bNum;
        } else {
            return aVal.localeCompare(bVal);
        }
    });
    
    rows.forEach(row => tbody.appendChild(row));
}
</script>
@endsection