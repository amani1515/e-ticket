{{-- filepath: resources/views/admin/destinations/create.blade.php --}}
@extends('admin.layout.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded">
    <h2 class="text-2xl font-semibold text-yellow-600 mb-6">Add Destination</h2>

    <form method="POST" action="{{ route('admin.destinations.store') }}" class="space-y-5">
        @csrf

        <!-- Destination Name -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Destination Name</label>
            <input 
                type="text" 
                name="destination_name" 
                id="destination_name"
                maxlength="100"
                onpaste="return false"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500"
                required>
        </div>

        <!-- Start From -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Start From</label>
            <input 
                type="text" 
                name="start_from" 
                id="start_from"
                maxlength="100"
                onpaste="return false"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500"
                required>
        </div>

        <!-- Distance -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Distance (km)</label>
            <input 
                type="number" 
                step="0.01"
                name="distance" 
                id="distance"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                required>
        </div>

        <!-- Tariff -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tariff</label>
            <input 
                type="number" 
                step="0.01"
                name="tariff" 
                id="tariff"
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                required>
        </div>

        <!-- Tax -->
        <div>
            <label for="tax" class="block text-sm font-medium text-gray-700 mb-1">Tax (%)</label>
            <input 
                type="number" 
                step="0.01" 
                name="tax" 
                id="tax" 
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                required>
        </div>

        <!-- Service Fee -->
        <div>
            <label for="service_fee" class="block text-sm font-medium text-gray-700 mb-1">Service Fee</label>
            <input 
                type="number" 
                step="0.01" 
                name="service_fee" 
                id="service_fee" 
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                required>
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button 
                type="submit" 
                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 rounded transition duration-200">
                Save Destination
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Text input restrictions
        const safeInput = (element) => {
            if (!element) return;
            element.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-zአ-ፐ0-9\s\-.,]/g, '').slice(0, 100);
            });
        };
        safeInput(document.getElementById('destination_name'));
        safeInput(document.getElementById('start_from'));

        // Numeric input restrictions with alert
        const numericFields = [
            'distance',
            'tariff',
            'tax',
            'service_fee'
        ];

        // Create alert box
        let alertBox = document.createElement('div');
        alertBox.style.display = 'none';
        alertBox.style.color = '#fff';
        alertBox.style.background = '#e63946';
        alertBox.style.padding = '8px';
        alertBox.style.margin = '10px 0';
        alertBox.style.borderRadius = '4px';
        alertBox.textContent = "Negative numbers are not allowed!";
        // Insert alert box at the top of the form
        const form = document.querySelector('form');
        if (form) form.prepend(alertBox);

        numericFields.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', function () {
                    let num = parseFloat(this.value);
                    if (isNaN(num)) num = 0;
                    if (num < 0) {
                        alertBox.style.display = 'block';
                        this.value = 0;
                    } else {
                        alertBox.style.display = 'none';
                    }
                    if (num > 10000) {
                        this.value = 10000;
                    }
                });
            }
        });
    });
</script>
@endsection