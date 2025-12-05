@extends('admin.layout.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Export Data</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Tickets Export -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a1 1 0 001 1h1m0 0h4l2 2h4a1 1 0 001-1V9a1 1 0 00-1-1h-4l-2-2H5z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-blue-800">Tickets</h3>
                </div>
                <p class="text-blue-600 mb-4">Export all ticket data</p>
                <button class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition-colors">
                    Export Tickets
                </button>
            </div>

            <!-- Buses Export -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-green-800">Buses</h3>
                </div>
                <p class="text-green-600 mb-4">Export bus information</p>
                <a href="{{ route('admin.export.buses.csv') }}" class="block w-full bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition-colors text-center">
                    Export CSV
                </a>
            </div>

            <!-- Destinations Export -->
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-purple-800">Destinations</h3>
                </div>
                <p class="text-purple-600 mb-4">Export destinations CSV</p>
                <a href="{{ route('admin.export.destinations.csv') }}" class="block w-full bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700 transition-colors text-center">
                    Export CSV
                </a>
            </div>
        </div>
    </div>
</div>
@endsection