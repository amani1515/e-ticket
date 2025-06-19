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

            <form action="{{ route('ticketer.tickets.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="passenger_name" class="block">Passenger Full Name</label>
                    <input type="text" name="passenger_name" id="passenger_name" class="w-full p-2 border rounded"
                        value="{{ old('passenger_name') }}" maxlength="30" pattern="[a-zA-Z\u1200-\u137F\s./]+"
                        title="Only letters, Amharic characters, spaces, dots (.), and slashes (/) are allowed." required>
                    @error('passenger_name')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="age_status" class="block">Age Status</label>
                    <select name="age_status" id="age_status" class="w-full p-2 border rounded" required>
                        <option value="">Select Age Status</option>
                        <option value="adult" {{ old('age_status') == 'adult' ? 'selected' : '' }}>ወጣት</option>
                        <option value="baby" {{ old('age_status') == 'baby' ? 'selected' : '' }}>ታዳጊ</option>
                        <option value="middle_aged" {{ old('age_status') == 'middle_aged' ? 'selected' : '' }}>ጎልማሳ</option>
                        <option value="senior" {{ old('age_status') == 'senior' ? 'selected' : '' }}>አዛውንት</option>
                    </select>
                    @error('age_status')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="gender" class="block">Gender</label>
                    <select name="gender" id="gender" class="w-full p-2 border rounded" required>
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="disability_status" class="block">Disability Status</label>
                    <select name="disability_status" id="disability_status" class="w-full p-2 border rounded" required>
                        <option value="">Select Disability Status</option>
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
                    @error('disability_status')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>


                <div class="mb-4">
                    <label for="destination_id" class="block">Destination</label>
                    <select name="destination_id" id="destination_id" class="w-full p-2 border rounded" required>
                        <option value="">Select Destination</option>
                        @foreach (auth()->user()->destinations as $destination)
                            <option value="{{ $destination->id }}"
                                {{ old('destination_id') == $destination->id ? 'selected' : '' }}>
                                {{ e($destination->destination_name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="bus_id" class="block">Bus ID / Targa No</label>
                    <input type="text" name="bus_id" id="bus_id" class="w-full p-2 border rounded bg-gray-100"
                        value="{{ old('bus_id') }}" required readonly>
                    @error('bus_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="departure_datetime" class="block">Departure Date and Time</label>
                    <input type="datetime-local" name="departure_datetime" id="departure_datetime"
                        class="w-full p-2 border rounded"
                        value="{{ old('departure_datetime', now()->format('Y-m-d\TH:i')) }}"
                        min="{{ now()->format('Y-m-d\TH:i') }}" required>
                    @error('departure_datetime')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="cargo_uid" class="block">Scan/Enter Cargo Ticket (optional)</label>
                    <input type="text" id="cargo_uid" class="w-full p-2 border rounded"
                        placeholder="Scan or enter cargo ticket barcode" maxlength="50" pattern="[A-Za-z0-9\-_]+"
                        title="Only alphanumeric characters, hyphens, and underscores are allowed">
                    <input type="hidden" name="cargo_id" id="cargo_id" value="{{ old('cargo_id') }}">
                    <div id="cargo-info" class="text-sm text-green-700 mt-2"></div>
                    @error('cargo_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <!-- Optional phone number -->
                <div class="mb-4">
                    <label for="phone_no" class="block">Phone Number</label>
                    <input type="tel" name="phone_no" id="phone_no" class="w-full p-2 border rounded"
                        placeholder="09XXXXXXXX" value="{{ old('phone_no') }}" maxlength="10" pattern="[0-9]{1,10}"
                        title="Please enter only numbers (maximum 10 digits)"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    @error('phone_no')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <!-- Optional Fayda ID -->
                <div class="mb-4">
                    <label for="fayda_id" class="block">Fayda ID</label>
                    <input type="text" name="fayda_id" id="fayda_id" class="w-full p-2 border rounded"
                        placeholder="Fayda ID" value="{{ old('fayda_id') }}" maxlength="20" pattern="[A-Za-z0-9]+"
                        title="Only letters and number allowed"
                        oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')">
                    @error('fayda_id')
                        <span class="text-red-500 text-sm">{{ e($message) }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Create Ticket</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Input sanitization function
            function sanitizeInput(input) {
                const div = document.createElement('div');
                div.textContent = input;
                return div.innerHTML;
            }

            // Validate numeric input
            function isValidNumeric(value) {
                return /^[0-9]+$/.test(value);
            }

            function fetchFirstQueuedBus(destinationId) {
                if (!destinationId || !isValidNumeric(destinationId)) {
                    document.getElementById('bus_id').value = '';
                    return;
                }

                fetch('/ticketer/first-queued-bus/' + encodeURIComponent(destinationId), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') || ''
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const busIdInput = document.getElementById('bus_id');
                        busIdInput.value = sanitizeInput(data.bus_id || '');
                    })
                    .catch(error => {
                        console.error('Error fetching bus data:', error);
                        document.getElementById('bus_id').value = '';
                    });
            }

            const destinationSelect = document.getElementById('destination_id');
            destinationSelect.addEventListener('change', function() {
                fetchFirstQueuedBus(this.value);
            });

            // Fetch on page load for the default selected destination
            if (destinationSelect.value) {
                fetchFirstQueuedBus(destinationSelect.value);
            }

            // Cargo UID handling with security
            const cargoUidInput = document.getElementById('cargo_uid');
            if (cargoUidInput) {
                cargoUidInput.addEventListener('change', function() {
                    const uid = this.value.trim();
                    const infoDiv = document.getElementById('cargo-info');
                    const cargoIdInput = document.getElementById('cargo_id');

                    if (!uid) {
                        infoDiv.textContent = '';
                        cargoIdInput.value = '';
                        return;
                    }

                    // Validate cargo UID format
                    if (!/^[A-Za-z0-9\-_]+$/.test(uid)) {
                        infoDiv.textContent = 'Invalid cargo UID format!';
                        infoDiv.className = 'text-sm text-red-700 mt-2';
                        cargoIdInput.value = '';
                        return;
                    }

                    fetch('/ticketer/cargo-info/' + encodeURIComponent(uid), {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    ?.getAttribute('content') || ''
                            }
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data && data.id) {
                                infoDiv.textContent =
                                    `Cargo found: ${sanitizeInput(data.cargo_uid)}, Weight: ${sanitizeInput(data.weight)} kg`;
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
                });
            }

            // Form validation before submission
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const passengerName = document.getElementById('passenger_name').value.trim();
                    const phoneNo = document.getElementById('phone_no').value.trim();

                    // Validate passenger name
                    if (!/^[a-zA-Z\s\u1200-\u137F]+$/.test(passengerName)) {
                        e.preventDefault();
                        alert('Passenger name can only contain letters and spaces.');
                        return false;
                    }

                    // Validate phone number if provided
                    if (phoneNo && !/^[0-9+\-\s]+$/.test(phoneNo)) {
                        e.preventDefault();
                        alert('Phone number can only contain numbers, plus sign, hyphens, and spaces.');
                        return false;
                    }
                });
            }
        });
    </script>
@endsection
