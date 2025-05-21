@extends('admin.layout.app')

@section('content')
<div class="max-w-7xl mx-auto p-4">

    <h2 class="text-3xl font-bold text-yellow-600 mb-6">Ticket Report</h2>

    {{-- Ticket Table --}}
    <div class="overflow-x-auto bg-white rounded shadow mb-8">
        <table class="min-w-full text-left">
            <thead class="bg-yellow-100 text-yellow-800">
                <tr>
                    <th class="px-4 py-2">Passenger</th>
                    <th class="px-4 py-2">Gender</th>
                    <th class="px-4 py-2">Destination</th>
                    <th class="px-4 py-2">Age Status</th>
                    <th class="px-4 py-2">Bus ID</th>
                    <th class="px-4 py-2">Tariff</th>
                    <th class="px-4 py-2">Tax</th>
                    <th class="px-4 py-2">Service Fee</th>
                    <th class="px-4 py-2">Total Price</th>
                    <th class="px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr class="hover:bg-yellow-50 border-b">
                        <td class="px-4 py-2">{{ $ticket->passenger_name }}</td>
                        <td class="px-4 py-2">{{ $ticket->gender }}</td>
                        <td class="px-4 py-2">{{ $ticket->destination->destination_name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ $ticket->age_status }}</td>
                        <td class="px-4 py-2">{{ $ticket->bus_id }}</td>
                        <td class="px-4 py-2">{{ number_format($ticket->destination->tariff ?? 0, 2) }}</td>
                        <td class="px-4 py-2">{{ number_format($ticket->destination->tax ?? 0, 2) }}</td>
                        <td class="px-4 py-2">{{ number_format($ticket->destination->service_fee ?? 0, 2) }}</td>
                        <td class="px-4 py-2 font-semibold text-yellow-700">
                            {{ number_format(($ticket->destination->tariff ?? 0) + ($ticket->destination->tax ?? 0) + ($ticket->destination->service_fee ?? 0), 2) }}
                        </td>
                        <td class="px-4 py-2">{{ $ticket->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Summary --}}
    <h3 class="text-2xl font-semibold text-yellow-700 mb-4">Summary</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Tariff</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['total_tariff'] }} ETB</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Tax</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['total_tax'] }} ETB</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Service Fee</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['total_service_fee'] }} ETB</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Male</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['male'] }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Female</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['female'] }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Adult</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['adult'] }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Baby</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['baby'] }}</p>
        </div>
        <div class="bg-yellow-50 p-4 rounded shadow">
            <p class="text-gray-600">Total Senior</p>
            <p class="text-yellow-700 font-bold">{{ $summaries['senior'] }}</p>
        </div>
    </div>

    {{-- Summary by Destination --}}
    <h3 class="text-2xl font-semibold text-yellow-700 mb-4">Summary by Destination</h3>
    <ul class="bg-white rounded shadow p-4 space-y-2">
        @foreach($summaries['by_destination'] as $destination => $count)
            <li class="text-gray-700">
                <span class="text-yellow-700 font-medium">{{ $destination }}:</span> {{ $count }} passengers
            </li>
        @endforeach
    </ul>
</div>
@endsection
