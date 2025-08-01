@extends('ticketer.layout.app')

@section('content')
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
                            autocomplete="name" data-validation="required|alpha_spaces|min:2|max:30" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="validation-error text-red-500 text-sm mt-1" id="passenger_name_error"></div>
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
                            data-validation="required" required>
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
                    <div class="validation-error text-red-500 text-sm mt-1" id="age_status_error"></div>
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
                    <div class="validation-error text-red-500 text-sm mt-1" id="gender_error"></div>
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
                            data-validation="required" required>
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
                    <div class="validation-error text-red-500 text-sm mt-1" id="disability_status_error"></div>
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
                            data-validation="required" required>
                            <option value="">Select Destination</option>
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
                    <div class="validation-error text-red-500 text-sm mt-1" id="destination_id_error"></div>
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
                            value="{{ old('bus_id') }}" data-validation="required" required readonly placeholder="Auto-assigned based on destination">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="validation-error text-red-500 text-sm mt-1" id="bus_id_error"></div>
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
                            data-validation="required" required readonly>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="validation-error text-red-500 text-sm mt-1" id="departure_datetime_error"></div>
                </div>

                <!-- Cargo Ticket -->
                <div>
                    <label for="cargo_uid" class="block text-sm font-semibold text-blue-800 mb-2 uppercase tracking-wide">
                        Cargo Ticket (Optional)
                    </label>
                    <div class="relative">
                        <input type="text" id="cargo_uid"
                            class="w-full px-4 py-3 border-2 border-blue-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-blue-50 text-lg"
                            placeholder="Scan or enter cargo barcode" maxlength="50" pattern="[A-Za-z0-9\-_]+"
                            data-validation="alphanumeric_dash">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                    <input type="hidden" name="cargo_id" id="cargo_id" value="{{ old('cargo_id') }}">
                    <div id="cargo-info" class="text-sm text-green-700 mt-2 p-2 bg-green-50 rounded-lg hidden"></div>
                    <div class="validation-error text-red-500 text-sm mt-1" id="cargo_uid_error"></div>
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
                            pattern="[97][0-9]{8}" data-validation="phone_number" autocomplete="tel">
                    </div>
                    <p id="phone_no_warning" class="text-sm text-red-600 hidden mt-1 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </p>
                    <div class="validation-error text-red-500 text-sm mt-1" id="phone_no_error"></div>
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
                            pattern="[0-9]{16}" data-validation="national_id" autocomplete="off">
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
                    <div class="validation-error text-red-500 text-sm mt-1" id="fayda_id_error"></div>
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
    </div>
</div>

    <style>
        /* Gender radio button styling */
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
        
        /* Mobile optimizations */
        @media (max-width: 640px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
        }
        
        /* Loading animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Smooth transitions */
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
        document.addEventListener('DOMContentLoaded', function() {
            // Security constants
            const MAX_REQUEST_ATTEMPTS = 3;
            const REQUEST_TIMEOUT = 10000; // 10 seconds
            let requestAttempts = 0;
            let isSubmitting = false;

            // Enhanced input sanitization function
            function sanitizeInput(input) {
                if (typeof input !== 'string') return '';
                const div = document.createElement('div');
                div.textContent = input.toString().trim();
                return div.innerHTML;
            }

            // Enhanced HTML entity encoding
            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;',
                    '/': '&#x2F;',
                    '`': '&#x60;',
                '=': '&#x3D;'
            };
            return text.replace(/[&<>"'`=\/]/g, function(s) {
                    return map[s];
                });
            }

            // Comprehensive validation functions
            const validators = {
                required: function(value) {
                    return value && value.trim().length > 0;
                },

                alpha_spaces: function(value) {
                    return /^[a-zA-Z\u1200-\u137F\s./]+$/.test(value);
                },

                min: function(value, param) {
                    return value.length >= parseInt(param);
                },

                max: function(value, param) {
                    return value.length <= parseInt(param);
                },

                alphanumeric: function(value) {
                    return /^[A-Za-z0-9]*$/.test(value);
                },

                alphanumeric_dash: function(value) {
                    return /^[A-Za-z0-9\-_]*$/.test(value);
                },

                phone_number: function(value) {
                    if (!value) return true; // Optional field
                    return /^[97][0-9]{8}$/.test(value);
                },

                national_id: function(value) {
                    if (!value) return true; // Optional field
                    return /^[0-9]{16}$/.test(value);
                },

                numeric: function(value) {
                    return /^[0-9]+$/.test(value);
                }
            };

            // Validate individual field
            function validateField(field) {
                const value = field.value.trim();
                const validationRules = field.getAttribute('data-validation');
                const errorDiv = document.getElementById(field.id + '_error');

                if (!validationRules) return true;

                const rules = validationRules.split('|');
                let isValid = true;
                let errorMessage = '';

                for (let rule of rules) {
                    const [ruleName, param] = rule.split(':');

                    if (!validators[ruleName]) continue;

                    if (!validators[ruleName](value, param)) {
                        isValid = false;
                        errorMessage = getErrorMessage(field, ruleName, param);
                        break;
                    }
                }

                // Update field appearance and error message
                if (isValid) {
                    field.classList.remove('border-red-500');
                    field.classList.add('border-green-500');
                    errorDiv.textContent = '';
                } else {
                    field.classList.remove('border-green-500');
                    field.classList.add('border-red-500');
                    errorDiv.textContent = errorMessage;
                }

                return isValid;
            }

            // Get appropriate error message
            function getErrorMessage(field, rule, param) {
                const fieldName = field.getAttribute('data-field-name') || field.name.replace('_', ' ');
                const messages = {
                    required: `${fieldName} is required.`,
                    alpha_spaces: `${fieldName} can only contain letters and spaces.`,
                    min: `${fieldName} must be at least ${param} characters.`,
                    max: `${fieldName} cannot exceed ${param} characters.`,
                    alphanumeric: `${fieldName} can only contain letters and numbers.`,
                    alphanumeric_dash: `${fieldName} can only contain letters, numbers, hyphens, and underscores.`,
                    phone_number: `${fieldName} must be exactly 9 digits starting with 9 or 7.`,
                    national_id: `${fieldName} must be exactly 16 digits.`,
                    numeric: `${fieldName} must contain only numbers.`
                };
                return messages[rule] || `${fieldName} is invalid.`;
            }

            // Real-time validation
            const formFields = document.querySelectorAll('[data-validation]');
            formFields.forEach(field => {
                field.addEventListener('blur', function() {
                    validateField(this);
                });

                field.addEventListener('input', function() {
                    // Clear previous error styling on input
                    this.classList.remove('border-red-500');
                    const errorDiv = document.getElementById(this.id + '_error');
                    if (errorDiv) errorDiv.textContent = '';
                });
            });

            // Enhanced input filtering
            document.getElementById('passenger_name').addEventListener('input', function() {
                this.value = this.value.replace(/[^a-zA-Z\u1200-\u137F\s./]/g, '');
            });

            // National ID (Fayda ID) input filtering
            document.getElementById('fayda_id').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16);
            });

            const phoneNoInput = document.getElementById('phone_no');
            
            phoneNoInput.addEventListener('input', function() {
                let value = this.value.replace(/[^0-9]/g, '');
                if (value.length > 0 && value[0] !== '9' && value[0] !== '7') {
                    value = value.substring(1);
                }
                this.value = value.slice(0, 9);
            });



            document.getElementById('cargo_uid').addEventListener('input', function() {
                this.value = this.value.replace(/[^A-Za-z0-9\-_]/g, '');
            });

            // Enhanced CSRF token handling
            function getCSRFToken() {
                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    document.querySelector('input[name="_token"]')?.value;
                if (!token) {
                    console.error('CSRF token not found');
                    throw new Error('Security token missing');
                }
                return token;
            }

            // Rate limiting for API requests
            function canMakeRequest() {
                if (requestAttempts >= MAX_REQUEST_ATTEMPTS) {
                    alert('Too many requests. Please wait before trying again.');
                    return false;
                }
                requestAttempts++;
                setTimeout(() => requestAttempts = Math.max(0, requestAttempts - 1), 60000); // Reset after 1 minute
                return true;
            }

            // Enhanced fetch with timeout and error handling
            function secureFetch(url, options = {}) {
                if (!canMakeRequest()) {
                    return Promise.reject(new Error('Rate limit exceeded'));
                }

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), REQUEST_TIMEOUT);

                const defaultOptions = {
                    signal: controller.signal,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': getCSRFToken(),
                        'Content-Type': 'application/json'
                    }
                };

                const mergedOptions = {
                    ...defaultOptions,
                    ...options
                };
                if (options.headers) {
                    mergedOptions.headers = {
                        ...defaultOptions.headers,
                        ...options.headers
                    };
                }

                return fetch(url, mergedOptions)
                    .finally(() => clearTimeout(timeoutId))
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        }
                        return response.json();
                    });
            }

            // Enhanced bus fetching with validation
            function fetchFirstQueuedBus(destinationId) {
                if (!destinationId || !validators.numeric(destinationId)) {
                    document.getElementById('bus_id').value = '';
                    return;
                }

                const busIdInput = document.getElementById('bus_id');
                busIdInput.value = 'Loading...';

                secureFetch(`/ticketer/first-queued-bus/${encodeURIComponent(destinationId)}`)
                    .then(data => {
                        if (data && data.bus_id) {
                            busIdInput.value = sanitizeInput(data.bus_id);
                        } else {
                            busIdInput.value = '';
                            console.warn('No bus data received');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching bus data:', error);
                        busIdInput.value = '';
                        if (error.message.includes('Rate limit')) {
                            alert('Please wait before selecting another destination.');
                        }
                    });
            }

            // Destination change handler
            const destinationSelect = document.getElementById('destination_id');
            destinationSelect.addEventListener('change', function() {
                fetchFirstQueuedBus(this.value);
            });

            // Fetch on page load for the default selected destination
            if (destinationSelect.value) {
                fetchFirstQueuedBus(destinationSelect.value);
            }

            // Enhanced cargo UID handling
            const cargoUidInput = document.getElementById('cargo_uid');
            if (cargoUidInput) {
                let cargoTimeout;

                cargoUidInput.addEventListener('input', function() {
                    clearTimeout(cargoTimeout);
                    const uid = this.value.trim();
                    const infoDiv = document.getElementById('cargo-info');
                    const cargoIdInput = document.getElementById('cargo_id');

                    if (!uid) {
                        infoDiv.textContent = '';
                        cargoIdInput.value = '';
                        return;
                    }

                    // Debounce the request
                    cargoTimeout = setTimeout(() => {
                        if (!validators.alphanumeric_dash(uid)) {
                            infoDiv.textContent = 'Invalid cargo UID format!';
                            infoDiv.className = 'text-sm text-red-700 mt-2';
                            cargoIdInput.value = '';
                            return;
                        }

                        secureFetch('/ticketer/cargo-info', {
                                method: 'POST',
                                body: JSON.stringify({
                                    cargo_uid: uid
                                })
                            })
                            .then(data => {
                                if (data && data.id) {
                                    infoDiv.innerHTML = `
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Cargo found: Weight: ${escapeHtml(data.weight)} kg - ${escapeHtml(data.destination)}</span>
                                        </div>
                                    `;
                                    infoDiv.className = 'text-sm text-green-700 mt-2 p-2 bg-green-50 rounded-lg';
                                    infoDiv.classList.remove('hidden');
                                    cargoIdInput.value = sanitizeInput(data.id);
                                } else {
                                    infoDiv.innerHTML = `
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            <span>Cargo not found!</span>
                                        </div>
                                    `;
                                    infoDiv.className = 'text-sm text-red-700 mt-2 p-2 bg-red-50 rounded-lg';
                                    infoDiv.classList.remove('hidden');
                                    cargoIdInput.value = '';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching cargo data:', error);
                                infoDiv.innerHTML = `
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Error fetching cargo information!</span>
                                    </div>
                                `;
                                infoDiv.className = 'text-sm text-red-700 mt-2 p-2 bg-red-50 rounded-lg';
                                infoDiv.classList.remove('hidden');
                                cargoIdInput.value = '';
                            });
                    }, 500); // 500ms debounce
                });
            }

            // Enhanced form validation and submission
            const form = document.getElementById('ticket-form');
            const submitBtn = document.getElementById('submit-btn');
            const submitText = document.getElementById('submit-text');
            const submitLoading = document.getElementById('submit-loading');

            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (isSubmitting) {
                        return false;
                    }

                    // Validate all fields
                    let isFormValid = true;
                    const requiredFields = form.querySelectorAll('[required]');

                    requiredFields.forEach(field => {
                        if (!validateField(field)) {
                            isFormValid = false;
                        }
                    });

                    // Additional custom validations
                    const passengerName = document.getElementById('passenger_name').value.trim();
                    const phoneNo = document.getElementById('phone_no').value.trim();
                    const departureDateTime = document.getElementById('departure_datetime').value;

                    // Validate passenger name
                    if (!validators.alpha_spaces(passengerName) || passengerName.length < 2) {
                        isFormValid = false;
                        document.getElementById('passenger_name_error').textContent =
                            'Passenger name must contain at least 2 characters and only letters and spaces.';
                    }

                    // Validate phone number if provided
                    const phoneNoValue = document.getElementById('phone_no').value.trim();
                    if (phoneNoValue && !validators.phone_number(phoneNoValue)) {
                        isFormValid = false;
                        document.getElementById('phone_no_error').textContent =
                            'Phone number must be exactly 9 digits starting with 9 or 7.';
                    }
                    
                    // Convert phone to backend format before submission
                    if (phoneNoValue.length === 9 && (phoneNoValue[0] === '9' || phoneNoValue[0] === '7')) {
                        document.getElementById('phone_no').value = '0' + phoneNoValue;
                    }

                    if (!isFormValid) {
                        // Scroll to first error
                        const firstError = form.querySelector('.border-red-500');
                        if (firstError) {
                            firstError.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            firstError.focus();
                        }
                        return false;
                    }

                    // Prevent double submission with enhanced UI feedback
                    isSubmitting = true;
                    submitBtn.disabled = true;
                    submitBtn.classList.add('animate-pulse');
                    document.getElementById('submit-icon').classList.add('hidden');
                    submitText.classList.add('hidden');
                    submitLoading.classList.remove('hidden');

                    // Submit the form
                    setTimeout(() => {
                        form.submit();
                    }, 100);
                });
            }

            // Prevent form resubmission on page refresh
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            // Security: Disable right-click context menu on sensitive fields
            const sensitiveFields = ['passenger_name', 'phone_no', 'fayda_id'];
            sensitiveFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('contextmenu', function(e) {
                        e.preventDefault();
                    });
                }
            });

            // Gender radio button functionality
            document.querySelectorAll('.gender-radio').forEach(radio => {
                radio.addEventListener('change', function() {
                    // Clear any previous gender validation errors
                    document.getElementById('gender_error').textContent = '';
                    
                    // Update visual state
                    document.querySelectorAll('.gender-option').forEach(option => {
                        option.classList.remove('selected');
                    });
                    
                    if (this.checked) {
                        this.nextElementSibling.classList.add('selected');
                    }
                });
            });

            // Security: Clear form data on page unload
            window.addEventListener('beforeunload', function() {
                const sensitiveInputs = form.querySelectorAll('input[type="text"], input[type="tel"]');
                sensitiveInputs.forEach(input => {
                    if (!input.hasAttribute('readonly')) {
                        input.value = '';
                    }
                });
            });

            // Initialize gender selection on page load
            const checkedGender = document.querySelector('.gender-radio:checked');
            if (checkedGender) {
                checkedGender.nextElementSibling.classList.add('selected');
            }
        });
    </script>

    <script>
document.getElementById('phone_no').addEventListener('blur', function() {
    const phone = this.value;
    const warning = document.getElementById('phone_no_warning');
    if (phone.length === 9 && (phone[0] === '9' || phone[0] === '7')) {
        const backendPhone = '0' + phone;
        fetch(`/ticketer/tickets/check-phone?phone_no=${encodeURIComponent(backendPhone)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    warning.textContent = '🚫 This phone number is already registered!';
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            });
    } else if (phone.length > 0) {
        warning.textContent = 'Phone number must be 9 digits starting with 9 or 7';
        warning.classList.remove('hidden');
    } else {
        warning.classList.add('hidden');
    }
});

document.getElementById('fayda_id').addEventListener('blur', function() {
    const faydaId = this.value;
    const warning = document.getElementById('fayda_id_warning');
    if (faydaId.length > 0) {
        if (faydaId.length !== 16 || !/^[0-9]{16}$/.test(faydaId)) {
            warning.textContent = 'National ID must be exactly 16 digits';
            warning.classList.remove('hidden');
        } else {
            fetch(`/ticketer/tickets/check-fayda-id?fayda_id=${encodeURIComponent(faydaId)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        warning.textContent = '🚫 This National ID is already registered!';
                        warning.classList.remove('hidden');
                    } else {
                        warning.classList.add('hidden');
                    }
                })
                .catch(() => {
                    warning.classList.add('hidden');
                });
        }
    } else {
        warning.classList.add('hidden');
    }
});
</script>
@endsection
