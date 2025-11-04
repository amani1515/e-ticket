@extends('ticketer.layout.app')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100">
    <div class="container mx-auto px-4 py-6 max-w-md">
        <!-- Header -->
        <div class="mb-6 text-center">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-blue-900 mb-2">🎫 Create New Ticket</h1>
            <p class="text-blue-700 text-sm">Fill in passenger details to generate ticket</p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="mb-4 p-4 rounded-xl bg-green-100 text-green-800 border-2 border-green-200 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ e(session('success')) }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border-2 border-red-200 text-red-800 rounded-xl">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ e($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-6 py-4">
                <h2 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Passenger Information
                </h2>
            </div>
            
            <form action="{{ route('ticketer.tickets.store') }}" method="POST" id="ticket-form" novalidate class="p-6 space-y-6">
                @csrf
                
                <!-- Passenger Name -->
                <div>
                    <label for="passenger_name" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Passenger Full Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="passenger_name" id="passenger_name"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg"
                            value="{{ old('passenger_name') }}" maxlength="30" minlength="2"
                            pattern="[a-zA-Z\u1200-\u137F\s./]+"
                            placeholder="Enter passenger full name"
                            autocomplete="name" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    @error('passenger_name')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Age Status -->
                <div>
                    <label for="age_status" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Age Category <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="age_status" id="age_status"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg appearance-none"
                            required>
                            <option value="adult" {{ old('age_status') == 'adult' ? 'selected' : '' }}>👨 ወጣት (Adult)</option>
                            <option value="baby" {{ old('age_status') == 'baby' ? 'selected' : '' }}>👶 ታዳጊ (Child)</option>
                            <option value="middle_aged" {{ old('age_status') == 'middle_aged' ? 'selected' : '' }}>👩 ጎልማሳ (Middle-aged)</option>
                            <option value="senior" {{ old('age_status') == 'senior' ? 'selected' : '' }}>👴 አዛውንት (Senior)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('age_status')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Gender <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="gender" value="male" {{ old('gender', 'male') == 'male' ? 'checked' : '' }} class="sr-only gender-radio" required>
                            <div class="gender-option flex items-center justify-center p-4 border-2 border-blue-200 rounded-xl transition duration-200 hover:border-blue-400">
                                <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium text-blue-800">👨 Male</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }} class="sr-only gender-radio" required>
                            <div class="gender-option flex items-center justify-center p-4 border-2 border-blue-200 rounded-xl transition duration-200 hover:border-blue-400">
                                <svg class="w-6 h-6 text-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="font-medium text-blue-800">👩 Female</span>
                            </div>
                        </label>
                    </div>
                    @error('gender')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Disability Status -->
                <div>
                    <label for="disability_status" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Accessibility Needs <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="disability_status" id="disability_status"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg appearance-none"
                            required>
                            <option value="None" {{ old('disability_status') == 'None' ? 'selected' : '' }}>✅ None</option>
                            <option value="Blind / Visual Impairment" {{ old('disability_status') == 'Blind / Visual Impairment' ? 'selected' : '' }}>👁️ Visual Impairment</option>
                            <option value="Deaf / Hard of Hearing" {{ old('disability_status') == 'Deaf / Hard of Hearing' ? 'selected' : '' }}>👂 Hearing Impairment</option>
                            <option value="Speech Impairment" {{ old('disability_status') == 'Speech Impairment' ? 'selected' : '' }}>🗣️ Speech Impairment</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('disability_status')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                            
                        </span>
                    @enderror
                </div>

                <!-- Destination -->
                <div>
                    <label for="destination_id" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Destination <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="destination_id" id="destination_id"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg appearance-none"
                            required>
                            <option value="" disabled selected>Select Destination *</option>
                            @foreach (auth()->user()->destinations as $destination)
                                <option value="{{ $destination->id }}"
                                    {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                    📍 {{ e($destination->destination_name) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    @error('destination_id')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Bus ID -->
                <div>
                    <label for="bus_id" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Bus ID / Targa No <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="bus_id" id="bus_id"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-gray-100 text-lg"
                            value="{{ old('bus_id') }}" required readonly placeholder="Auto-assigned based on destination">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                            </svg>
                        </div>
                    </div>
                    @error('bus_id')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Departure DateTime -->
                <div>
                    <label for="departure_datetime" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Departure Date & Time <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="datetime-local" name="departure_datetime" id="departure_datetime"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-gray-100 text-lg"
                            value="{{ now()->format('Y-m-d\TH:i') }}" max="{{ now()->addMonths(6)->format('Y-m-d\TH:i') }}"
                            required readonly>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Cargo Ticket -->
                <div>
                    <label for="cargo_uid" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Cargo Ticket (Optional)
                    </label>
                    <div class="relative">
                        <input type="text" id="cargo_uid"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg"
                            placeholder="Scan or enter cargo barcode" maxlength="50" pattern="[A-Za-z0-9\-_]+">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <input type="hidden" name="cargo_id" id="cargo_id" value="{{ old('cargo_id') }}">
                    <div id="cargo-info" class="text-sm text-green-700 mt-2 p-2 bg-green-50 rounded-lg hidden"></div>
                    @error('cargo_id')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone_no" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Phone Number (Optional)
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 text-sm font-medium text-blue-800 bg-blue-200 border-2 border-r-0 border-blue-200 rounded-l-xl">🇪🇹 +251</span>
                        <input type="tel" name="phone_no" id="phone_no"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-r-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg"
                            placeholder="9XXXXXXXX" value="{{ substr(old('phone_no'), 1) }}" maxlength="9" minlength="9"
                            pattern="[97][0-9]{8}" autocomplete="tel">
                    </div>
                    <p id="phone_no_warning" class="text-sm text-red-600 hidden mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </p>
                    @error('phone_no')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- National ID (Fayda ID) -->
                <div>
                    <label for="fayda_id" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        National ID (Optional)
                    </label>
                    <div class="relative">
                        <input type="text" name="fayda_id" id="fayda_id"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg"
                            placeholder="Enter 16-digit National ID" value="{{ old('fayda_id') }}" maxlength="16" minlength="16"
                            pattern="[0-9]{16}" autocomplete="off">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                            </svg>
                        </div>
                    </div>
                    <p id="fayda_id_warning" class="text-sm text-red-600 hidden mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </p>
                    @error('fayda_id')
                        <span class="text-red-500 text-sm flex items-center mt-1">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" id="submit-btn"
                        class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center text-lg">
                        <svg id="submit-icon" class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                        <span id="submit-text">🎫 Create Ticket</span>
                        <span id="submit-loading" class="hidden flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Creating Ticket...
                        </span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Quick Actions -->
        <div class="mt-6 grid grid-cols-2 gap-4">
            <a href="{{ route('ticketer.tickets.scan') }}" class="flex items-center justify-center p-4 bg-white rounded-xl shadow-lg border-2 border-green-200 hover:border-green-400 transition duration-200">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
                <span class="font-medium text-green-800">Scan Ticket</span>
            </a>
            <a href="{{ route('ticketer.tickets.report') }}" class="flex items-center justify-center p-4 bg-white rounded-xl shadow-lg border-2 border-purple-200 hover:border-purple-400 transition duration-200">
                <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <span class="font-medium text-purple-800">View Reports</span>
            </a>
        </div>
        
        <!-- Quick View Button -->
        <div class="mt-4">
            <button onclick="openQuickView()" class="w-full flex items-center justify-center p-4 bg-white rounded-xl shadow-lg border-2 border-orange-200 hover:border-orange-400 transition duration-200">
                <svg class="w-6 h-6 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="font-medium text-orange-800">Quick View Schedules</span>
            </button>
        </div>
    </div>
</div>

<!-- Quick View Modal -->
<div id="quickViewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl mx-4 max-h-[90vh] overflow-hidden">
        <div class="bg-orange-600 text-white px-6 py-4 rounded-t-xl">
            <h3 class="text-xl font-bold flex items-center justify-between">
                <span class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Schedule Boarding Status
                </span>
                <button onclick="closeQuickView()" class="text-white hover:text-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </h3>
        </div>
        <div class="p-6 overflow-y-auto max-h-[70vh]">
            <div id="scheduleData" class="space-y-4">
                <div class="text-center text-gray-500">Loading schedules...</div>
            </div>
        </div>
    </div>
</div>

<style>
.gender-radio:checked + .gender-option {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    border-color: #1d4ed8;
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.gender-radio:checked + .gender-option svg {
    color: white;
}

.gender-radio:checked + .gender-option span {
    color: white;
}

@media (max-width: 640px) {
    .container {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

* {
    -webkit-tap-highlight-color: transparent;
}

input, select, button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
</style>

<script>
// Quick View Modal Functions
function openQuickView() {
    document.getElementById('quickViewModal').classList.remove('hidden');
    fetchScheduleData();
}

function closeQuickView() {
    document.getElementById('quickViewModal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    var modal = document.getElementById('quickViewModal');
    if (e.target === modal) {
        closeQuickView();
    }
});

// Ticketer ownership conflict prevention is now handled server-side

function fetchScheduleData() {
    var scheduleContainer = document.getElementById('scheduleData');
    scheduleContainer.innerHTML = '<div class="text-center text-gray-500">Loading schedules...</div>';
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/ticketer/schedule-boarding-info', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    displayScheduleData(data);
                } catch (e) {
                    scheduleContainer.innerHTML = '<div class="text-center text-red-500">Error loading data</div>';
                }
            } else {
                scheduleContainer.innerHTML = '<div class="text-center text-red-500">Failed to load schedules</div>';
            }
        }
    };
    
    xhr.send();
}

function displayScheduleData(schedules) {
    var container = document.getElementById('scheduleData');
    
    if (!schedules || schedules.length === 0) {
        container.innerHTML = '<div class="text-center text-gray-500">No active schedules found</div>';
        return;
    }
    
    var html = '';
    for (var i = 0; i < schedules.length; i++) {
        var schedule = schedules[i];
        var availableSeats = schedule.capacity - schedule.boarding;
        var progressPercent = (schedule.boarding / schedule.capacity) * 100;
        
        html += '<div class="bg-gray-50 rounded-lg p-4 border">';
        html += '<div class="flex justify-between items-start mb-3">';
        html += '<div>';
        html += '<h4 class="font-semibold text-lg">' + schedule.destination_name + '</h4>';
        html += '<p class="text-sm text-gray-600">Bus: ' + schedule.bus_targa + ' | Driver: ' + schedule.driver_name + '</p>';
        html += '<p class="text-sm font-medium text-yellow-500 font-bold">ID: ' + schedule.id + '</p>';

        if (schedule.ticketer_name) {
            var ownershipClass = schedule.is_owned_by_me ? 'text-green-600' : 'text-red-600';
            var ownershipText = schedule.is_owned_by_me ? 'You are handling this' : 'Handled by: ' + schedule.ticketer_name;
            html += '<p class="text-sm font-medium ' + ownershipClass + '">' + ownershipText + '</p>';
        }
        html += '</div>';
        html += '<span class="px-3 py-1 rounded-full text-sm font-medium ' + 
                (schedule.status === 'queued' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') + '">' + 
                schedule.status + '</span>';
        html += '</div>';
        
        html += '<div class="grid grid-cols-3 gap-4 mb-3">';
        html += '<div class="text-center">';
        html += '<div class="text-2xl font-bold text-blue-600">' + schedule.capacity + '</div>';
        html += '<div class="text-sm text-gray-500">Total Seats</div>';
        html += '</div>';
        html += '<div class="text-center">';
        html += '<div class="text-2xl font-bold text-green-600">' + schedule.boarding + '</div>';
        html += '<div class="text-sm text-gray-500">Boarded</div>';
        html += '</div>';
        html += '<div class="text-center">';
        html += '<div class="text-2xl font-bold text-orange-600">' + availableSeats + '</div>';
        html += '<div class="text-sm text-gray-500">Available</div>';
        html += '</div>';
        html += '</div>';
        
        html += '<div class="w-full bg-gray-200 rounded-full h-3">';
        html += '<div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full" style="width: ' + progressPercent + '%"></div>';
        html += '</div>';
        html += '<div class="text-center text-sm text-gray-600 mt-1">' + Math.round(progressPercent) + '% Full</div>';
        html += '</div>';
    }
    
    container.innerHTML = html;
}

// Simple JavaScript for Chrome 56 compatibility
function fetchBusData(destinationId) {
    if (!destinationId) {
        document.getElementById('bus_id').value = '';
        return;
    }
    
    var busInput = document.getElementById('bus_id');
    busInput.value = 'Loading...';
    
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/ticketer/first-queued-bus/' + destinationId, true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    if (data && data.bus_id) {
                        busInput.value = data.bus_id;
                    } else {
                        busInput.value = '';
                    }
                } catch (e) {
                    busInput.value = '';
                }
            } else {
                busInput.value = '';
            }
        }
    };
    
    xhr.send();
}

// Force refresh on browser back navigation
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});

// Initialize when page loads
window.onload = function() {
    var destinationSelect = document.getElementById('destination_id');
    if (destinationSelect) {
        destinationSelect.onchange = function() {
            fetchBusData(this.value);
        };
        
        // Fetch on page load if destination is selected
        if (destinationSelect.value) {
            fetchBusData(destinationSelect.value);
        }
    }
    
    // Gender radio functionality
    var genderRadios = document.querySelectorAll('.gender-radio');
    for (var i = 0; i < genderRadios.length; i++) {
        genderRadios[i].onchange = function() {
            var genderOptions = document.querySelectorAll('.gender-option');
            for (var j = 0; j < genderOptions.length; j++) {
                genderOptions[j].className = genderOptions[j].className.replace(' selected', '');
            }
            if (this.checked) {
                this.nextElementSibling.className += ' selected';
            }
        };
    }
    
    // Initialize checked gender
    var checkedGender = document.querySelector('.gender-radio:checked');
    if (checkedGender) {
        checkedGender.nextElementSibling.className += ' selected';
    }
    
    // Phone number input filtering
    var phoneInput = document.getElementById('phone_no');
    if (phoneInput) {
        phoneInput.oninput = function() {
            var value = this.value.replace(/[^0-9]/g, '');
            // Must start with 9 or 7, limit to 9 digits
            if (value.length > 0 && value.charAt(0) !== '9' && value.charAt(0) !== '7') {
                value = '';
            }
            this.value = value.substring(0, 9);
        };
    }
    
    // National ID input filtering
    var faydaInput = document.getElementById('fayda_id');
    if (faydaInput) {
        faydaInput.oninput = function() {
            this.value = this.value.replace(/[^0-9]/g, '').substring(0, 16);
        };
    }
    
    // Passenger name input filtering
    var nameInput = document.getElementById('passenger_name');
    if (nameInput) {
        nameInput.oninput = function() {
            this.value = this.value.replace(/[^a-zA-Z\u1200-\u137F\s./]/g, '');
        };
    }
    
    // Cargo UID input filtering
    var cargoInput = document.getElementById('cargo_uid');
    if (cargoInput) {
        cargoInput.oninput = function() {
            this.value = this.value.replace(/[^A-Za-z0-9\-_]/g, '');
        };
    }
};
</script>
@endsection