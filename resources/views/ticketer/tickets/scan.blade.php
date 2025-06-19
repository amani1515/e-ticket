@extends('ticketer.layout.app')

@section('content')
    <div class="max-w-md mx-auto mt-10 bg-white shadow p-6 rounded">
        <h2 class="text-lg font-bold mb-4">Scan Ticket</h2>

        @if (session('success'))
            <p class="text-green-600">{{ e(session('success')) }}</p>
        @endif

        @if (session('error'))
            <p class="text-red-600">{{ e(session('error')) }}</p>
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

        <form method="POST" action="{{ route('ticketer.tickets.processScan') }}">
            @csrf
            <label for="ticket_code" class="block mb-2">Scan or Enter Ticket Code:</label>
            <input type="text" name="ticket_code" id="ticket_code" class="w-full border px-3 py-2 mb-4"
                placeholder="SE202504291234" value="{{ old('ticket_code') }}" maxlength="20" pattern="[A-Za-z0-9]+"
                title="Only letters and numbers are allowed" autocomplete="off" spellcheck="false"
                oninput="this.value = this.value.replace(/[^A-Za-z0-9]/g, '')" required>
            @error('ticket_code')
                <span class="text-red-500 text-sm block mb-2">{{ e($message) }}</span>
            @enderror

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded"
                onclick="return confirmSubmission()">Confirm Ticket</button>
        </form>


    </div>
@endsection
@section('scripts')
    <script>
        // Confirmation function
        function confirmSubmission() {
            const ticketCode = document.getElementById('ticket_code').value.trim();
            if (!ticketCode) {
                alert('Please enter a ticket code first.');
                return false;
            }
            return confirm(`Are you sure you want to confirm ticket: ${ticketCode}?`);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const input = document.querySelector('input[name="ticket_code"]');
            const form = document.querySelector('form');

            if (input) {
                // Focus on the input field
                input.focus();

                // Input validation and sanitization
                input.addEventListener('input', function() {
                    // Remove any non-alphanumeric characters
                    let sanitizedValue = this.value.replace(/[^A-Za-z0-9]/g, '');

                    // Update the input value if it was changed
                    if (this.value !== sanitizedValue) {
                        this.value = sanitizedValue;
                    }

                    // Auto-submit when reaching expected length (adjust as needed)
                    if (sanitizedValue.length >= 14) {
                        // Additional validation before submission
                        if (/^[A-Za-z0-9]{14,}$/.test(sanitizedValue)) {
                            // Ask for confirmation before auto-submit
                            if (confirm(`Are you sure you want to confirm ticket: ${sanitizedValue}?`)) {
                                this.form.submit();
                            } else {
                                // Clear the input if user cancels
                                this.value = '';
                                this.focus();
                            }
                        }
                    }
                });

                // Prevent paste of malicious content
                input.addEventListener('paste', function(e) {
                    e.preventDefault();
                    let paste = (e.clipboardData || window.clipboardData).getData('text');
                    // Only allow alphanumeric characters from paste
                    let sanitizedPaste = paste.replace(/[^A-Za-z0-9]/g, '');
                    this.value = sanitizedPaste.substring(0, 20); // Respect maxlength

                    // Trigger input event to handle auto-submit
                    this.dispatchEvent(new Event('input'));
                });

                // Prevent drag and drop
                input.addEventListener('dragover', function(e) {
                    e.preventDefault();
                });

                input.addEventListener('drop', function(e) {
                    e.preventDefault();
                });
            }

            // Add form submission confirmation
            if (form) {
                form.addEventListener('submit', function(e) {
                    // Only show confirmation if not already confirmed (to avoid double confirmation)
                    if (!e.target.dataset.confirmed) {
                        e.preventDefault();
                        if (confirmSubmission()) {
                            e.target.dataset.confirmed = 'true';
                            e.target.submit();
                        }
                    }
                });
            }
        });
    </script>
@endsection
