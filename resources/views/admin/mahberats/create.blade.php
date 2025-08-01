@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">🚌 Create New Mahberat</h1>
            <p class="text-amber-700">Add a new mahberat (bus station) to manage destinations</p>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Mahberat Information
                    </h2>
                    <p class="text-amber-100 mt-2">Fill in the details for the new mahberat station</p>
                </div>

                <!-- Form Section -->
                <div class="px-8 py-8">
                    <form method="POST" action="{{ route('admin.mahberats.store') }}" class="space-y-8">
                        @csrf

                        <!-- Mahberat Name -->
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-3 uppercase tracking-wide">Mahberat Name</label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="mahberat_name" 
                                    maxlength="100" 
                                    required 
                                    class="w-full px-4 py-4 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50 text-lg"
                                    placeholder="Enter mahberat station name">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Destinations Assignment -->
                        <div>
                            <label class="block text-sm font-semibold text-amber-800 mb-3 uppercase tracking-wide">Assign Destinations</label>
                            <div class="relative">
                                <select name="destinations[]" id="destinations" multiple 
                                        class="w-full px-4 py-4 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50 min-h-[200px]">
                                    @foreach ($destinations as $destination)
                                        <option value="{{ $destination->id }}" class="py-2 px-3 hover:bg-amber-100">
                                            {{ $destination->start_from }} → {{ $destination->destination_name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute top-4 right-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-amber-600 mt-2 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Hold Ctrl (Cmd on Mac) to select multiple destinations
                            </p>
                        </div>

                        <!-- Selected Destinations Preview -->
                        <div id="selected-preview" class="hidden">
                            <div class="bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border-2 border-amber-200 p-6">
                                <h3 class="text-lg font-bold text-amber-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Selected Destinations
                                </h3>
                                <div id="selected-list" class="grid grid-cols-1 md:grid-cols-2 gap-3"></div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6">
                            <button 
                                type="submit" 
                                class="flex-1 bg-gradient-to-r from-amber-500 to-yellow-500 hover:from-amber-600 hover:to-yellow-600 text-white font-bold py-4 px-6 rounded-xl transition duration-200 transform hover:scale-105 shadow-lg flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Create Mahberat
                            </button>
                            <a href="{{ route('admin.mahberats.index') }}" 
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
        const mahberatInput = document.getElementById('mahberat_name');
        const destinationsSelect = document.getElementById('destinations');
        const selectedPreview = document.getElementById('selected-preview');
        const selectedList = document.getElementById('selected-list');

        // Input validation for mahberat name
        mahberatInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-zአ-ፐ0-9\s\-.,]/g, '').slice(0, 100);
        });

        // Update selected destinations preview
        const updateSelectedPreview = () => {
            const selectedOptions = Array.from(destinationsSelect.selectedOptions);
            
            if (selectedOptions.length > 0) {
                selectedPreview.classList.remove('hidden');
                selectedList.innerHTML = selectedOptions.map(option => `
                    <div class="bg-white rounded-lg p-3 border border-amber-200 flex items-center">
                        <svg class="w-4 h-4 text-amber-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-amber-900">${option.textContent}</span>
                    </div>
                `).join('');
            } else {
                selectedPreview.classList.add('hidden');
            }
        };

        // Listen for changes in destination selection
        destinationsSelect.addEventListener('change', updateSelectedPreview);

        // Enhanced multi-select styling
        destinationsSelect.addEventListener('focus', function() {
            this.classList.add('ring-2', 'ring-amber-500');
        });

        destinationsSelect.addEventListener('blur', function() {
            this.classList.remove('ring-2', 'ring-amber-500');
        });
    });
</script>
@endsection
