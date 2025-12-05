@extends('admin.layout.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Download All CSV Files</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.export.destinations.csv') }}" class="block bg-blue-600 text-white py-3 px-6 rounded-lg hover:bg-blue-700 transition-colors text-center font-semibold">
                Download Destinations CSV
            </a>
            <a href="{{ route('admin.export.buses.csv') }}" class="block bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition-colors text-center font-semibold">
                Download Buses CSV
            </a>
            <a href="{{ route('admin.export.schedules.csv') }}" class="block bg-purple-600 text-white py-3 px-6 rounded-lg hover:bg-purple-700 transition-colors text-center font-semibold">
                Download Schedules CSV
            </a>
            <a href="{{ route('admin.export.tickets.csv') }}" class="block bg-orange-600 text-white py-3 px-6 rounded-lg hover:bg-orange-700 transition-colors text-center font-semibold">
                Download Tickets CSV
            </a>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('admin.export.index') }}" class="text-gray-600 hover:text-gray-800">← Back to Export</a>
        </div>
    </div>
</div>
@endsection