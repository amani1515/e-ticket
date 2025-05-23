@extends('balehabt.layout.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50 py-8 px-4">
    <div class="flex justify-end mb-4">
        <a href="{{ route('balehabt.overallBusReport') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow transition">
             Go To Overall Bus Report
        </a>
    </div>
    <h2 class="text-2xl md:text-3xl font-bold text-blue-700 mb-6 text-center">My Buses (Today’s Schedules)</h2>

    {{-- Filter Form --}}
    <form id="filterForm" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 bg-white p-4 rounded shadow">
        <input type="date" name="date" value="{{ request('date', \Illuminate\Support\Carbon::today()->toDateString()) }}" class="border rounded px-3 py-2" placeholder="Date">
        <input type="text" name="targa" value="{{ request('targa') }}" class="border rounded px-3 py-2" placeholder="Targa">
        <input type="text" name="driver_name" value="{{ request('driver_name') }}" class="border rounded px-3 py-2" placeholder="Driver Name">
        <input type="text" name="destination" value="{{ request('destination') }}" class="border rounded px-3 py-2" placeholder="Destination">
        <select name="status" class="border rounded px-3 py-2">
            <option value="">All Status</option>
            @foreach(['queued','on loading','full','departed','cancelled','paid','wellgo'] as $status)
                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>
        <button type="submit" class="md:col-span-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-4 py-2 rounded shadow">Filter</button>
        <a href="/home" class="md:col-span-1 bg-gray-400 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded shadow text-center flex items-center justify-center">
            Clear Filter
        </a>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('filterForm');
            form.querySelectorAll('input, select').forEach(function(input) {
                input.addEventListener('change', function() {
                    form.submit();
                });
            });
        });
    </script>

    @php
        $total_daily_cash_collected = 0;
        $filterDate = request('date', \Illuminate\Support\Carbon::today()->toDateString());
    @endphp

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Targa</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Driver Name</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Color</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Schedules</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buses as $bus)
                    @php
                        $todaySchedules = $bus->schedules
                            ->when($filterDate, fn($q) => $q->where('scheduled_at', '>=', $filterDate)->where('scheduled_at', '<', \Illuminate\Support\Carbon::parse($filterDate)->addDay()->toDateString()))
                            ->when(request('status'), fn($q) => $q->where('status', request('status')))
                            ->when(request('destination'), fn($q) => $q->filter(fn($s) => str_contains(strtolower(optional($s->destination)->destination_name), strtolower(request('destination')))))
                            ->sortByDesc('id');
                    @endphp
                    @if(
                        (!request('targa') || str_contains(strtolower($bus->targa), strtolower(request('targa')))) &&
                        (!request('driver_name') || str_contains(strtolower($bus->driver_name), strtolower(request('driver_name')))) &&
                        $todaySchedules->count()
                    )
                    <tr class="border-b hover:bg-blue-50 align-top">
                        <td class="px-4 py-2">{{ $bus->targa }}</td>
                        <td class="px-4 py-2">{{ $bus->driver_name }}</td>
                        <td class="px-4 py-2">{{ $bus->color }}</td>
                        <td class="px-4 py-2">
                            <div class="space-y-4">
                                @foreach($todaySchedules as $schedule)
                                    @php
                                        $tariff = $schedule->destination->tariff ?? 0;
                                        $total_cash_collected = $bus->total_seats * $tariff;
                                        $total_daily_cash_collected += $total_cash_collected;
                                    @endphp
                                    <details class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-3 transition-all duration-200">
                                        <summary class="cursor-pointer flex items-center justify-between font-semibold text-blue-800 text-lg group-open:text-blue-600">
                                            <span>
                                                <span class="mr-2">
                                                    #{{ $schedule->destination->start_from ?? '-' }} 
                                                    To {{ $schedule->destination->destination_name ?? '-' }}
                                                </span>
                                                <span class="text-xl text-green-500">({{ $schedule->status }})</span>
                                            </span>
                                            <svg class="w-5 h-5 ml-2 transition-transform duration-200 group-open:rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </summary>
                                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-1 text-sm md:text-base">
                                            <div><span class="font-semibold">Schedule UID:</span> <span class="text-blue-900">{{ $schedule->schedule_uid }}</span></div>
                                            <div><span class="font-semibold">Scheduled At:</span> <span class="text-blue-900">{{ $schedule->scheduled_at }}</span></div>
                                            <div><span class="font-semibold">Paid At:</span> <span class="text-blue-900">{{ $schedule->paid_at }}</span></div>
                                            <div><span class="font-semibold">Departed At:</span> <span class="text-blue-900">{{ $schedule->departed_at }}</span></div>
                                            <div><span class="font-semibold">Wellgo At:</span> <span class="text-blue-900">{{ $schedule->wellgo_at }}</span></div>
                                            <div><span class="font-semibold">Tariff:</span> <span class="text-blue-900">{{ $tariff }}</span></div>
                                            <div><span class="font-semibold">Destination Name:</span> <span class="text-blue-900">{{ $schedule->destination->destination_name ?? '-' }}</span></div>
                                            <div><span class="font-semibold text-green-700">Total Cash Collected:</span> <span class="text-green-900 font-bold">{{ number_format($total_cash_collected) }} ETB</span></div>
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No buses found for your account.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-8 text-right">
        <span class="text-xl font-bold text-blue-800">Total Daily Cash Collected: </span>
        <span class="text-2xl font-extrabold text-green-700">{{ number_format($total_daily_cash_collected) }} ETB</span>
    </div>
</div>
@endsection
