@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100 py-6 px-4">
    <div class="container mx-auto max-w-4xl">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-amber-900 mb-2">👤 Passenger Details</h1>
            <p class="text-amber-700 text-lg">Complete passenger information and ticket details</p>
        </div>

        <!-- Passenger Information Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Passenger Information
                </h2>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Personal Details -->
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-amber-50 rounded-xl">
                            <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-amber-600">Full Name</p>
                                <p class="text-lg font-bold text-gray-900">{{ $ticket->passenger_name }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-blue-50 rounded-xl">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                @if($ticket->gender == 'male')
                                    <span class="text-2xl">👨</span>
                                @else
                                    <span class="text-2xl">👩</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-600">Gender</p>
                                <p class="text-lg font-bold text-gray-900 capitalize">{{ $ticket->gender }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-green-50 rounded-xl">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-green-600">Phone Number</p>
                                <p class="text-lg font-bold text-gray-900">{{ $ticket->phone_no ?: 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-purple-50 rounded-xl">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-purple-600">National ID</p>
                                <p class="text-lg font-bold text-gray-900">{{ $ticket->fayda_id ?: 'Not provided' }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-indigo-50 rounded-xl">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mr-4">
                                @if($ticket->age_status == 'baby')
                                    <span class="text-2xl">👶</span>
                                @elseif($ticket->age_status == 'adult')
                                    <span class="text-2xl">👨</span>
                                @elseif($ticket->age_status == 'middle_aged')
                                    <span class="text-2xl">👩</span>
                                @else
                                    <span class="text-2xl">👴</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-indigo-600">Age Category</p>
                                <p class="text-lg font-bold text-gray-900 capitalize">{{ str_replace('_', ' ', $ticket->age_status) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">Accessibility Needs</p>
                                <p class="text-lg font-bold text-gray-900">{{ $ticket->disability_status }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Details -->
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-blue-50 rounded-xl">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-600">Ticket ID</p>
                                <p class="text-lg font-bold text-gray-900">#{{ $ticket->id }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-green-50 rounded-xl">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-green-600">Ticket Code</p>
                                <p class="text-lg font-bold text-gray-900 font-mono">{{ $ticket->ticket_code }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-yellow-50 rounded-xl">
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                @if($ticket->ticket_status === 'created')
                                    <span class="w-6 h-6 bg-yellow-400 rounded-full"></span>
                                @elseif($ticket->ticket_status === 'confirmed')
                                    <span class="w-6 h-6 bg-green-400 rounded-full"></span>
                                @else
                                    <span class="w-6 h-6 bg-gray-400 rounded-full"></span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-yellow-600">Ticket Status</p>
                                <p class="text-lg font-bold text-gray-900 capitalize">{{ ucfirst($ticket->ticket_status) }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-purple-50 rounded-xl">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-purple-600">Departure Date</p>
                                <p class="text-lg font-bold text-gray-900">{{ date('M d, Y H:i', strtotime($ticket->departure_datetime)) }}</p>
                            </div>
                        </div>

                        @if($ticket->cancelled_at)
                        <div class="flex items-center p-4 bg-red-50 rounded-xl">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-red-600">Cancelled At</p>
                                <p class="text-lg font-bold text-gray-900">{{ date('M d, Y H:i', strtotime($ticket->cancelled_at)) }}</p>
                            </div>
                        </div>
                        @endif

                        @if($ticket->refunded_at)
                        <div class="flex items-center p-4 bg-orange-50 rounded-xl">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-orange-600">Refunded At</p>
                                <p class="text-lg font-bold text-gray-900">{{ date('M d, Y H:i', strtotime($ticket->refunded_at)) }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Travel Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Bus Information -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                        </svg>
                        Bus Information
                    </h3>
                </div>
                <div class="p-6">
                    @if ($ticket->bus)
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="font-medium text-blue-800">Bus Targa:</span>
                                <span class="font-bold text-gray-900">{{ $ticket->bus->targa }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="font-medium text-blue-800">Level:</span>
                                <span class="font-bold text-gray-900">{{ $ticket->bus->level }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                                <span class="font-medium text-blue-800">Seat Count:</span>
                                <span class="font-bold text-gray-900">{{ $ticket->bus->seat_count }}</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">No bus information available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Destination Information -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Destination Information
                    </h3>
                </div>
                <div class="p-6">
                    @if ($ticket->destination)
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="font-medium text-green-800">From:</span>
                                <span class="font-bold text-gray-900">{{ $ticket->destination->start_from }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="font-medium text-green-800">To:</span>
                                <span class="font-bold text-gray-900">{{ $ticket->destination->destination_name }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                                <span class="font-medium text-green-800">Tariff:</span>
                                <span class="font-bold text-gray-900">{{ number_format($ticket->destination->tariff, 2) }} ETB</span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                </svg>
                            </div>
                            <p class="text-gray-500">No destination information available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Cargo Information (if exists) -->
        @if ($ticket->cargo)
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
            <div class="bg-gradient-to-r from-purple-500 to-violet-600 px-6 py-4">
                <h3 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Cargo Information
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                        <span class="font-medium text-purple-800">Item:</span>
                        <span class="font-bold text-gray-900">{{ $ticket->cargo->item_name }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                        <span class="font-medium text-purple-800">Weight:</span>
                        <span class="font-bold text-gray-900">{{ $ticket->cargo->weight }} KG</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                        <span class="font-medium text-purple-800">Price:</span>
                        <span class="font-bold text-gray-900">{{ number_format($ticket->cargo->price, 2) }} ETB</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ url()->previous() }}" class="flex-1 sm:flex-none bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Reports
            </a>
            {{-- <button onclick="window.print()" class="flex-1 sm:flex-none bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H9.414a1 1 0 01-.707-.293l-2-2A1 1 0 005.586 6H4a2 2 0 00-2 2v4a2 2 0 002 2h2m3 4h6m-6 0l3-3m-3 3l3 3"></path>
                </svg>
                Print Details
            </button> --}}
        </div>
    </div>
</div>

<style>
@media print {
    body * { visibility: hidden; }
    .container, .container * { visibility: visible; }
    .container { position: absolute; left: 0; top: 0; }
    button { display: none !important; }
}
</style>
@endsection