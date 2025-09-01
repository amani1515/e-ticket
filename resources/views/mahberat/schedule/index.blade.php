@extends('mahberat.layout.app')

@section('content')


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

<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-yellow-700 border-b pb-1">🗓️ Scheduled Buses</h2>
        <a href="{{ route('mahberat.schedule.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-150">
            + Schedule New Bus
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto transition duration-300 hover:shadow-md">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Targa</th>
                    <th class="px-6 py-3 text-left">Destination</th>
                    <th class="px-6 py-3 text-left">Scheduled At</th>
                    <th class="px-6 py-3 text-left">Scheduled By</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($schedules as $index => $schedule)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $schedule->bus->targa }}</td>
                        <td class="px-6 py-4">{{ $schedule->destination->destination_name }}</td>
                        <td class="px-6 py-4">{{ $schedule->scheduled_at }}</td>
                        <td class="px-6 py-4">{{ $schedule->scheduledBy->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $schedule->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($schedule->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($schedule->status !== 'departed')
                                <div class="flex space-x-2">
                                    <button onclick="openEditModal({{ $schedule->id }}, '{{ $schedule->bus->targa }}', '{{ $schedule->bus->unique_bus_id }}')" class="text-blue-600 hover:text-blue-800 px-2 py-1 rounded transition" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </button>
                                    <form action="{{ route('mahberat.schedule.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this schedule?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 px-2 py-1 rounded transition" title="Remove">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm">No actions</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                            No scheduled buses yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Schedule Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-2xl w-full max-w-md mx-4">
        <div class="bg-blue-600 text-white px-6 py-4 rounded-t-xl">
            <h3 class="text-xl font-bold flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Schedule Bus
            </h3>
        </div>
        <form id="editForm" class="p-6 space-y-4">
            @csrf
            @method('PUT')
            <div class="relative">
                <label class="block text-sm font-semibold text-gray-700 mb-1">New Bus Targa</label>
                <input type="text" id="edit_targa" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter new bus targa" required>
                
                <!-- Suggestions Dropdown -->
                <div id="edit_suggestions" class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 hidden max-h-60 overflow-y-auto">
                    <!-- Suggestions will be populated here -->
                </div>
            </div>
            
            <!-- Hidden fields -->
            <input type="hidden" id="edit_schedule_id" value="">
            <input type="hidden" id="edit_unique_bus_id" value="">
            
            <div class="flex space-x-3 pt-4">
                <button type="button" onclick="closeEditModal()" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded transition-colors">
                    Cancel
                </button>
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition-colors">
                    Update Bus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal functions
function openEditModal(scheduleId, currentTarga, currentUniqueBusId) {
    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('edit_schedule_id').value = scheduleId;
    document.getElementById('edit_targa').value = currentTarga;
    document.getElementById('edit_unique_bus_id').value = currentUniqueBusId;
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editForm').reset();
    document.getElementById('edit_suggestions').classList.add('hidden');
}

// Bus suggestions for edit
function fetchEditSuggestions(query) {
    if (query.length < 1) {
        document.getElementById('edit_suggestions').classList.add('hidden');
        return;
    }
    
    fetch(`/mahberat/buses/search?targa=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            displayEditSuggestions(data.buses || []);
        })
        .catch(error => {
            console.error('Error fetching suggestions:', error);
        });
}

function displayEditSuggestions(buses) {
    const suggestionsDiv = document.getElementById('edit_suggestions');
    
    if (buses.length === 0) {
        suggestionsDiv.innerHTML = '<div class="p-4 text-center text-gray-500">No buses found</div>';
        suggestionsDiv.classList.remove('hidden');
        return;
    }
    
    const suggestionsHTML = buses.map(bus => `
        <div class="edit-suggestion-item p-3 hover:bg-blue-50 cursor-pointer border-b border-gray-100 last:border-b-0" 
             data-targa="${bus.targa}" data-unique-id="${bus.unique_bus_id}">
            <div class="font-semibold text-gray-800">Targa: ${bus.targa}</div>
            <div class="text-sm text-gray-600">${bus.driver_name} - ${bus.total_seats} seats</div>
        </div>
    `).join('');
    
    suggestionsDiv.innerHTML = suggestionsHTML;
    suggestionsDiv.classList.remove('hidden');
    
    // Add click listeners
    document.querySelectorAll('.edit-suggestion-item').forEach(item => {
        item.addEventListener('click', function() {
            document.getElementById('edit_targa').value = this.dataset.targa;
            document.getElementById('edit_unique_bus_id').value = this.dataset.uniqueId;
            suggestionsDiv.classList.add('hidden');
        });
    });
}

// Event listeners
document.getElementById('edit_targa').addEventListener('input', function() {
    fetchEditSuggestions(this.value);
});

// Form submission
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const scheduleId = document.getElementById('edit_schedule_id').value;
    const uniqueBusId = document.getElementById('edit_unique_bus_id').value;
    
    if (!uniqueBusId) {
        alert('Please select a valid bus from suggestions');
        return;
    }
    
    const formData = new FormData();
    formData.append('unique_bus_id', uniqueBusId);
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('_method', 'PUT');
    
    fetch(`/mahberat/schedule/${scheduleId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.ok) {
            location.reload();
        } else {
            alert('Error updating schedule');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Network error occurred');
    });
});
</script>

{{-- Fade Animation --}}
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
