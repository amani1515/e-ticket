@extends('ticketer.layout.app')

@section('content')
    <div class="flex min-h-screen">

        <!-- Main Content -->
        <div class="flex-1 bg-gray-100 p-6">
            <h1 class="text-2xl font-semibold mb-4">Create Ticket</h1>

            @if (session('success'))
                <div class="mb-4 text-green-600">{{ e(session('success')) }}</div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ e($error) }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('ticketer.tickets.store') }}" method="POST" id="ticket-form" novalidate>
                @csrf
                <div class="mb-4">
                    <label for="passenger_name" class="block font-medium text-gray-700">Passenger Full Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="passenger_name" id="passenger_name"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('passenger_name') }}" maxlength="30" minlength="2"
                        pattern="[a-zA-Z\u1200-\u137F\s./]+"
                        title="Only letters, Amharic characters, spaces, dots (.), and slashes (/) are allowed. Minimum 2 characters."
                        autocomplete="name" data-validation="required|alpha_spaces|min:2|max:30" required>
                    <div class="validation-error text-red-500 text-sm mt-1" id="passenger_name_error"></div>
                    @error('passenger_name')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="age_status" class="block font-medium text-gray-700">Age Status <span
                            class="text-red-500">*</span></label>
                    <select name="age_status" id="age_status"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        data-validation="required" required>

                        <option value="adult" {{ old('age_status') == 'adult' ? 'selected' : '' }}>ወጣት</option>
                        <option value="baby" {{ old('age_status') == 'baby' ? 'selected' : '' }}>ታዳጊ</option>
                        <option value="middle_aged" {{ old('age_status') == 'middle_aged' ? 'selected' : '' }}>ጎልማሳ</option>
                        <option value="senior" {{ old('age_status') == 'senior' ? 'selected' : '' }}>አዛውንት</option>
                    </select>
                    <div class="validation-error text-red-500 text-sm mt-1" id="age_status_error"></div>
                    @error('age_status')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gender" class="block font-medium text-gray-700">Gender <span
                            class="text-red-500">*</span></label>
                    <select name="gender" id="gender"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        data-validation="required" required>

                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    <div class="validation-error text-red-500 text-sm mt-1" id="gender_error"></div>
                    @error('gender')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="disability_status" class="block font-medium text-gray-700">Disability Status <span
                            class="text-red-500">*</span></label>
                    <select name="disability_status" id="disability_status"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        data-validation="required" required>

                        <option value="None" {{ old('disability_status') == 'None' ? 'selected' : '' }}>None</option>
                        <option value="Blind / Visual Impairment"
                            {{ old('disability_status') == 'Blind / Visual Impairment' ? 'selected' : '' }}>Blind / Visual
                            Impairment</option>
                        <option value="Deaf / Hard of Hearing"
                            {{ old('disability_status') == 'Deaf / Hard of Hearing' ? 'selected' : '' }}>Deaf / Hard of
                            Hearing</option>
                        <option value="Speech Impairment"
                            {{ old('disability_status') == 'Speech Impairment' ? 'selected' : '' }}>Speech Impairment
                        </option>
                    </select>
                    <div class="validation-error text-red-500 text-sm mt-1" id="disability_status_error"></div>
                    @error('disability_status')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="destination_id" class="block font-medium text-gray-700">Destination <span
                            class="text-red-500">*</span></label>
                    <select name="destination_id" id="destination_id"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        data-validation="required" required>
                        <option value="">Select Destination</option>
                        @foreach (auth()->user()->destinations as $destination)
                            <option value="{{ $destination->id }}"
                                {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                {{ e($destination->destination_name) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="validation-error text-red-500 text-sm mt-1" id="destination_id_error"></div>
                    @error('destination_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bus_id" class="block font-medium text-gray-700">Bus ID / Targa No <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="bus_id" id="bus_id"
                        class="w-full p-2 border rounded bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="{{ old('bus_id') }}" data-validation="required" required readonly>
                    <div class="validation-error text-red-500 text-sm mt-1" id="bus_id_error"></div>
                    @error('bus_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="departure_datetime" class="block font-medium text-gray-700">Departure Date and Time <span
                            class="text-red-500">*</span></label>
                    <input type="datetime-local" name="departure_datetime" id="departure_datetime"
                        class="w-full p-2 border rounded bg-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="{{ now()->format('Y-m-d\TH:i') }}" max="{{ now()->addMonths(6)->format('Y-m-d\TH:i') }}"
                        data-validation="required" required readonly>
                    <div class="validation-error text-red-500 text-sm mt-1" id="departure_datetime_error"></div>
                </div>

                <div class="mb-4">
                    <label for="cargo_uid" class="block font-medium text-gray-700">Scan/Enter Cargo Ticket
                        (optional)</label>
                    <input type="text" id="cargo_uid"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Scan or enter cargo ticket barcode" maxlength="50" pattern="[A-Za-z0-9\-_]+"
                        data-validation="alphanumeric_dash"
                        title="Only alphanumeric characters, hyphens, and underscores are allowed">
                    <input type="hidden" name="cargo_id" id="cargo_id" value="{{ old('cargo_id') }}">
                    <div id="cargo-info" class="text-sm text-green-700 mt-2"></div>
                    <div class="validation-error text-red-500 text-sm mt-1" id="cargo_uid_error"></div>
                    @error('cargo_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <!-- Optional phone number -->
                <div class="mb-4">
                    <label for="phone_no" class="block font-medium text-gray-700">Phone Number</label>
                    <input type="tel" name="phone_no" id="phone_no"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="09XXXXXXXX" value="{{ old('phone_no') }}" maxlength="10" minlength="10"
                        pattern="[0-9]{10}" data-validation="phone_number" title="Please enter exactly 10 digits"
                        autocomplete="tel">
                        <p id="phone_no_warning" class="text-sm text-red-600 hidden"></p>
                    <div class="validation-error text-red-500 text-sm mt-1" id="phone_no_error"></div>
                    @error('phone_no')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <!-- Optional Fayda ID -->
                <div class="mb-4">
                    <label for="fayda_id" class="block font-medium text-gray-700">Fayda ID</label>
                    <input type="text" name="fayda_id" id="fayda_id"
                        class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Fayda ID" value="{{ old('fayda_id') }}" maxlength="20" pattern="[A-Za-z0-9]+"
                        data-validation="alphanumeric" title="Only letters and numbers allowed" autocomplete="off">
                        <p id="fayda_id_warning" class="text-sm text-red-600 hidden"></p>
                    <div class="validation-error text-red-500 text-sm mt-1" id="fayda_id_error"></div>
                    @error('fayda_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" id="submit-btn"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white p-2 rounded transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="submit-text">Create Ticket</span>
                        <span id="submit-loading" class="hidden">Creating...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

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
                    return /^[0-9]{10}$/.test(value);
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
                    phone_number: `${fieldName} must be exactly 10 digits.`,
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

            document.getElementById('phone_no').addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').substring(0, 10);
            });

            document.getElementById('fayda_id').addEventListener('input', function() {
                this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
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
                                    infoDiv.textContent =
                                        `Cargo found: Weight: ${escapeHtml(data.weight)} kg - ${escapeHtml(data.destination)}`;
                                    infoDiv.className = 'text-sm text-green-700 mt-2';
                                    cargoIdInput.value = sanitizeInput(data.id);
                                } else {
                                    infoDiv.textContent = 'Cargo not found!';
                                    infoDiv.className = 'text-sm text-red-700 mt-2';
                                    cargoIdInput.value = '';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching cargo data:', error);
                                infoDiv.textContent = 'Error fetching cargo information!';
                                infoDiv.className = 'text-sm text-red-700 mt-2';
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
                    if (phoneNo && !validators.phone_number(phoneNo)) {
                        isFormValid = false;
                        document.getElementById('phone_no_error').textContent =
                            'Phone number must be exactly 10 digits.';
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

                    // Prevent double submission
                    isSubmitting = true;
                    submitBtn.disabled = true;
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

            // Security: Clear form data on page unload
            window.addEventListener('beforeunload', function() {
                const sensitiveInputs = form.querySelectorAll('input[type="text"], input[type="tel"]');
                sensitiveInputs.forEach(input => {
                    if (!input.hasAttribute('readonly')) {
                        input.value = '';
                    }
                });
            });
        });
    </script>

    <script>
document.getElementById('phone_no').addEventListener('blur', function() {
    const phone = this.value;
    const warning = document.getElementById('phone_no_warning');
    if (phone.length === 10) {
        fetch(`/ticketer/tickets/check-phone?phone_no=${encodeURIComponent(phone)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    warning.textContent = '🚫 This phone number is already registered!';
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            });
    } else {
        warning.classList.add('hidden');
    }
});

document.getElementById('fayda_id').addEventListener('blur', function() {
    const faydaId = this.value;
    const warning = document.getElementById('fayda_id_warning');
    if (faydaId.length > 0) {
        fetch(`/ticketer/tickets/check-fayda-id?fayda_id=${encodeURIComponent(faydaId)}`)
            .then(response => response.json())
            .then(data => {
                if (data.exists) {
                    warning.textContent = '🚫 This Fayda ID is already registered!';
                    warning.classList.remove('hidden');
                } else {
                    warning.classList.add('hidden');
                }
            });
    } else {
        warning.classList.add('hidden');
    }
});
</script>
@endsection
