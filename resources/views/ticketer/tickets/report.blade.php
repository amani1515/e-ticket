@extends('ticketer.layout.app')

@section('content')
<div class="flex min-h-screen">
    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 p-6">
        <h2 class="text-2xl font-semibold mb-6">Ticket Report</h2>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif


        <!-- Filter Form -->
        <form method="GET" action="{{ route('ticketer.tickets.report') }}" class="mb-6 flex space-x-4">
            <div>
                <label for="destination_id" class="block text-sm font-medium text-gray-700">Destination</label>
                <select name="destination_id" id="destination_id" class="w-full p-2 border rounded">
                    <option value="">All Destinations</option>
                    @foreach($destinations as $destination)
                        <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                            {{ $destination->destination_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="ticket_status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="ticket_status" id="ticket_status" class="w-full p-2 border rounded">
                    <option value="">All Statuses</option>
                    <option value="created" {{ request('ticket_status') == 'created' ? 'selected' : '' }}>Created</option>
                    <option value="confirmed" {{ request('ticket_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                </select>
            </div>

          <div>
    <label for="search" class="block text-sm font-medium text-gray-700">Search (Targa or Ticket ID)</label>
    <input type="text" name="search" id="search" value="{{ request('search') }}" class="w-full p-2 border rounded" placeholder="Enter Targa or Ticket ID">
</div>


            <div>
                <label for="date_filter" class="block text-sm font-medium text-gray-700">Date</label>
                <select name="date_filter" id="date_filter" class="w-full p-2 border rounded">
                    <option value="">All Dates</option>
                    <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                    <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                    <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                    <option value="two_days_before" {{ request('date_filter') == 'two_days_before' ? 'selected' : '' }}>2 Days Before</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Filter</button>
                <a href="{{ route('ticketer.tickets.export', request()->query()) }}" class="bg-green-500 text-white px-4 py-2 rounded ml-2">Export to Excel</a>
            </div>
        </form>

        <!-- Ticket Table -->
        @if($tickets->count())
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow rounded border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border px-4 py-2">Ticket ID</th>
                            <th class="border px-4 py-2">Passenger Name</th>
                            <th class="border px-4 py-2">Age</th>
                            <th class="border px-4 py-2">Destination</th>
                            <th class="border px-4 py-2">Bus</th>
                            <th class="border px-4 py-2">Departure</th>
                            <th class="border px-4 py-2">Status</th>
                            <th class="border px-4 py-2">Code</th>
                            <th class="border px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="hover:bg-gray-50">
                                <td class="border px-4 py-2">{{ $ticket->id }}</td>
                                <td class="border px-4 py-2">{{ $ticket->passenger_name }}</td>
                                <td class="border px-4 py-2">{{ ucfirst($ticket->age_status) }}</td>
                                <td class="border px-4 py-2">
                                    {{ $ticket->destination->start_from }} → {{ $ticket->destination->destination_name }}
                                </td>
                                <td class="border px-4 py-2">{{ $ticket->bus_id }}</td>
                                <td class="border px-4 py-2">{{ $ticket->departure_datetime }}</td>
                                <td class="border px-4 py-2">
                                    @if($ticket->ticket_status === 'created')
                                        <span class="bg-red-100 text-red-700 text-sm px-3 py-1 rounded-full">Created</span>
                                    @elseif($ticket->ticket_status === 'confirmed')
                                        <span class="bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full">Confirmed</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 text-sm px-3 py-1 rounded-full">{{ ucfirst($ticket->ticket_status) }}</span>
                                    @endif
                                </td>
                                <td class="border px-4 py-2">{{ $ticket->ticket_code }}</td>
                                <td class="border px-4 py-2">

                                <!-- Toggle Edit Button -->
                                <!-- the edit button displays if only ticket_status is created   -->
@if($ticket->ticket_status === 'created')
                                
<button
    onclick="openEditModal(
        {{ $ticket->id }},
        '{{ addslashes($ticket->passenger_name) }}',
        '{{ $ticket->gender }}',
        '{{ $ticket->phone_no }}',
        '{{ $ticket->fayda_id }}',
        '{{ $ticket->age_status }}',
        '{{ $ticket->disability_status }}'
    )"
    class="bg-yellow-400 text-white px-2 py-1 rounded text-sm"
>
    Edit
</button>
@endif

                                <!-- Cancel Button -->
                                <!-- Only show if ticket status is 'created' -->

@if($ticket->ticket_status === 'created')
<form action="{{ route('tickets.cancel', $ticket->id) }}" method="POST" class="inline">
    @csrf
    <button 
        type="submit"
        onclick="return confirm('Are you sure you want to cancel this ticket?');"
        class="bg-red-500 text-white px-2 py-1 rounded text-sm"
    >
        Cancel
    </button>
</form>
@endif


                                <!-- Print Button -->
                                <a href="{{ route('ticketer.tickets.receipt', $ticket->id) }}" target="_blank" class="bg-blue-500 text-white px-2 py-1 rounded text-sm ml-1">Print</a>

                                <!-- Edit Form (Hidden by default) -->
                                {{-- <form id="edit-form-{{ $ticket->id }}" action="{{ route('ticketer.tickets.updateName', $ticket->id) }}" method="POST" class="mt-2 hidden">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="passenger_name" value="{{ $ticket->passenger_name }}" class="border p-1 text-sm rounded w-full mb-1">
                                    <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-sm w-full">Save</button>
                                </form> --}}
                            </td>

                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

    <!-- Modal -->
<div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white w-full max-w-lg p-6 rounded shadow-lg relative">
        <h2 class="text-xl font-bold mb-4">Edit Ticket</h2>
        <form id="editTicketForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="ticket_id" id="modal_ticket_id">

            <div class="mb-2">
                <label class="block text-sm">የተሳፋሪ ሙሉ ስም </label>
                <input type="text" name="passenger_name" id="modal_passenger_name" class="border p-2 w-full rounded">
            </div>

            <div class="mb-2">
                <label class="block text-sm">ጾታ </label>
                <select name="gender" id="modal_gender" class="border p-2 w-full rounded">
                    <option value="male">ወንድ </option>
                    <option value="female">ሴት </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="age_status" class="block">Age Status</label>
                <select name="age_status" id="age_status" class="w-full p-2 border rounded" required>
                    <option value="adult">ወጣት</option>
                    <option value="baby">ታዳጊ</option>
                    <option value="middle_aged">ጎልማሳ</option>
                    <option value="senior">አዛውንት</option>
                </select>
            </div>

            <label for="disability_status">Disability Status:</label>
            <select name="disability_status" id="disability_status" required>
                <option value="None">የለም</option>
                <option value="Blind / Visual Impairment">ማየት የተሳነው</option>
                <option value="Deaf / Hard of Hearing">መስማት የተሳነው</option>
                <option value="Speech Impairment">መናገር የተሳነው</option>
            </select>

            <div class="mb-2">
                <label class="block text-sm">Phone</label>
                <input type="text" name="phone_no" id="modal_phone_no" class="border p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label class="block text-sm">Fayida ID</label>
                <input type="text" name="fayda_id" id="modal_fayda_id" class="border p-2 w-full rounded">
            </div>

            <div class="mb-4">
                <label for="departure_datetime" class="block">Departure Date and Time</label>
                <input 
                    type="datetime-local" 
                    name="departure_datetime" 
                    id="departure_datetime" 
                    class="w-full p-2 border rounded" 
                    value="{{ now()->format('Y-m-d\TH:i') }}" 
                    required
                >
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeModal()" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Save</button>
            </div>
        </form>
    </div>
</div>

            {{ $tickets->links() }} <!-- Pagination links -->
        @else
            <p class="text-center text-gray-500">No tickets found.</p>
        @endif
    </div>
</div>


<!-- Script -->
<script>
    function openEditModal(id, name, gender, phone, faydaId, ageStatus, disabilityStatus) {
        const form = document.getElementById('editTicketForm');
        form.action = `/ticketer/tickets/${id}/update`;

        document.getElementById('modal_ticket_id').value = id;
        document.getElementById('modal_passenger_name').value = name;
        document.getElementById('modal_gender').value = gender;
        document.getElementById('modal_phone_no').value = phone;
        document.getElementById('modal_fayda_id').value = faydaId;
        document.getElementById('age_status').value = ageStatus;
        document.getElementById('disability_status').value = disabilityStatus;

        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>




@endsection