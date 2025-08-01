@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">🗺️ Destination Details</h1>
            <p class="text-amber-700">Complete information about {{ $destination->destination_name }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-500 h-32"></div>
                    <div class="px-6 pb-6">
                        <div class="-mt-16 mb-4">
                            <div class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg bg-amber-100 flex items-center justify-center">
                                <svg class="w-16 h-16 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-amber-900 mb-1">{{ $destination->destination_name }}</h2>
                            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">
                                Destination Route
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-bold text-amber-900">Statistics</h3>
                    </div>
                    <div class="px-6 py-4 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-amber-700">Total Schedules</span>
                            <span class="font-bold text-amber-900">{{ $destination->schedules->count() ?? 0 }}</span>
                        </div>
                        {{-- <div class="flex justify-between items-center">
                            <span class="text-amber-700">Total Tickets</span>
                            <span class="font-bold text-amber-900">{{ $destination->tickets->count() ?? 0 }}</span>
                        </div> --}}
                        <div class="flex justify-between items-center">
                            <span class="text-amber-700">Distance</span>
                            <span class="font-bold text-amber-900">{{ $destination->distance ?? 'N/A' }} km</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="lg:col-span-2">
                <!-- Route Information -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Route Information
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Destination Name</label>
                                <p class="text-lg font-semibold text-amber-900">{{ $destination->destination_name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Start From</label>
                                <p class="text-lg text-amber-900">{{ $destination->start_from }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Distance</label>
                                <p class="text-lg text-amber-900">{{ $destination->distance ?? 'Not specified' }} km</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Base Tariff</label>
                                <p class="text-lg text-amber-900">{{ number_format($destination->tariff) }} ETB</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Tax</label>
                                <p class="text-lg text-amber-900">{{ number_format($destination->tax) }} ETB</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Service Fee</label>
                                <p class="text-lg text-amber-900">{{ number_format($destination->service_fee) }} ETB</p>
                            </div>
                        </div>
                        
                        <!-- Total Cost Calculation -->
                        <div class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                            <h4 class="font-semibold text-amber-900 mb-2">Total Cost Breakdown</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-amber-700">Base Tariff:</span>
                                    <span class="text-amber-900">{{ number_format($destination->tariff) }} ETB</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-amber-700">Tax:</span>
                                    <span class="text-amber-900">{{ number_format($destination->tax) }} ETB</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-amber-700">Service Fee:</span>
                                    <span class="text-amber-900">{{ number_format($destination->service_fee) }} ETB</span>
                                </div>
                                <hr class="border-amber-300">
                                <div class="flex justify-between font-semibold text-amber-900">
                                    <span>Total Cost:</span>
                                    <span>{{ number_format($destination->tariff + $destination->tax + $destination->service_fee) }} ETB</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Ticketers -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Assigned Ticketers
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        @if($destination->users && $destination->users->where('usertype', 'ticketer')->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($destination->users->where('usertype', 'ticketer') as $ticketer)
                                    <div class="flex items-center justify-between p-4 bg-amber-50 rounded-lg border border-amber-200">
                                        <div class="flex items-center space-x-4">
                                            @if($ticketer->profile_photo_path)
                                                <img src="{{ asset('storage/' . $ticketer->profile_photo_path) }}" 
                                                     alt="Profile" class="w-12 h-12 rounded-full object-cover border-2 border-amber-200">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-semibold text-amber-900">{{ $ticketer->name }}</h4>
                                                <p class="text-sm text-amber-700">{{ $ticketer->email }}</p>
                                                <p class="text-sm text-amber-600">{{ $ticketer->phone }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($ticketer->is_blocked ?? false)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Blocked
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-amber-900">No ticketers assigned</h3>
                                <p class="mt-1 text-sm text-amber-600">This destination has no assigned ticketers yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Recent Schedules
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        @if($destination->schedules && $destination->schedules->count() > 0)
                            <div class="space-y-4">
                                @foreach($destination->schedules->take(5) as $schedule)
                                    <div class="flex items-center justify-between p-4 bg-amber-50 rounded-lg border border-amber-200">
                                        <div>
                                            <h4 class="font-semibold text-amber-900">{{ $schedule->bus->targa ?? 'N/A' }}</h4>
                                            <p class="text-sm text-amber-700">Departure: {{ $schedule->departure_time ?? 'N/A' }}</p>
                                            <p class="text-sm text-amber-600">Date: {{ $schedule->departure_date ?? 'N/A' }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">
                                                {{ ucfirst($schedule->status ?? 'scheduled') }}
                                            </span>
                                            <p class="text-sm text-amber-600 mt-1">{{ $schedule->boarded_passengers ?? 0 }}/{{ $schedule->capacity ?? 0 }} passengers</p>
                                        </div>
                                    </div>
                                @endforeach
                                @if($destination->schedules->count() > 5)
                                    <p class="text-center text-amber-600 text-sm">And {{ $destination->schedules->count() - 5 }} more schedules...</p>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-amber-900">No schedules found</h3>
                                <p class="mt-1 text-sm text-amber-600">This destination has no scheduled trips yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('admin.destinations.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Destinations
            </a>
        </div>
    </div>
</div>
@endsection