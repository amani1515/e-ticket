{{-- filepath: d:\My comany\e-ticket\resources\views\admin\users\show.blade.php --}}
@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">User Profile</h1>
            <p class="text-amber-700">Complete user information and documents</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="bg-gradient-to-r from-yellow-400 to-amber-500 h-32"></div>
                    <div class="px-6 pb-6">
                        <div class="-mt-16 mb-4">
                            @if ($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                     alt="Profile" 
                                     class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg cursor-pointer hover:scale-105 transition-transform duration-300" 
                                     onclick="openModal('{{ asset('storage/' . $user->profile_photo_path) }}')">
                            @else
                                <div class="w-32 h-32 rounded-full mx-auto border-4 border-white shadow-lg bg-gray-300 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $user->name }}</h2>
                            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">
                                {{ ucfirst($user->usertype) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Personal Information
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Full Name</label>
                                <p class="text-lg font-semibold text-amber-900">{{ $user->name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Email Address</label>
                                <p class="text-lg text-amber-900">{{ $user->email }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Phone Number</label>
                                <p class="text-lg text-amber-900">{{ $user->phone }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">User Role</label>
                                <p class="text-lg text-amber-900">{{ ucfirst($user->usertype) }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">National ID</label>
                                <p class="text-lg text-amber-900">{{ $user->national_id ?? 'Not provided' }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Birth Date</label>
                                <p class="text-lg text-amber-900">{{ $user->birth_date ? date('F j, Y', strtotime($user->birth_date)) : 'Not provided' }}</p>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Assigned Destinations Card (Ticketers) -->
                @if($user->usertype === 'ticketer' && $user->destinations && $user->destinations->count() > 0)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Assigned Destinations
                        </h3>
                        <p class="text-amber-700 mt-2">Routes this ticketer is authorized to sell tickets for</p>
                    </div>
                    <div class="px-8 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($user->destinations as $destination)
                                <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl p-4 border-2 border-amber-200">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="font-bold text-amber-900 text-lg">{{ $destination->destination_name }}</h4>
                                            <p class="text-amber-700 text-sm">From: {{ $destination->start_from }}</p>
                                            <div class="mt-2 flex items-center space-x-4 text-sm">
                                                <span class="text-amber-600">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4"></path>
                                                    </svg>
                                                    {{ $destination->distance ?? 'N/A' }} km
                                                </span>
                                                <span class="text-amber-600">
                                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ number_format($destination->tariff + $destination->tax + $destination->service_fee) }} ETB
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <span class="inline-block px-3 py-1 bg-amber-500 text-white text-xs font-medium rounded-full">
                                                Active
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Assigned Mahberat Card (Mahberat Users) -->
                @if($user->usertype === 'mahberat' && $user->mahberat)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Assigned Mahberat
                        </h3>
                        <p class="text-amber-700 mt-2">Bus station this user is responsible for managing</p>
                    </div>
                    <div class="px-8 py-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-2xl font-bold text-blue-900">{{ $user->mahberat->name }}</h4>
                                    <p class="text-blue-700 mt-1">Bus Station Manager</p>
                                    @if($user->mahberat->destinations && $user->mahberat->destinations->count() > 0)
                                        <div class="mt-3">
                                            <p class="text-sm font-medium text-blue-800 mb-2">Managing {{ $user->mahberat->destinations->count() }} destination(s):</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($user->mahberat->destinations->take(3) as $destination)
                                                    <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                                        {{ $destination->destination_name }}
                                                    </span>
                                                @endforeach
                                                @if($user->mahberat->destinations->count() > 3)
                                                    <span class="inline-block px-2 py-1 bg-blue-200 text-blue-800 text-xs font-medium rounded-full">
                                                        +{{ $user->mahberat->destinations->count() - 3 }} more
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded-full">
                                        Manager
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Assigned Buses Card (Bus Owners) -->
                @if(in_array($user->usertype, ['admin', 'busowner']) && isset($user->buses) && $user->buses->count() > 0)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                            </svg>
                            Assigned Buses
                        </h3>
                        <p class="text-amber-700 mt-2">Buses owned or managed by this user</p>
                    </div>
                    <div class="px-8 py-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($user->buses as $bus)
                                <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-4 border-2 border-green-200">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                            </svg>
                                        </div>
                                        <span class="inline-block px-2 py-1 {{ $bus->status === 'active' ? 'bg-green-500 text-white' : 'bg-gray-400 text-white' }} text-xs font-medium rounded-full">
                                            {{ ucfirst($bus->status ?? 'Active') }}
                                        </span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-green-900 text-lg">{{ $bus->targa ?? 'N/A' }}</h4>
                                        <p class="text-green-700 text-sm">Driver: {{ $bus->driver_name ?? 'Not assigned' }}</p>
                                        <p class="text-green-600 text-xs mt-1">Phone: {{ $bus->driver_phone ?? 'N/A' }}</p>
                                        @if($bus->mahberat)
                                            <p class="text-green-600 text-xs">Station: {{ $bus->mahberat->name }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($user->buses->count() > 6)
                            <div class="mt-4 text-center">
                                <p class="text-amber-600 text-sm">Showing first 6 buses. Total: {{ $user->buses->count() }} buses</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Documents Card -->
                @if ($user->pdf_file)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mt-8">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Documents
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        <div class="flex items-center justify-between p-4 bg-amber-50 rounded-xl">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-amber-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-semibold text-amber-900">User Document</p>
                                    <p class="text-sm text-amber-600">PDF File</p>
                                </div>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ asset('storage/' . $user->pdf_file) }}" 
                                   target="_blank" 
                                   class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ asset('storage/' . $user->pdf_file) }}" 
                                   download 
                                   class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-medium rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('admin.users.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Users
            </a>
        </div>
    </div>
</div>

<!-- Profile Image Modal -->
<div id="imageModal" class="fixed hidden z-50 inset-0 bg-black bg-opacity-90 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" class="max-w-full max-h-full rounded-lg shadow-2xl">
        <button onclick="closeModal()" 
                class="absolute -top-4 -right-4 w-10 h-10 bg-amber-100 hover:bg-amber-200 text-amber-800 rounded-full flex items-center justify-center shadow-lg transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

<script>
    function openModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
        }
    });
</script>
@endsection