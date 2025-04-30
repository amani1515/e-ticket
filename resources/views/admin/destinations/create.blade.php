@extends('admin.layout.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">Add Destination</h2>

<form method="POST" action="{{ route('admin.destinations.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block">Destination Name</label>
        <input type="text" name="destination_name" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block">Start From</label>
        <input type="text" name="start_from" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label class="block">Tarrif</label>
        <input type="number" name="tariff" class="w-full border rounded p-2" required>
    </div>
    <div>
        <label for="tax">Tax</label>
        <input type="number" step="0.01" name="tax" id="tax" class="input" required>
    </div>
    
    <div>
        <label for="service_fee">Service Fee</label>
        <input type="number" step="0.01" name="service_fee" id="service_fee" class="input" required>
    </div>
    
    <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection
