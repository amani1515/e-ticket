@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-amber-50 to-yellow-100 py-6 px-4">
    <div class="container mx-auto max-w-md">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-amber-900 mb-2">🎫 Scan Ticket</h1>
            <p class="text-amber-700 text-lg">Scan or enter ticket code to confirm</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-800 border-2 border-green-200 flex items-center shadow-lg">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold">Success!</p>
                    <p>{{ e(session('success')) }}</p>
                </div>
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-100 text-red-800 border-2 border-red-200 flex items-center shadow-lg">
                <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold">Error!</p>
                    <p>{{ e(session('error')) }}</p>
                </div>
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border-2 border-red-200 text-red-800 rounded-xl shadow-lg">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">Please fix the following errors:</span>
                </div>
                <ul class="list-disc list-inside space-y-1 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ e($error) }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Scan Form Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-yellow-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ticket Scanner
                </h2>
            </div>
            
            <form method="POST" action="{{ route('admin.tickets.processScan') }}" class="p-6 space-y-6" id="scan-form">
                @csrf
                
                <!-- Ticket Code Input -->
                <div>
                    <label for="ticket_code" class="block text-sm font-semibold text-amber-800 mb-3 uppercase tracking-wide">
                        Ticket Code <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="ticket_code" 
                            id="ticket_code"
                            class="w-full px-4 py-4 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50 text-lg font-mono text-center tracking-wider" 
                            placeholder="SE202504291234" 
                            value="{{ old('ticket_code') }}"
                            maxlength="20"
                            pattern="[A-Za-z0-9]+"
                            title="Only letters and numbers are allowed"
                            autocomplete="off"
                            spellcheck="false"
                            required
                        >
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm text-amber-600 mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Scan QR code or type ticket code manually
                    </p>
                    @error('ticket_code')
                        <span class="text-red-500 text-sm flex items-center mt-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ e($message) }}
                        </span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" id="confirm-btn"
                        class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center justify-center text-lg">
                        <svg id="confirm-icon" class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="confirm-text">✅ Confirm Ticket</span>
                        <span id="confirm-loading" class="hidden flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Message Area -->
        <div id="message-area" class="mt-6"></div>
        
        <!-- Quick Actions -->
        <div class="mt-6 grid grid-cols-2 gap-4">
            <a href="{{ route('admin.passenger-report') }}" class="flex items-center justify-center p-4 bg-white rounded-xl shadow-lg border-2 border-amber-200 hover:border-amber-400 transition duration-200">
                <span class="text-amber-700 font-medium">📊 Reports</span>
            </a>
            <button onclick="document.getElementById('ticket_code').focus()" class="flex items-center justify-center p-4 bg-white rounded-xl shadow-lg border-2 border-amber-200 hover:border-amber-400 transition duration-200">
                <span class="text-amber-700 font-medium">🎯 Focus Input</span>
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var input = document.getElementById('ticket_code');
    var form = document.getElementById('scan-form');
    var messageArea = document.getElementById('message-area');
    var submitTimeout;
    var isProcessing = false;
    
    function keepFocus() {
        input.focus();
    }
    
    function showMessage(message, type) {
        var icon = type === 'success' ? 
            '<svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>' :
            '<svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        
        var bgColor = type === 'success' ? 'bg-green-100 text-green-800 border-green-200' : 'bg-red-100 text-red-800 border-red-200';
        
        messageArea.innerHTML = '<div class="p-4 rounded-xl ' + bgColor + ' border-2 flex items-center shadow-lg">' + icon + '<div><p class="font-semibold">' + (type === 'success' ? 'Success!' : 'Error!') + '</p><p>' + message + '</p></div></div>';
        
        setTimeout(function() {
            messageArea.innerHTML = '';
        }, 3000);
    }
    
    function submitTicket() {
        if (isProcessing) return;
        
        var ticketCode = input.value.trim();
        if (ticketCode.length < 8) return;
        
        isProcessing = true;
        
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.tickets.processScan") }}', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                isProcessing = false;
                
                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            showMessage(response.message, 'success');
                        } else {
                            showMessage(response.message, 'error');
                        }
                    } catch (e) {
                        // If not JSON, check if response contains success indicators
                        var responseText = xhr.responseText.toLowerCase();
                        if (responseText.includes('confirmed') || responseText.includes('success')) {
                            showMessage('Ticket confirmed successfully!', 'success');
                        } else {
                            showMessage('Error processing ticket', 'error');
                        }
                    }
                } else if (xhr.status === 422) {
                    // Validation error
                    try {
                        var errorResponse = JSON.parse(xhr.responseText);
                        var errorMsg = errorResponse.message || 'Validation error';
                        showMessage(errorMsg, 'error');
                    } catch (e) {
                        showMessage('Invalid ticket code format', 'error');
                    }
                } else {
                    showMessage('Network error. Please try again.', 'error');
                }
                
                input.value = '';
                keepFocus();
            }
        };
        
        xhr.send('ticket_code=' + encodeURIComponent(ticketCode) + '&_token={{ csrf_token() }}');
    }
    
    keepFocus();
    
    input.addEventListener('input', function() {
        clearTimeout(submitTimeout);
        var value = this.value.trim();
        
        if (value.length >= 8) {
            submitTimeout = setTimeout(submitTicket, 300);
        }
    });
    
    input.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            clearTimeout(submitTimeout);
            submitTicket();
        }
    });
    
    document.addEventListener('click', function(e) {
        if (e.target !== input) {
            setTimeout(keepFocus, 100);
        }
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        submitTicket();
    });
});
</script>
                <svg class="w-6 h-6 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="font-medium text-amber-800">Passenger Report</span>
            </a>
            <a href="{{ route('admin.buses.index') }}" class="flex items-center justify-center p-4 bg-white rounded-xl shadow-lg border-2 border-yellow-200 hover:border-yellow-400 transition duration-200">
                <svg class="w-6 h-6 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                </svg>
                <span class="font-medium text-yellow-800">All Buses</span>
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('scan-form');
    var submitBtn = document.getElementById('confirm-btn');
    var confirmText = document.getElementById('confirm-text');
    var confirmLoading = document.getElementById('confirm-loading');
    var confirmIcon = document.getElementById('confirm-icon');
    
    if (form) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            confirmIcon.classList.add('hidden');
            confirmText.classList.add('hidden');
            confirmLoading.classList.remove('hidden');
        });
    }
    
    var ticketInput = document.getElementById('ticket_code');
    if (ticketInput) {
        ticketInput.focus();
    }
});
</script>
@endsection