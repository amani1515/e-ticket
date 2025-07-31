@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">🚌 Bus Details</h1>
            <p class="text-amber-700">Complete information about {{ $bus->targa }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-amber-500 to-yellow-500 h-32"></div>
                    <div class="px-6 pb-6">
                        <div class="-mt-16 mb-4">
                            <div class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg bg-amber-100 flex items-center justify-center">
                                <svg class="w-16 h-16 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-.293-.707L15 4.586A1 1 0 0014.414 4H14v3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-amber-900 mb-1">{{ $bus->targa }}</h2>
                            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">
                                {{ ucfirst($bus->status) }}
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
                            <span class="text-amber-700">Total Seats</span>
                            <span class="font-bold text-amber-900">{{ $bus->total_seats }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-amber-700">Cargo Capacity</span>
                            <span class="font-bold text-amber-900">{{ $bus->cargo_capacity ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-amber-700">Total Schedules</span>
                            <span class="font-bold text-amber-900">{{ $bus->schedules->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="lg:col-span-2">
                <!-- Bus Information -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Bus Information
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Targa Number</label>
                                <p class="text-lg font-semibold text-amber-900">{{ $bus->targa }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Unique Bus ID</label>
                                <p class="text-lg text-amber-900">{{ $bus->unique_bus_id ?? 'Not assigned' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Driver Name</label>
                                <p class="text-lg text-amber-900">{{ $bus->driver_name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Driver Phone</label>
                                <p class="text-lg text-amber-900">{{ $bus->driver_phone }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Model & Year</label>
                                <p class="text-lg text-amber-900">{{ $bus->model ?? 'N/A' }} ({{ $bus->model_year ?? 'N/A' }})</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Color</label>
                                <p class="text-lg text-amber-900">{{ $bus->color ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Level</label>
                                <p class="text-lg text-amber-900">{{ $bus->level ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Sub Level</label>
                                <p class="text-lg text-amber-900">{{ $bus->sub_level ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Mahberat</label>
                                <p class="text-lg text-amber-900">{{ $bus->mahberat->name ?? 'Not assigned' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Owner</label>
                                <p class="text-lg text-amber-900">{{ $bus->owner->name ?? 'Not assigned' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Registered By</label>
                                <p class="text-lg text-amber-900">{{ $bus->registeredBy->name ?? 'N/A' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Motor Number</label>
                                <p class="text-lg text-amber-900">{{ $bus->motor_number ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Files Section -->
                @if($bus->file1 || $bus->file2 || $bus->file3)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Registration Documents
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($bus->file1)
                            <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl border border-amber-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-amber-900">Document 1</p>
                                        <p class="text-sm text-amber-600">Registration File</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ asset('storage/' . $bus->file1) }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ asset('storage/' . $bus->file1) }}" download 
                                       class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($bus->file2)
                            <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl border border-amber-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-amber-900">Document 2</p>
                                        <p class="text-sm text-amber-600">License File</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ asset('storage/' . $bus->file2) }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ asset('storage/' . $bus->file2) }}" download 
                                       class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                            @endif
                            
                            @if($bus->file3)
                            <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl border border-amber-200">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-amber-900">Document 3</p>
                                        <p class="text-sm text-amber-600">Insurance File</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ asset('storage/' . $bus->file3) }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View
                                    </a>
                                    <a href="{{ asset('storage/' . $bus->file3) }}" download 
                                       class="inline-flex items-center px-3 py-1.5 bg-green-500 hover:bg-green-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Schedules -->
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
                        @if($bus->schedules->count() > 0)
                            <div class="space-y-4">
                                @foreach($bus->schedules->take(5) as $schedule)
                                    <div class="flex items-center justify-between p-4 bg-amber-50 rounded-lg border border-amber-200">
                                        <div>
                                            <h4 class="font-semibold text-amber-900">{{ $schedule->destination->destination_name ?? 'N/A' }}</h4>
                                            <p class="text-sm text-amber-700">Departure: {{ $schedule->departure_time }}</p>
                                            <p class="text-sm text-amber-600">Date: {{ $schedule->departure_date }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">
                                                {{ ucfirst($schedule->status ?? 'scheduled') }}
                                            </span>
                                            <p class="text-sm text-amber-600 mt-1">{{ $schedule->boarded_passengers ?? 0 }}/{{ $bus->total_seats }} passengers</p>
                                        </div>
                                    </div>
                                @endforeach
                                @if($bus->schedules->count() > 5)
                                    <p class="text-center text-amber-600 text-sm">And {{ $bus->schedules->count() - 5 }} more schedules...</p>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-amber-900">No schedules found</h3>
                                <p class="mt-1 text-sm text-amber-600">This bus has no scheduled trips yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center space-x-4">
            <a href="{{ route('admin.buses.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Buses
            </a>
            <a href="{{ route('admin.buses.banner', $bus->id) }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                Print QR Code
            </a>
        </div>
    </div>
</div>
@endsection