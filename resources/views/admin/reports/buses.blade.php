@extends('admin.layout.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold mb-4">All Buses</h2>

    <table class="w-full border text-sm bg-white shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Targa</th>
                <th class="border px-4 py-2">Driver Name</th>
                <th class="border px-4 py-2">Driver Phone</th>
                <th class="border px-4 py-2">Total Seats</th>
                <th class="border px-4 py-2">Status</th>
                <th class="border px-4 py-2">Registered By</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buses as $bus)
            <tr>
                <td class="border px-4 py-2">{{ $bus->id }}</td>
                <td class="border px-4 py-2">{{ $bus->targa }}</td>
                <td class="border px-4 py-2">{{ $bus->driver_name }}</td>
                <td class="border px-4 py-2">{{ $bus->driver_phone }}</td>
                <td class="border px-4 py-2">{{ $bus->total_seats }}</td>
                <td class="border px-4 py-2">{{ ucfirst($bus->status) }}</td>
                <td class="border px-4 py-2">{{ $bus->registeredBy->name ?? 'N/A' }}</td>
                <td class="border px-4 py-2 text-center">
                    <button onclick="printRow(this)" title="Print" class="text-blue-600 hover:text-blue-900">
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