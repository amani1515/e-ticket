@extends('admin.layout.app')

@section('title', 'Schedule Reports')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 p-4 sm:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">📅 Schedule Reports</h1>
            <p class="text-amber-700">Monitor and manage all bus schedules</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow px-4 py-3">
                <div class="text-sm text-amber-600">Total Schedules</div>
                <div class="text-2xl font-bold text-amber-900">{{ $schedules->total() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow px-4 py-3">
                <div class="text-sm text-green-600">Active</div>
                <div class="text-2xl font-bold text-green-700">{{ $schedules->where('status', 'queued')->count() + $schedules->where('status', 'on loading')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow px-4 py-3">
                <div class="text-sm text-blue-600">Departed</div>
                <div class="text-2xl font-bold text-blue-700">{{ $schedules->where('status', 'departed')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow px-4 py-3">
                <div class="text-sm text-red-600">Cancelled</div>
                <div class="text-2xl font-bold text-red-700">{{ $schedules->where('status', 'cancelled')->count() }}</div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
            <form method="GET" action="{{ route('admin.schedule.reports') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-amber-700 mb-2">Search Schedules</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by ID, UID, or Bus ID..."
                                   class="w-full pl-10 pr-4 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Status</option>
                            @foreach(['queued','on loading','full','departed','cancelled','paid'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Per Page -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">Per Page</label>
                        <select name="per_page" class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            @foreach([10,20,30,50,100] as $size)
                                <option value="{{ $size }}" {{ request('per_page', 20) == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Destination Filter -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">Destination</label>
                        <select name="destination_id" class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Destinations</option>
                            @foreach($destinations as $destination)
                                <option value="{{ $destination->id }}" {{ request('destination_id') == $destination->id ? 'selected' : '' }}>{{ $destination->destination_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Bus Filter -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">Bus</label>
                        <select name="bus_id" class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Buses</option>
                            @foreach($buses as $bus)
                                <option value="{{ $bus->id }}" {{ request('bus_id') == $bus->id ? 'selected' : '' }}>{{ $bus->targa }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- From Date -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">From Date</label>
                        <input type="date" name="from_date" value="{{ request('from_date') }}" 
                               class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    
                    <!-- To Date -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">To Date</label>
                        <input type="date" name="to_date" value="{{ request('to_date') }}" 
                               class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.schedule.reports') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>
        <!-- Schedules Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            @if($schedules->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">UID</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Bus</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Destination</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Passengers</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Scheduled By</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100">
                            @foreach($schedules as $schedule)
                            <tr class="hover:bg-amber-50 transition-colors duration-200">
                                <td class="px-4 py-3 text-sm text-amber-900 font-medium">{{ $schedule->id }}</td>
                                <td class="px-4 py-3 text-sm text-amber-700">{{ $schedule->schedule_uid }}</td>
                                <td class="px-4 py-3 text-sm text-amber-900">{{ $schedule->bus->targa ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-amber-900">{{ $schedule->destination->destination_name ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    @if($schedule->status === 'queued')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                            </svg>
                                            Queued
                                        </span>
                                    @elseif($schedule->status === 'on loading')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            Loading
                                        </span>
                                    @elseif($schedule->status === 'departed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Departed
                                        </span>
                                    @elseif($schedule->status === 'cancelled')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ $schedule->boarding ?? 0 }}/{{ $schedule->capacity ?? 0 }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-amber-700">{{ $schedule->scheduledBy->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-amber-700">{{ $schedule->scheduled_at ? date('M j, Y H:i', strtotime($schedule->scheduled_at)) : '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-amber-900">No schedules found</h3>
                    <p class="mt-1 text-sm text-amber-600">Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($schedules->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow px-6 py-4">
                {{ $schedules->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection