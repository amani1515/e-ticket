@extends('admin.layout.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create Mahberat</h1>

<form method="POST" action="{{ route('admin.mahberats.store') }}" class="space-y-4">
    @csrf

   <div>
    <label for="name" class="block">Mahberat Name</label>
    <input 
        type="text" 
        name="name" 
        id="mahberat_name" 
        maxlength="100" 
        required 
        class="w-full px-4 py-2 border rounded"
        placeholder="Enter Mahberat Name">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mahberatInput = document.getElementById('mahberat_name');

        mahberatInput.addEventListener('input', function () {
            // Allow letters, numbers, Amharic (አ-ፐ), spaces, dashes, commas, and periods
            this.value = this.value.replace(/[^A-Za-zአ-ፐ0-9\s\-.,]/g, '').slice(0, 100);
        });
    });
</script>
@endsection
