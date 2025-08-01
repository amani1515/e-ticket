@extends('ticketer.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 py-6 px-4">
    <div class="container mx-auto">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-blue-900 mb-2">📋 Schedule Reports</h1>
            <p class="text-blue-700 text-lg">Monitor bus schedules and performance</p>
        </div>

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
            
            <form method="GET" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-4">
                    <div>
                        <label for="destination_id" class="block text-sm font-semibold text-blue-800 mb-2">📍 Destination</label>
                        <select name="destination_id" id="destination_id" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                            <option value="">All Destinations</option>
                            @foreach(auth()->user()->destinations as $destination)
                                <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>
                                    {{ $destination->destination_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="bus_targa" class="block text-sm font-semibold text-blue-800 mb-2">🚌 Bus Targa</label>
                        <input type="text" name="bus_targa" id="bus_targa" value="{{ request('bus_targa') }}"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                            placeholder="Enter bus targa">
                    </div>

                    <div>
                        <label for="schedule_id" class="block text-sm font-semibold text-blue-800 mb-2">🆔 Schedule ID</label>
                        <input type="text" name="schedule_id" id="schedule_id" value="{{ request('schedule_id') }}"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50"
                            placeholder="Enter schedule ID">
                    </div>

                    <div>
                        <label for="date_filter" class="block text-sm font-semibold text-blue-800 mb-2">📅 Date</label>
                        <select name="date_filter" id="date_filter" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                            <option value="">All Dates</option>
                            <option value="today" {{ request('date_filter') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="yesterday" {{ request('date_filter') == 'yesterday' ? 'selected' : '' }}>Yesterday</option>
                            <option value="this_week" {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        </select>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-blue-800 mb-2">📊 Status</label>
                        <select name="status" id="status" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-blue-50">
                            <option value="">All Status</option>
                            <option value="queued" {{ request('status') == 'queued' ? 'selected' : '' }}>Queued</option>
                            <option value="on loading" {{ request('status') == 'on loading' ? 'selected' : '' }}>On Loading</option>
                            <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Full</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
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
                    <a href="{{ request()->url() }}" class="flex-1 sm:flex-none bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Clear Filters
                    </a>
                </div>
            </form>
        </div>

        <!-- Schedule Table -->
        @if ($schedules->count())
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                        </svg>
                        Schedule Records ({{ $schedules->total() }})
                    </h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-blue-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Bus Targa</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Destination</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Capacity</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Boarding</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Confirmed</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Pending</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Service Fee</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Tariff</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Tax</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Cancelled</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Scheduled</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Net Balance</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold text-blue-800">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-blue-100">
                            @foreach($schedules as $schedule)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-4 py-3 text-sm font-medium text-blue-900">#{{ $schedule->id }}</td>
                                    <td class="px-4 py-3 text-sm font-mono text-gray-900">{{ $schedule->bus->targa ?? '-' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $schedule->destination->destination_name ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        @if($schedule->status === 'queued')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <span class="w-2 h-2 bg-yellow-400 rounded-full mr-2"></span>
                                                Queued
                                            </span>
                                        @elseif($schedule->status === 'on loading')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <span class="w-2 h-2 bg-blue-400 rounded-full mr-2"></span>
                                                Loading
                                            </span>
                                        @elseif($schedule->status === 'full')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <span class="w-2 h-2 bg-red-400 rounded-full mr-2"></span>
                                                Full
                                            </span>
                                        @elseif($schedule->status === 'paid')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                                Paid
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                                                {{ ucfirst($schedule->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $schedule->capacity }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $schedule->boarding }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ \App\Models\Ticket::where('bus_id', $schedule->bus_id)
                                                ->where('destination_id', $schedule->destination_id)
                                                ->where('schedule_id', $schedule->id)
                                                ->where('ticket_status', 'confirmed')
                                                ->count() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            {{ \App\Models\Ticket::where('bus_id', $schedule->bus_id)
                                                ->where('destination_id', $schedule->destination_id)
                                                ->whereIn('ticket_status', ['waiting_scan', 'created'])
                                                ->count() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($schedule->tickets()->sum('service_fee'), 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ number_format(($schedule->destination->tariff ?? 0) *
                                            \App\Models\Ticket::where('bus_id', $schedule->bus_id)
                                                ->where('destination_id', $schedule->destination_id)
                                                ->where('schedule_id', $schedule->id)
                                                ->whereIn('ticket_status', ['created', 'confirmed'])
                                                ->count(), 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ number_format($schedule->tickets()->sum('tax'), 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        {{ number_format(($schedule->destination->tariff ?? 0) *
                                            \App\Models\Ticket::where('bus_id', $schedule->bus_id)
                                                ->where('destination_id', $schedule->destination_id)
                                                ->where('schedule_id', $schedule->id)
                                                ->where('ticket_status', 'cancelled')
                                                ->count(), 2) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ date('M d, H:i', strtotime($schedule->scheduled_at)) }}</td>
                                    <td class="px-4 py-3 text-sm font-semibold text-green-700">
                                        {{ number_format(($schedule->destination->tariff ?? 0) *
                                            \App\Models\Ticket::where('bus_id', $schedule->bus_id)
                                                ->where('destination_id', $schedule->destination_id)
                                                ->where('schedule_id', $schedule->id)
                                                ->whereIn('ticket_status', ['created', 'confirmed'])
                                                ->count(), 2) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        @if($schedule->status === 'full')
                                            <form action="{{ route('ticketer.schedule.pay', $schedule->id) }}" method="POST" onsubmit="return confirm('Mark this schedule as paid?');" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    Pay
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 bg-blue-50 border-t border-blue-100">
                    {{ $schedules->withQueryString()->links() }}
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-blue-900 mb-2">No Schedules Found</h3>
                <p class="text-blue-700 mb-6">No schedules match your current filter criteria.</p>
            </div>
        @endif
    </div>
</div>
@endsection