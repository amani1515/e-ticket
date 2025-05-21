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
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                required>
        </div>

        <!-- Start From -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Start From</label>
            <input 
                type="text" 
                name="start_from" 
                class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500" 
                required>
        </div>

        <!-- Tariff -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tariff</label>
            <input 
                type="number" 
                name="tariff" 
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
@endsection
