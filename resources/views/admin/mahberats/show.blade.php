@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">🏢 Mahberat Details</h1>
            <p class="text-amber-700">Complete information about {{ $mahberat->name }}</p>
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
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                    <path d="M6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="text-center">
                            <h2 class="text-2xl font-bold text-amber-900 mb-1">{{ $mahberat->name }}</h2>
                            <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">
                                Mahberat Group
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
                            <span class="text-amber-700">Total Users</span>
                            <span class="font-bold text-amber-900">{{ $mahberat->users->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-amber-700">Assigned Destinations</span>
                            <span class="font-bold text-amber-900">{{ $mahberat->destinations->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="lg:col-span-2">
                <!-- Destinations -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Assigned Destinations
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        @if($mahberat->destinations->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($mahberat->destinations as $destination)
                                    <div class="bg-amber-50 rounded-lg p-4 border border-amber-200">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="font-semibold text-amber-900">{{ $destination->destination_name }}</h4>
                                                <p class="text-sm text-amber-700">From: {{ $destination->start_from }}</p>
                                                <p class="text-sm text-amber-600">Tariff: {{ number_format($destination->tariff) }} ETB</p>
                                            </div>
                                            <div class="text-amber-600">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-amber-900">No destinations assigned</h3>
                                <p class="mt-1 text-sm text-amber-600">This mahberat has no assigned destinations yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Users -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-200">
                        <h3 class="text-2xl font-bold text-amber-900 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            Assigned Users
                        </h3>
                    </div>
                    <div class="px-8 py-6">
                        @if($mahberat->users->count() > 0)
                            <div class="space-y-4">
                                @foreach($mahberat->users as $user)
                                    <div class="flex items-center justify-between p-4 bg-amber-50 rounded-lg border border-amber-200">
                                        <div class="flex items-center space-x-4">
                                            @if($user->profile_photo_path)
                                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                                     alt="Profile" class="w-12 h-12 rounded-full object-cover border-2 border-amber-200">
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-semibold text-amber-900">{{ $user->name }}</h4>
                                                <p class="text-sm text-amber-700">{{ $user->email }}</p>
                                                <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 text-xs rounded-full">
                                                    {{ ucfirst($user->usertype) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($user->is_blocked ?? false)
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
                                <h3 class="mt-2 text-sm font-medium text-amber-900">No users assigned</h3>
                                <p class="mt-1 text-sm text-amber-600">This mahberat has no assigned users yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('admin.mahberats.index') }}" 
               class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Mahberats
            </a>
        </div>
    </div>
</div>
@endsection