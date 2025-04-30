@extends('ticketer.layout.app')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-semibold mb-4">Create Ticket</h1>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <form action="{{ route('ticketer.tickets.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="passenger_name" class="block">Passenger Full Name</label>
            <input type="text" name="passenger_name" id="passenger_name" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="age_status" class="block">Age Status</label>
            <select name="age_status" id="age_status" class="w-full p-2 border rounded" required>
                <option value="baby">Baby</option>
                <option value="adult">Adult</option>
                <option value="senior">Senior</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="gender">Gender</label>
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            
        </div>

        <div class="mb-4">
            <label for="destination_id" class="block">Destination</label>
            <select name="destination_id" id="destination_id" class="w-full p-2 border rounded" required>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->destination_name }} ({{ $destination->start_from }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="bus_id" class="block">Bus ID / Targa No</label>
            <input type="text" name="bus_id" id="bus_id" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label for="departure_datetime" class="block">Departure Date and Time</label>
            <input type="datetime-local" name="departure_datetime" id="departure_datetime" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Create Ticket</button>
        </div>
    </form>
</div>
@endsection
