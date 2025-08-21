{{-- filepath: d:\project\e-ticket\resources\views\mahberat\schedule\create.blade.php --}}
@extends('mahberat.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 via-white to-gray-100 p-8">
    <!-- Page Heading -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">🚌 Schedule a New Bus</h2>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 p-4 mb-6 rounded shadow-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Success Animation -->
    @if(session('success'))
        <div id="success-animation" class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-green-100 border border-green-400 text-green-800 px-8 py-6 rounded-xl shadow-2xl flex flex-col items-center animate-fade-in-up">
                <svg class="w-16 h-16 mb-4 text-green-500 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                </svg>
                <div class="text-2xl font-bold mb-2">Successfully Added!</div>
                <div class="text-lg">{{ session('success') }}</div>
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('success-animation').style.display = 'none';
            }, 2000);
        </script>
        <style>
            .animate-fade-in-up {
                animation: fadeInUp 0.5s, fadeOut 0.5s 1.5s forwards;
            }
            @keyframes fadeInUp {
                from { opacity: 0; transform: translateY(40px);}
                to { opacity: 1; transform: translateY(0);}
            }
            @keyframes fadeOut {
                to { opacity: 0; }
            }
        </style>
    @endif

    <!-- Schedule Form -->
    <form action="{{ route('mahberat.schedule.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-xl shadow" id="schedule-form">
        @csrf

        <!-- Select Bus by Targa -->
        <div class="relative">
            <label for="bus_targa" class="block font-semibold text-gray-700 mb-2">
                <i class="fas fa-bus mr-2 text-blue-600"></i>Enter Bus Targa Number
            </label>
            <div class="flex space-x-2">
                <div class="relative flex-1">
                    <input type="text" id="bus_targa"
                           class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 pl-12 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                           placeholder="Enter bus targa (e.g., 12345)" 
                           autocomplete="off" required>
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                </div>
                <button type="button" onclick="openBusModal()" 
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg shadow-md transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-plus"></i>
                    <span>Quick Register</span>
                </button>
            </div>
            
            <!-- Suggestions Dropdown -->
            <div id="suggestions" class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 hidden max-h-60 overflow-y-auto">
                <!-- Suggestions will be populated here -->
            </div>
            
            <!-- Selected Bus Info -->
            <div id="bus-info" class="mt-3 p-4 bg-blue-50 border border-blue-200 rounded-lg hidden">
                <div class="flex items-center space-x-4">
                    <div class="bg-blue-600 text-white rounded-full p-2">
                        <i class="fas fa-bus"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-800" id="selected-bus-info">Selected Bus</h4>
                        <p class="text-sm text-blue-600" id="selected-bus-details">Bus details</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hidden field for unique_bus_id -->
        <input type="hidden" name="unique_bus_id" id="unique_bus_id" value="">

        <!-- Select Destination -->
        <div>
            <label for="destination_id" class="block font-semibold text-gray-700 mb-1">Select Destination</label>
            <select name="destination_id" id="destination_id" class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                <option value="">-- Select Destination --</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->destination_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <button type="button" onclick="window.history.back()" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md transition-all duration-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i>
                <span>Cancel</span>
            </button>
            <button type="submit" id="submit-btn" disabled
                    class="bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed text-white px-8 py-3 rounded-lg shadow-md transition-all duration-200 flex items-center space-x-2">
                <i class="fas fa-calendar-plus"></i>
                <span>Schedule Bus</span>
            </button>
        </div>
    </form>
</div>

<!-- Bus Registration Modal -->
<div id="busModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="bg-green-600 text-white px-6 py-4 rounded-t-xl">
            <h3 class="text-xl font-bold flex items-center">
                <i class="fas fa-bus mr-2"></i>
                Quick Bus Registration
            </h3>
        </div>
        <form id="busForm" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Targa Number</label>
                <input type="text" name="targa" id="modal_targa" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Total Seats</label>
                <input type="number" name="total_seats" id="modal_seats" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" min="1" max="100" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mahberat</label>
                <select name="mahberat_id" id="modal_mahberat" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                    <option value="">-- Select Mahberat --</option>
                    @foreach(\App\Models\Mahberat::all() as $mahberat)
                        <option value="{{ $mahberat->id }}">{{ $mahberat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Driver Name</label>
                <input type="text" name="driver_name" id="modal_driver" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
            </div>
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeBusModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded transition-colors">
                    Register Bus
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
// Modal functions
function openBusModal() {
    document.getElementById('busModal').classList.remove('hidden');
}

function closeBusModal() {
    document.getElementById('busModal').classList.add('hidden');
    document.getElementById('busForm').reset();
}

// Global fetchSuggestions function
let fetchSuggestions;

// Bus registration
document.getElementById('busForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/mahberat/bus/quick-store', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text().then(text => {
            try {
                const data = JSON.parse(text);
                if (!response.ok) {
                    throw new Error(data.message || 'HTTP ' + response.status);
                }
                return data;
            } catch (e) {
                if (!response.ok) {
                    throw new Error('Server error: ' + text.substring(0, 200));
                }
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            closeBusModal();
            // Auto-fill the targa input with newly registered bus
            document.getElementById('bus_targa').value = data.bus.targa;
            // Trigger search to show the new bus
            if (fetchSuggestions) {
                fetchSuggestions(data.bus.targa);
            }
            alert('Bus registered successfully!');
        } else {
            alert('Error: ' + (data.message || 'Registration failed'));
        }
    })
    .catch(error => {
        console.error('Full error:', error);
        alert('Error: ' + error.message);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const targaInput = document.getElementById('bus_targa');
    const suggestionsDiv = document.getElementById('suggestions');
    const busInfoDiv = document.getElementById('bus-info');
    const busInfoTitle = document.getElementById('selected-bus-info');
    const busInfoDetails = document.getElementById('selected-bus-details');
    const submitBtn = document.getElementById('submit-btn');
    const destinationSelect = document.getElementById('destination_id');
    const uniqueBusIdInput = document.getElementById('unique_bus_id');
    
    let selectedBus = null;
    let debounceTimer = null;
    
    // Enable submit button only when bus is selected and destination is chosen
    function updateSubmitButton() {
        const canSubmit = selectedBus && destinationSelect.value;
        submitBtn.disabled = !canSubmit;
        submitBtn.classList.toggle('opacity-50', !canSubmit);
        
        // Debug log
        console.log('Update submit button:', {
            selectedBus: selectedBus,
            destination: destinationSelect.value,
            canSubmit: canSubmit
        });
    }
    
    // Fetch bus suggestions
    fetchSuggestions = function(query) {
        if (query.length < 1) {
            suggestionsDiv.classList.add('hidden');
            return;
        }
        
        console.log('Fetching suggestions for:', query);
        
        fetch(`/mahberat/buses/search?targa=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                console.log('Search results:', data);
                displaySuggestions(data.buses || []);
            })
            .catch(error => {
                console.error('Error fetching suggestions:', error);
                suggestionsDiv.classList.add('hidden');
            });
    }
    
    // Display suggestions
    function displaySuggestions(buses) {
        if (buses.length === 0) {
            suggestionsDiv.innerHTML = `
                <div class="p-4 text-center text-gray-500">
                    <i class="fas fa-search mb-2"></i>
                    <p>No buses found with this targa</p>
                </div>
            `;
            suggestionsDiv.classList.remove('hidden');
            return;
        }
        
        const suggestionsHTML = buses.map(bus => `
            <div class="suggestion-item p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0" 
                 data-bus='${JSON.stringify(bus)}'>
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-100 text-blue-600 rounded-full p-2 w-10 h-10 flex items-center justify-center">
                        <i class="fas fa-bus text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold text-gray-800">Targa: ${bus.targa}</div>
                        <div class="text-sm text-gray-600">
                            <span class="inline-flex items-center">
                                <i class="fas fa-user mr-1"></i>${bus.driver_name}
                            </span>
                            <span class="ml-3 inline-flex items-center">
                                <i class="fas fa-chair mr-1"></i>${bus.total_seats} seats
                            </span>
                            <span class="ml-3 inline-flex items-center">
                                <i class="fas fa-circle mr-1 ${bus.status === 'active' ? 'text-green-500' : 'text-red-500'}"></i>
                                ${bus.status}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
        
        suggestionsDiv.innerHTML = suggestionsHTML;
        suggestionsDiv.classList.remove('hidden');
        
        // Add click listeners to suggestions
        document.querySelectorAll('.suggestion-item').forEach(item => {
            item.addEventListener('click', function() {
                const bus = JSON.parse(this.dataset.bus);
                selectBus(bus);
            });
        });
    }
    
    // Select a bus
    function selectBus(bus) {
        selectedBus = bus;
        targaInput.value = bus.targa;
        
        // Set the hidden input value immediately
        uniqueBusIdInput.value = bus.unique_bus_id;
        
        console.log('Bus selected:', bus);
        console.log('Hidden input value set to:', bus.unique_bus_id);
        
        // Show bus info
        busInfoTitle.textContent = `Bus ${bus.targa} - ${bus.driver_name}`;
        busInfoDetails.innerHTML = `
            <span class="inline-flex items-center mr-4">
                <i class="fas fa-chair mr-1"></i>${bus.total_seats} seats
            </span>
            <span class="inline-flex items-center mr-4">
                <i class="fas fa-palette mr-1"></i>${bus.color}
            </span>
            <span class="inline-flex items-center">
                <i class="fas fa-circle mr-1 ${bus.status === 'active' ? 'text-green-500' : 'text-red-500'}"></i>
                ${bus.status}
            </span>
        `;
        
        busInfoDiv.classList.remove('hidden');
        suggestionsDiv.classList.add('hidden');
        
        updateSubmitButton();
    }
    
    // Input event listener with debounce
    targaInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Reset selection if input changes
        if (!selectedBus || selectedBus.targa !== query) {
            selectedBus = null;
            uniqueBusIdInput.value = '';
            busInfoDiv.classList.add('hidden');
            updateSubmitButton();
        }
        
        // Debounce the search
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchSuggestions(query);
        }, 300);
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!targaInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.classList.add('hidden');
        }
    });
    
    // Destination change listener
    destinationSelect.addEventListener('change', updateSubmitButton);
    
    // Form submission
    document.getElementById('schedule-form').addEventListener('submit', function(e) {
        console.log('Form submitting...');
        console.log('Selected bus:', selectedBus);
        console.log('Hidden input value:', uniqueBusIdInput.value);
        
        if (!selectedBus || !uniqueBusIdInput.value) {
            e.preventDefault();
            alert('Please select a valid bus from the suggestions.');
            return false;
        }
        
        console.log('Form submission allowed');
        return true;
    });
    
    // Initial state
    updateSubmitButton();
});
</script>

<style>
.suggestion-item:hover {
    background-color: #eff6ff;
    transform: translateX(2px);
    transition: all 0.2s ease;
}

#bus_targa:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: .5;
    }
}
</style>

@endsection