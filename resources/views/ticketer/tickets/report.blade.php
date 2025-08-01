@extends('ticketer.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-6 px-4">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-blue-900 mb-2">📊 Ticket Reports</h1>
            <p class="text-blue-700 text-lg">View and manage your ticket sales</p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-800 border-2 border-green-200 flex items-center shadow-lg">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filter Options
                </h2>
            </div>
            
            <form method="GET" action="{{ route('ticketer.tickets.report') }}" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div>
                        <label for="destination_id" class="block text-sm font-semibold text-blue-800 mb-2">📍 Destination</label>
                        <select name="destination_id" id="destination_id" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                            <option value="">All Destinations</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                                    {{ $destination->destination_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="ticket_status" class="block text-sm font-semibold text-blue-800 mb-2">🎫 Status</label>
                        <select name="ticket_status" id="ticket_status" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                            <option value="">All Statuses</option>
                            <option value="created" {{ request('ticket_status') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="confirmed" {{ request('ticket_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        </select>
                    </div>

                    <div>
                        <label for="search" class="block text-sm font-semibold text-blue-800 mb-2">🔍 Search</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                            placeholder="Targa or Ticket ID">
                    </div>

                    <div>
                        <label for="date_filter" class="block text-sm font-semibold text-blue-800 mb-2">📅 Date</label>
                        <select name="date_filter" id="date_filter" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                            <option value="">All Dates</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                            <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="two_days_before" {{ request('date_filter') == 'two_days_before' ? 'selected' : '' }}>2 Days Before</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row gap-3 pt-4">
                    <button type="submit" class="flex-1 sm:flex-none bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        Filter Results
                    </button>
                    <a href="{{ route('ticketer.tickets.export', request()->query()) }}"
                        class="flex-1 sm:flex-none bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Excel
                    </a>
                </div>
            </form>
        </div>

        <!-- Tickets Table -->
        @if ($tickets->count())
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        Ticket Records ({{ $tickets->total() }})
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Passenger</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Age</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Route</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Bus</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Departure</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Code</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100">
                            @foreach ($tickets as $ticket)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-4 py-3 text-sm font-medium text-blue-900">#{{ $ticket->id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $ticket->passenger_name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ ucfirst($ticket->age_status) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <div class="flex items-center">
                                            <span class="text-blue-600">{{ $ticket->destination->start_from }}</span>
                                            <svg class="w-4 h-4 mx-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                            </svg>
                                            <span class="text-indigo-600">{{ $ticket->destination->destination_name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-mono text-gray-700">{{ $ticket->bus_id }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ date('M d, H:i', strtotime($ticket->departure_datetime)) }}</td>
                                    <td class="px-4 py-3">
                                        @if ($ticket->ticket_status === 'created')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                                Created
                                            </span>
                                        @elseif($ticket->ticket_status === 'confirmed')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                                Confirmed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                                {{ ucfirst($ticket->ticket_status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-xs font-mono text-gray-600">{{ substr($ticket->ticket_code, 0, 12) }}...</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            @if ($ticket->ticket_status === 'created')
                                                <button onclick="openEditModal({{ $ticket->id }}, '{{ addslashes($ticket->passenger_name) }}', '{{ $ticket->gender }}', '{{ $ticket->phone_no }}', '{{ $ticket->fayda_id }}', '{{ $ticket->age_status }}', '{{ $ticket->disability_status }}')"
                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    Edit
                                                </button>
                                                
                                                <form action="{{ route('ticketer.tickets.cancel', $ticket->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Cancel this ticket?')"
                                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-800 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <a href="{{ route('ticketer.tickets.receipt', $ticket->id) }}" target="_blank"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H9.414a1 1 0 01-.707-.293l-2-2A1 1 0 005.586 6H4a2 2 0 00-2 2v4a2 2 0 002 2h2m3 4h6m-6 0l3-3m-3 3l3 3"></path>
                                                </svg>
                                                Print
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 bg-blue-50 border-t border-blue-100">
                    {{ $tickets->withQueryString()->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-blue-900 mb-2">No Tickets Found</h3>
                <p class="text-blue-700 mb-6">No tickets match your current filter criteria.</p>
                <a href="{{ route('ticketer.tickets.create') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create New Ticket
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-lg mx-4 p-6 rounded-2xl shadow-2xl">
        <h2 class="text-2xl font-bold text-blue-900 mb-6 flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Ticket
        </h2>
        <form id="editTicketForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="ticket_id" id="modal_ticket_id">

            <div>
                <label class="block text-sm font-semibold text-blue-800 mb-2">Passenger Name</label>
                <input type="text" name="passenger_name" id="modal_passenger_name"
                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-blue-800 mb-2">Gender</label>
                    <select name="gender" id="modal_gender" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-blue-800 mb-2">Age Status</label>
                    <select name="age_status" id="age_status" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                        <option value="adult">Adult</option>
                        <option value="baby">Child</option>
                        <option value="middle_aged">Middle-aged</option>
                        <option value="senior">Senior</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-blue-800 mb-2">Disability Status</label>
                <select name="disability_status" id="disability_status" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                    <option value="None">None</option>
                    <option value="Blind / Visual Impairment">Visual Impairment</option>
                    <option value="Deaf / Hard of Hearing">Hearing Impairment</option>
                    <option value="Speech Impairment">Speech Impairment</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-blue-800 mb-2">Phone Number</label>
                <div class="flex">
                    <span class="inline-flex items-center px-4 text-sm font-medium text-blue-800 bg-blue-200 border-2 border-r-0 border-blue-200 rounded-l-xl">+251</span>
                    <input type="text" name="phone_no" id="modal_phone_no"
                        class="w-full px-4 py-3 border-2 border-blue-200 rounded-r-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50" maxlength="9">
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold text-blue-800 mb-2">National ID</label>
                <input type="text" name="fayda_id" id="modal_fayda_id"
                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
            </div>

            <div>
                <label class="block text-sm font-semibold text-blue-800 mb-2">Departure Date & Time</label>
                <input type="datetime-local" name="departure_datetime" id="departure_datetime"
                    class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50" value="{{ now()->format('Y-m-d\TH:i') }}">
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" onclick="closeModal()"
                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-xl transition duration-200">Cancel</button>
                <button type="submit"
                    class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, gender, phone, faydaId, ageStatus, disabilityStatus) {
    const form = document.getElementById('editTicketForm');
    form.action = `/ticketer/tickets/${id}/update`;

    document.getElementById('modal_ticket_id').value = id;
    document.getElementById('modal_passenger_name').value = name;
    document.getElementById('modal_gender').value = gender;
    document.getElementById('modal_phone_no').value = phone ? phone.substring(1) : '';
    document.getElementById('modal_fayda_id').value = faydaId;
    document.getElementById('age_status').value = ageStatus;
    document.getElementById('disability_status').value = disabilityStatus;

    document.getElementById('editModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('editModal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    const modalPhone = document.getElementById('modal_phone_no');
    const form = document.getElementById('editTicketForm');
    
    if (modalPhone) {
        modalPhone.addEventListener('input', function() {
            let value = this.value.replace(/[^\d]/g, '');
            if (value.length > 0 && value[0] !== '9' && value[0] !== '7') {
                value = value.substring(1);
            }
            this.value = value.slice(0, 9);
        });
    }
    
    if (form) {
        form.addEventListener('submit', function() {
            const phoneValue = modalPhone.value;
            if (phoneValue.length === 9 && (phoneValue[0] === '9' || phoneValue[0] === '7')) {
                modalPhone.value = '0' + phoneValue;
            }
        });
    }
});
</script>
@endsection