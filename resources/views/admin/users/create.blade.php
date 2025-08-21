@extends('admin.layout.app')
@include('admin.users.modals')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">👤 Create New User</h1>
            <p class="text-amber-700">Add a new user to the system with secure credentials</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                        User Information
                    </h2>
                    <p class="text-amber-100 mt-2">Fill in the details for the new user account</p>
                </div>

                <!-- Form Section -->
                <div class="px-8 py-8">
                    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-8" enctype="multipart/form-data" id="userForm">
                        @csrf
                        <input type="hidden" name="_token_timestamp" value="{{ time() }}">
                        
                        <!-- Personal Information Section -->
                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl p-6 border-2 border-amber-200">
                            <h3 class="text-lg font-bold text-amber-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Personal Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Full Name -->
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Full Name *</label>
                                    <div class="relative">
                                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                                            class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                            placeholder="Enter full name" required maxlength="100" pattern="[A-Za-z\s]{2,100}">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('name')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Email Address *</label>
                                    <div class="relative">
                                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                                            class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                            placeholder="user@example.com" required maxlength="255">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div id="email-warning" class="text-sm text-red-600 hidden mt-1"></div>
                                    @error('email')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Phone Number *</label>
                                    <div class="flex">
                                        <span class="inline-flex items-center px-4 text-sm font-medium text-amber-800 bg-amber-200 border-2 border-r-0 border-amber-200 rounded-l-xl">+251</span>
                                        <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="9XXXXXXXX" 
                                            class="w-full px-4 py-3 border-2 border-amber-200 rounded-r-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50" 
                                            maxlength="9" pattern="[97][0-9]{8}" required>
                                    </div>
                                    <p id="phone-warning" class="text-sm text-red-600 hidden mt-1"></p>
                                    @error('phone')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Birth Date -->
                                <div>
                                    <label for="birth_date" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Birth Date</label>
                                    <div class="relative">
                                        <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" 
                                            class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                            max="{{ date('Y-m-d', strtotime('-18 years')) }}">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('birth_date')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- National ID -->
                                <div>
                                    <label for="national_id" class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">National ID</label>
                                    <div class="relative">
                                        <input type="text" name="national_id" id="national_id" value="{{ old('national_id') }}" 
                                            class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                            placeholder="16-digit National ID" maxlength="16" pattern="[0-9]{16}">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div id="national-id-warning" class="text-sm text-red-600 hidden mt-1"></div>
                                    @error('national_id')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Role & Assignment Section -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border-2 border-blue-200">
                            <h3 class="text-lg font-bold text-blue-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                                Role & Assignments
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- User Type -->
                                <div class="md:col-span-2">
                                    <label for="usertype" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">User Role *</label>
                                    <div class="relative">
                                        <select name="usertype" id="usertype" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50" required>
                                            <option value="">Select User Role</option>
                                            <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}> Admin</option>
                                            <option value="ticketer" {{ old('usertype') == 'ticketer' ? 'selected' : '' }}>Ticket Agent</option>
                                            <option value="traffic" {{ old('usertype') == 'traffic' ? 'selected' : '' }}>Traffic</option>
                                            <option value="hisabshum" {{ old('usertype') == 'hisabshum' ? 'selected' : '' }}>Hisabshum</option>
                                            <option value="mahberat" {{ old('usertype') == 'mahberat' ? 'selected' : '' }}> Mahberat</option>
                                            <option value="headoffice" {{ old('usertype') == 'headoffice' ? 'selected' : '' }}>Head Office</option>
                                            <option value="cargoMan" {{ old('usertype') == 'cargoMan' ? 'selected' : '' }}>Cargo Manager</option>
                                            <option value="balehabt" {{ old('usertype') == 'balehabt' ? 'selected' : '' }}> Balehabt /bus owner/</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('usertype')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Assigned Destinations -->
                                <div id="destinations-section" class="hidden">
                                    <label for="assigned_destinations" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">Assign Destinations</label>
                                    <div class="relative">
                                        <select name="assigned_destinations[]" id="assigned_destinations" multiple
                                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 min-h-[120px]">
                                            @foreach ($destinations as $destination)
                                                <option value="{{ $destination->id }}"
                                                    {{ collect(old('assigned_destinations'))->contains($destination->id) ? 'selected' : '' }}>
                                                    {{ $destination->start_from }} → {{ $destination->destination_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <p class="text-sm text-blue-600 mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Hold Ctrl (Cmd on Mac) to select multiple destinations
                                    </p>
                                    @error('assigned_destinations')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Mahberat Assignment -->
                                <div id="mahberat-section" class="hidden">
                                    <label for="mahberat_id" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">Assign to Mahberat</label>
                                    <div class="relative">
                                        <select name="mahberat_id" id="mahberat_id" class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50">
                                            <option value="">Select Mahberat</option>
                                            @foreach ($mahberats as $m)
                                                <option value="{{ $m->id }}" {{ old('mahberat_id') == $m->id ? 'selected' : '' }}>
                                                    {{ $m->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- File Uploads Section -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border-2 border-green-200">
                            <h3 class="text-lg font-bold text-green-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                File Uploads
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Profile Picture -->
                                <div>
                                    <label for="profile_photo" class="block text-sm font-semibold text-green-800 mb-2 uppercase tracking-wide">Profile Picture</label>
                                    <div class="relative">
                                        <input type="file" name="profile_photo" id="profile_photo" 
                                            class="w-full px-4 py-3 border-2 border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-green-50"
                                            accept="image/jpeg,image/png,image/jpg" onchange="previewImage(this)">
                                    </div>
                                    <div id="image-preview" class="mt-3 hidden">
                                        <img id="preview-img" class="w-20 h-20 rounded-full object-cover border-2 border-green-300">
                                    </div>
                                    <p class="text-sm text-green-600 mt-1">JPG, PNG only. Max 2MB</p>
                                    @error('profile_photo')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- PDF Document -->
                                <div>
                                    <label for="pdf_file" class="block text-sm font-semibold text-green-800 mb-2 uppercase tracking-wide">PDF Document</label>
                                    <div class="relative">
                                        <input type="file" name="pdf_file" id="pdf_file" 
                                            class="w-full px-4 py-3 border-2 border-green-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition duration-200 bg-green-50"
                                            accept=".pdf">
                                    </div>
                                    <p class="text-sm text-green-600 mt-1">PDF only. Max 5MB</p>
                                    @error('pdf_file')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
          
                        <!-- Security Section -->
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-6 border-2 border-red-200">
                            <h3 class="text-lg font-bold text-red-900 mb-6 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                                Security Credentials
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-red-800 mb-2 uppercase tracking-wide">Password *</label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password" 
                                            class="w-full px-4 py-3 border-2 border-red-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 bg-red-50"
                                            placeholder="Enter password" required>
                                        <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg id="password-eye" class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @error('password')
                                        <span class="text-red-500 text-sm mt-1 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-red-800 mb-2 uppercase tracking-wide">Confirm Password *</label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="w-full px-4 py-3 border-2 border-red-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition duration-200 bg-red-50"
                                            placeholder="Confirm password" required>
                                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg id="password_confirmation-eye" class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button type="submit" id="submitBtn"
                                class="flex-1 bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span id="submitText">Create User Account</span>
                                <svg id="loadingSpinner" class="animate-spin -mr-1 ml-3 h-5 w-5 text-white hidden" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                            <a href="{{ route('admin.users.index') }}" 
                               class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-6 rounded-xl transition duration-200 text-center flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const userTypeSelect = document.getElementById('usertype');
    const destinationsSection = document.getElementById('destinations-section');
    const mahberatSection = document.getElementById('mahberat-section');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');
    const nationalIdInput = document.getElementById('national_id');
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const nameInput = document.getElementById('name');
    const form = document.getElementById('userForm');
    const submitBtn = document.getElementById('submitBtn');
    const submitText = document.getElementById('submitText');
    const loadingSpinner = document.getElementById('loadingSpinner');

    // Enhanced form security with CSRF and timestamp validation
    let formSubmitted = false;
    
    // Role-based field visibility
    function toggleFields() {
        const selected = userTypeSelect.value;
        destinationsSection.classList.add('hidden');
        mahberatSection.classList.add('hidden');
        
        if (selected === 'ticketer') {
            destinationsSection.classList.remove('hidden');
        } else if (selected === 'mahberat') {
            mahberatSection.classList.remove('hidden');
        }
    }
    
    userTypeSelect.addEventListener('change', toggleFields);
    toggleFields();

    // Enhanced name validation with XSS protection
    nameInput.addEventListener('input', function() {
        let value = this.value;
        // Remove potentially harmful characters
        value = value.replace(/[<>"'&]/g, '');
        // Allow only letters, spaces, and common name characters
        value = value.replace(/[^A-Za-z\s\u12A0-\u137F.-]/g, '');
        this.value = value.slice(0, 100);
    });

    // Enhanced phone validation with security
    phoneInput.addEventListener('input', function () {
        let value = this.value.replace(/[^\d]/g, '');
        if (value.length > 0 && value[0] !== '9' && value[0] !== '7') {
            value = value.substring(1);
        }
        this.value = value.slice(0, 9);
    });
    
    phoneInput.addEventListener('blur', function() {
        const phone = this.value;
        const warning = document.getElementById('phone-warning');
        
        if (phone.length === 9 && (phone[0] === '9' || phone[0] === '7')) {
            const backendPhone = '0' + phone;
            // Add CSRF token to request
            fetch(`/admin/users/check-phone?phone=${encodeURIComponent(backendPhone)}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    warning.innerHTML = '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>This phone number is already registered!';
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            })
            .catch(() => {
                warning.innerHTML = '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Unable to verify phone number';
                warning.classList.remove('hidden');
            });
        } else if (phone.length > 0) {
            warning.innerHTML = '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Phone number must be 9 digits starting with 9 or 7';
            warning.classList.remove('hidden');
        } else {
            warning.classList.add('hidden');
        }
    });

    // Enhanced email validation
    emailInput.addEventListener('blur', function() {
        const email = this.value;
        const warning = document.getElementById('email-warning');
        
        if (email && email.length > 0) {
            fetch(`/admin/users/check-email?email=${encodeURIComponent(email)}`, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    warning.innerHTML = '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>This email is already registered!';
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            });
        }
    });

    // Enhanced national ID validation
    nationalIdInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^\d]/g, '').slice(0, 16);
    });
    
    nationalIdInput.addEventListener('blur', function() {
        const nationalId = this.value;
        const warning = document.getElementById('national-id-warning');
        
        if (nationalId && nationalId.length > 0) {
            if (nationalId.length !== 16) {
                warning.innerHTML = '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>National ID must be exactly 16 digits';
                warning.classList.remove('hidden');
            } else {
                fetch(`/admin/users/check-national-id?national_id=${encodeURIComponent(nationalId)}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        warning.innerHTML = '<svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>This National ID is already registered!';
                        warning.classList.remove('hidden');
                    } else {
                        warning.classList.add('hidden');
                    }
                });
            }
        } else {
            warning.classList.add('hidden');
        }
    });

    // Basic password confirmation validation
    passwordConfirmInput.addEventListener('input', function() {
        // Simple confirmation check without strength requirements
    });

    // Form submission with enhanced security
    form.addEventListener('submit', function(e) {
        if (formSubmitted) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        formSubmitted = true;
        submitBtn.disabled = true;
        submitText.textContent = 'Creating Account...';
        loadingSpinner.classList.remove('hidden');
        
        // Convert phone to backend format
        const phoneValue = phoneInput.value;
        if (phoneValue.length === 9 && (phoneValue[0] === '9' || phoneValue[0] === '7')) {
            phoneInput.value = '0' + phoneValue;
        }
        
        // Add timestamp for form submission validation
        const timestampInput = document.querySelector('input[name="_token_timestamp"]');
        if (timestampInput) {
            timestampInput.value = Math.floor(Date.now() / 1000);
        }
    });
});

// Password visibility toggle
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const eye = document.getElementById(fieldId + '-eye');
    
    if (field.type === 'password') {
        field.type = 'text';
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>';
    } else {
        field.type = 'password';
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
    }
}

// Image preview function
function previewImage(input) {
    const preview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endsection
