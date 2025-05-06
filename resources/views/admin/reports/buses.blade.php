{{-- filepath: resources/views/admin/reports/buses.blade.php --}}
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
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection