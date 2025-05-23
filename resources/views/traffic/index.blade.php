@extends('traffic.layout.app')

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-2xl shadow-md">
    <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Scan Vehicle</h2>
    
    <form action="{{ route('traffic.schedule.scan') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="schedule_uid" class="block text-sm font-medium text-gray-700 mb-2">Enter Schedule UID</label>
            <input type="text" name="schedule_uid" id="schedule_uid"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Enter Schedule UID">
        </div>
        
        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-300">
            Scan
        </button>
    </form>
</div>
@endsection
