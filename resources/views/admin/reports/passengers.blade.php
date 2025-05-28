@extends('admin.layout.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-yellow-700 mb-6">🚌 Passenger Report</h2>

    <!-- Filter Form -->
    <form method="GET" class="flex flex-wrap gap-4 mb-6 bg-yellow-50 p-4 rounded shadow-md">
        <input type="text" name="search" placeholder="Search by ID" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" value="{{ request('search') }}">

        <select name="gender" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="">All Genders</option>
            <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
            <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
        </select>

        <select name="destination_id" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="">All Destinations</option>
            @foreach($destinations as $dest)
                <option value="{{ $dest->id }}" {{ request('destination_id') == $dest->id ? 'selected' : '' }}>
                    {{ $dest->destination_name }}
                </option>
            @endforeach
        </select>

        <select name="date_filter" class="p-2 border border-yellow-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
            <option value="">All Dates</option>
            <option value="today">Today</option>
            <option value="yesterday">Yesterday</option>
            <option value="this_week">This Week</option>
            <option value="this_month">This Month</option>
            <option value="this_year">This Year</option>
        </select>

        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded transition duration-300">🔍 Filter</button>
    </form>

    <!-- Export & Print All Button -->
    <div class="mb-4 flex gap-2">
        <a href="{{ route('admin.passenger.report.export', request()->all()) }}" class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded transition duration-300 shadow">
            📥 Export to Excel
        </a>
        <a href="{{ route('admin.passenger.report.print-all', request()->all()) }}" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded transition duration-300 shadow">
    🖨️ Print All
</a>
    </div>

    <!-- Table -->
    @if($tickets->count())
        <div class="overflow-x-auto" id="printable-table">
            <table class="w-full text-sm bg-white border border-yellow-300 shadow-md rounded">
                <thead class="bg-yellow-200 text-yellow-900">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Name</th>
                        <th class="border px-4 py-2">Gender</th>
                        <th class="border px-4 py-2">Destination</th>
                        <th class="border px-4 py-2">Age Status</th>
                        <th class="border px-4 py-2">Bus ID</th>
                        <th class="border px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-yellow-100 transition">
                            <td class="border px-4 py-2">{{ $ticket->id }}</td>
                            <td class="border px-4 py-2 font-medium text-gray-800">{{ $ticket->passenger_name }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $ticket->gender }}</td>
                            <td class="border px-4 py-2">{{ $ticket->destination->destination_name ?? '-' }}</td>
                            <td class="border px-4 py-2 capitalize">{{ $ticket->age_status }}</td>
                            <td class="border px-4 py-2">{{ $ticket->bus_id }}</td>
                            <td class="border px-4 py-2 space-x-2">
                                <a href="{{ route('admin.passenger-report.show', $ticket->id) }}" class="text-blue-600 hover:underline">View</a>
                                <form action="{{ route('admin.passenger-report.destroy', $ticket->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this ticket?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Delete</button>
                                </form>
                                <button onclick="printRow(this)" title="Print" class="text-blue-600 hover:text-blue-900 ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="inline h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-6 0v4m0 0h4m-4 0H8" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $tickets->links() }}
        </div>
    @else
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded shadow mt-4">
            No passengers found based on the current filters.
        </div>
    @endif
</div>

<script>
function printRow(btn) {
    // Clone the row and table headers for printing
    const row = btn.closest('tr').cloneNode(true);
    const table = document.createElement('table');
    table.className = 'w-full text-sm bg-white border border-yellow-300 shadow-md rounded';
    const thead = btn.closest('table').querySelector('thead').cloneNode(true);
    table.appendChild(thead);
    const tbody = document.createElement('tbody');
    tbody.appendChild(row);
    table.appendChild(tbody);

    // Open print window
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

function printFilteredTable() {
    // Print the whole filtered table
    const printable = document.getElementById('printable-table').innerHTML;
    const printWindow = window.open('', '', 'height=600,width=900');
    printWindow.document.write('<html><head><title>Print Passenger Report</title>');
    printWindow.document.write('<style>table{width:100%;border-collapse:collapse;}th,td{border:1px solid #aaa;padding:6px;text-align:left;font-size:14px;} h3{margin-bottom:10px;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h3>Passenger Report</h3>');
    printWindow.document.write(printable);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}
</script>
@endsection