@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-amber-900 mb-2">✏️ Edit Destination</h1>
                <p class="text-amber-700">Update destination information</p>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200">
                    <h3 class="text-2xl font-bold text-amber-900">Destination Details</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.destinations.update', $destination->id) }}" class="px-8 py-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Destination Name -->
                        <div>
                            <label class="block text-sm font-medium text-amber-700 mb-2">Destination Name</label>
                            <input type="text" name="destination_name" value="{{ old('destination_name', $destination->destination_name) }}" 
                                   class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('destination_name') border-red-500 @enderror">
                            @error('destination_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Start From -->
                        <div>
                            <label class="block text-sm font-medium text-amber-700 mb-2">Start From</label>
                            <input type="text" name="start_from" value="{{ old('start_from', $destination->start_from) }}" 
                                   class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('start_from') border-red-500 @enderror">
                            @error('start_from')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Distance -->
                        <div>
                            <label class="block text-sm font-medium text-amber-700 mb-2">Distance (km)</label>
                            <input type="number" name="distance" value="{{ old('distance', $destination->distance) }}" step="0.01"
                                   class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('distance') border-red-500 @enderror">
                            @error('distance')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Same for All Levels Checkbox -->
                        <div>
                            <div class="flex items-center space-x-3 p-4 bg-amber-50 rounded-lg border border-amber-200">
                                <input type="checkbox" id="same_for_all_levels" name="same_for_all_levels" value="1" 
                                       {{ old('same_for_all_levels', $destination->same_for_all_levels) ? 'checked' : '' }}
                                       class="w-5 h-5 text-amber-600 bg-white border-amber-300 rounded focus:ring-amber-500">
                                <label for="same_for_all_levels" class="text-sm font-medium text-amber-700">
                                    Same tariff for all bus levels (Level 1, 2, 3)
                                </label>
                            </div>
                        </div>

                        <!-- Base Tariff -->
                        <div id="base_tariff_section" class="{{ old('same_for_all_levels', $destination->same_for_all_levels) ? '' : 'hidden' }}">
                            <label class="block text-sm font-medium text-amber-700 mb-2">Base Tariff (All Levels) - ETB</label>
                            <input type="number" name="tariff" value="{{ old('tariff', $destination->tariff) }}" step="0.01"
                                   class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('tariff') border-red-500 @enderror">
                            @error('tariff')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Level-Specific Tariffs -->
                        <div id="level_tariffs_section" class="{{ old('same_for_all_levels', $destination->same_for_all_levels) ? 'hidden' : '' }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Level 1 Tariff -->
                                <div>
                                    <label class="block text-sm font-medium text-amber-700 mb-2">Level 1 Tariff (ETB)</label>
                                    <input type="number" name="level1_tariff" value="{{ old('level1_tariff', $destination->level1_tariff) }}" step="0.01"
                                           class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                </div>

                                <!-- Level 2 Tariff -->
                                <div>
                                    <label class="block text-sm font-medium text-amber-700 mb-2">Level 2 Tariff (ETB)</label>
                                    <input type="number" name="level2_tariff" value="{{ old('level2_tariff', $destination->level2_tariff) }}" step="0.01"
                                           class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                </div>

                                <!-- Level 3 Tariff -->
                                <div>
                                    <label class="block text-sm font-medium text-amber-700 mb-2">Level 3 Tariff (ETB)</label>
                                    <input type="number" name="level3_tariff" value="{{ old('level3_tariff', $destination->level3_tariff) }}" step="0.01"
                                           class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                </div>
                            </div>
                        </div>

                        <!-- Tax -->
                        <div>
                            <label class="block text-sm font-medium text-amber-700 mb-2">Tax (ETB)</label>
                            <input type="number" name="tax" value="{{ old('tax', $destination->tax) }}" step="0.01"
                                   class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('tax') border-red-500 @enderror">
                            @error('tax')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Service Fee -->
                        <div>
                            <label class="block text-sm font-medium text-amber-700 mb-2">Service Fee (ETB)</label>
                            <input type="number" name="service_fee" value="{{ old('service_fee', $destination->service_fee) }}" step="0.01"
                                   class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('service_fee') border-red-500 @enderror">
                            @error('service_fee')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-center space-x-4">
                        <a href="{{ route('admin.destinations.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Destination
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sameForAllCheckbox = document.getElementById('same_for_all_levels');
    const baseTariffSection = document.getElementById('base_tariff_section');
    const levelTariffsSection = document.getElementById('level_tariffs_section');
    
    sameForAllCheckbox.addEventListener('change', function() {
        if (this.checked) {
            baseTariffSection.classList.remove('hidden');
            levelTariffsSection.classList.add('hidden');
        } else {
            baseTariffSection.classList.add('hidden');
            levelTariffsSection.classList.remove('hidden');
        }
    });
});
</script>
@endsection