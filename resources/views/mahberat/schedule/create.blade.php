@extends('mahberat.layout.app')

@section('content')
<div class="container max-w-xl mx-auto">
    <h2 class="text-2xl font-semibold mb-4">Schedule a New Bus</h2>

    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mahberat.schedule.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="bus_id" class="block font-medium">Select Bus</label>
            <select name="bus_id" id="bus_id" class="w-full border p-2 rounded">
                <option value="">-- Choose Bus --</option>
                @foreach($buses as $bus)
                    <option value="{{ $bus->id }}">{{ $bus->targa }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="destination_id" class="block font-medium">Select Destination</label>
            <select name="destination_id" class="form-control" required>
                <option value="">-- Select Destination --</option>
                @foreach($destinations as $destination)
                    <option value="{{ $destination->id }}">{{ $destination->destination_name }}</option>
                @endforeach
            </select>
            
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Schedule Bus</button>
    </form>
</div>
@endsection
