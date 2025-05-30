@extends('admin.layout.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create Mahberat</h1>

<form method="POST" action="{{ route('admin.mahberats.store') }}" class="space-y-4">
    @csrf

    <div>
        <label for="name" class="block">Mahberat Name</label>
        <input type="text" name="name" id="name" required class="w-full px-4 py-2 border rounded">
    </div>

    <div>
        <label for="destinations" class="block">Assign Destinations</label>
        <select name="destinations[]" id="destinations" multiple class="w-full px-4 py-2 border rounded">
            @foreach ($destinations as $destination)
                <option value="{{ $destination->id }}">
                    {{ $destination->start_from }} → {{ $destination->destination_name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
</form>
@endsection
