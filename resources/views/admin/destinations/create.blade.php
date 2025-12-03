@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">🗺️ Create New Destination</h1>
            <p class="text-amber-700">Add a new destination route to the system</p>
        </div>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-amber-500 to-yellow-500 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Destination Information
                    </h2>
                    <p class="text-amber-100 mt-2">Fill in the details for the new destination route</p>
                </div>

                <!-- Form Section -->
                <div class="px-8 py-8">
                    <form method="POST" action="{{ route('admin.destinations.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Destination Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Destination Name</label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="destination_name" 
                                        id="destination_name"
                                        lang="am"
                                        dir="ltr"
                                        autocomplete="off"
                                        spellcheck="false"
                                        inputmode="text"
                                        class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                        placeholder="Enter destination name"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Start From -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Start From</label>
                                <div class="relative">
                                    <input 
                                        type="text" 
                                        name="start_from" 
                                        id="start_from"
                                        lang="am"
                                        dir="ltr"
                                        autocomplete="off"
                                        spellcheck="false"
                                        inputmode="text"
                                        class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                        placeholder="Enter starting point"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v8a1 1 0 01-1 1H5a1 1 0 01-1-1V8a1 1 0 011-1h3z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Distance -->
                            <div>
                                <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Distance (km)</label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        step="0.01"
                                        name="distance" 
                                        id="distance"
                                        class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                        placeholder="0.00"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-amber-600 text-sm font-medium">km</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Same for All Levels Checkbox -->
                            <div class="md:col-span-2">
                                <div class="flex items-center space-x-3 p-4 bg-amber-50 rounded-xl border-2 border-amber-200">
                                    <input type="checkbox" id="same_for_all_levels" name="same_for_all_levels" value="1" 
                                           class="w-5 h-5 text-amber-600 bg-white border-amber-300 rounded focus:ring-amber-500" checked>
                                    <label for="same_for_all_levels" class="text-sm font-semibold text-amber-800">
                                        Same tariff for all bus levels (Level 1, 2, 3)
                                    </label>
                                </div>
                            </div>

                            <!-- Base Tariff -->
                            <div id="base_tariff_section" class="md:col-span-2">
                                <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Base Tariff (All Levels)</label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        step="0.01"
                                        name="tariff" 
                                        id="tariff"
                                        class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                        placeholder="0.00"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-amber-600 text-sm font-medium">ETB</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Level-Specific Tariffs -->
                            <div id="level_tariffs_section" class="md:col-span-2 hidden">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Level 1 Tariff -->
                                    <div>
                                        <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Level 1 Tariff</label>
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                step="0.01"
                                                name="level1_tariff" 
                                                id="level1_tariff"
                                                class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                                placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-amber-600 text-sm font-medium">ETB</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Level 2 Tariff -->
                                    <div>
                                        <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Level 2 Tariff</label>
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                step="0.01"
                                                name="level2_tariff" 
                                                id="level2_tariff"
                                                class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                                placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-amber-600 text-sm font-medium">ETB</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Level 3 Tariff -->
                                    <div>
                                        <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Level 3 Tariff</label>
                                        <div class="relative">
                                            <input 
                                                type="number" 
                                                step="0.01"
                                                name="level3_tariff" 
                                                id="level3_tariff"
                                                class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                                placeholder="0.00">
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <span class="text-amber-600 text-sm font-medium">ETB</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tax -->
                            <div>
                                <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Tax</label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        name="tax" 
                                        id="tax" 
                                        class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                        placeholder="0.00"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-amber-600 text-sm font-medium">ETB</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Service Fee -->
                            <div>
                                <label class="block text-sm font-semibold text-amber-800 mb-2 uppercase tracking-wide">Service Fee</label>
                                <div class="relative">
                                    <input 
                                        type="number" 
                                        step="0.01" 
                                        name="service_fee" 
                                        id="service_fee" 
                                        class="w-full px-4 py-3 border-2 border-amber-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition duration-200 bg-amber-50"
                                        placeholder="0.00"
                                        required>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-amber-600 text-sm font-medium">ETB</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cost Preview -->
                        <div class="mt-8 p-6 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-xl border-2 border-amber-200">
                            <h3 class="text-lg font-bold text-amber-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                </svg>
                                Total Cost Preview
                            </h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                                <div class="bg-white rounded-lg p-3 border border-amber-200">
                                    <div class="text-sm text-amber-600 font-medium">Base Tariff</div>
                                    <div class="text-lg font-bold text-amber-900" id="preview-tariff">0.00 ETB</div>
                                </div>
                                <div class="bg-white rounded-lg p-3 border border-amber-200">
                                    <div class="text-sm text-amber-600 font-medium">Tax</div>
                                    <div class="text-lg font-bold text-amber-900" id="preview-tax">0.00 ETB</div>
                                </div>
                                <div class="bg-white rounded-lg p-3 border border-amber-200">
                                    <div class="text-sm text-amber-600 font-medium">Service Fee</div>
                                    <div class="text-lg font-bold text-amber-900" id="preview-service">0.00 ETB</div>
                                </div>
                                <div class="bg-amber-500 text-white rounded-lg p-3">
                                    <div class="text-sm font-medium opacity-90">Total Cost</div>
                                    <div class="text-lg font-bold" id="preview-total">0.00 ETB</div>
                                </div>
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
                                Create Destination
                            </button>
                            <a href="{{ route('admin.destinations.index') }}" 
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
    document.addEventListener('DOMContentLoaded', () => {
        // Text input character limit only
        const limitInput = (element) => {
            if (!element) return;
            element.addEventListener('input', function () {
                if (this.value.length > 100) {
                    this.value = this.value.slice(0, 100);
                }
            });
        };
        limitInput(document.getElementById('destination_name'));
        limitInput(document.getElementById('start_from'));

        // Toggle level tariffs visibility
        const sameForAllCheckbox = document.getElementById('same_for_all_levels');
        const baseTariffSection = document.getElementById('base_tariff_section');
        const levelTariffsSection = document.getElementById('level_tariffs_section');
        
        sameForAllCheckbox.addEventListener('change', function() {
            if (this.checked) {
                baseTariffSection.classList.remove('hidden');
                levelTariffsSection.classList.add('hidden');
                document.getElementById('tariff').required = true;
                document.getElementById('level1_tariff').required = false;
                document.getElementById('level2_tariff').required = false;
                document.getElementById('level3_tariff').required = false;
            } else {
                baseTariffSection.classList.add('hidden');
                levelTariffsSection.classList.remove('hidden');
                document.getElementById('tariff').required = false;
                document.getElementById('level1_tariff').required = true;
                document.getElementById('level2_tariff').required = true;
                document.getElementById('level3_tariff').required = true;
            }
        });

        // Numeric input restrictions with alert
        const numericFields = ['distance', 'tariff', 'tax', 'service_fee', 'level1_tariff', 'level2_tariff', 'level3_tariff'];

        // Create alert box
        let alertBox = document.createElement('div');
        alertBox.className = 'hidden bg-red-500 text-white p-3 rounded-lg mb-4 border border-red-600';
        alertBox.textContent = "Negative numbers are not allowed!";
        const form = document.querySelector('form');
        if (form) form.prepend(alertBox);

        // Cost preview update function
        const updatePreview = () => {
            const tariff = parseFloat(document.getElementById('tariff').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;
            const serviceFee = parseFloat(document.getElementById('service_fee').value) || 0;
            const total = tariff + tax + serviceFee;

            document.getElementById('preview-tariff').textContent = tariff.toFixed(2) + ' ETB';
            document.getElementById('preview-tax').textContent = tax.toFixed(2) + ' ETB';
            document.getElementById('preview-service').textContent = serviceFee.toFixed(2) + ' ETB';
            document.getElementById('preview-total').textContent = total.toFixed(2) + ' ETB';
        };

        numericFields.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', function () {
                    let num = parseFloat(this.value);
                    if (isNaN(num)) num = 0;
                    if (num < 0) {
                        alertBox.classList.remove('hidden');
                        this.value = 0;
                        setTimeout(() => alertBox.classList.add('hidden'), 3000);
                    } else {
                        alertBox.classList.add('hidden');
                    }
                    if (num > 10000) {
                        this.value = 10000;
                    }
                    updatePreview();
                });
            }
        });

        // Initial preview update
        updatePreview();
    });
</script>
@endsection