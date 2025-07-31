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
                            @if($user->usertype === 'ticketer' && $user->destinations->count() > 0)
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Assigned Destinations</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->destinations as $destination)
                                        <span class="inline-block px-3 py-1 bg-amber-100 text-amber-800 text-sm font-medium rounded-full">
                                            {{ $destination->destination_name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if($user->usertype === 'mahberat' && $user->mahberat)
                            <div class="space-y-1">
                                <label class="text-sm font-medium text-amber-600 uppercase tracking-wide">Assigned Mahber</label>
                                <p class="text-lg text-amber-900">{{ $user->mahberat->name }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

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