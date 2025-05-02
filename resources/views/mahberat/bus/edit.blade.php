@extends('mahberat.layout.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Edit Bus</h2>

    @if(session('success'))
    <div class="ml-64 px-4 mt-4"> {{-- Adjust ml-64 based on your sidebar width --}}
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif



    <form action="{{ route('mahberat.bus.update', $bus->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label>Targa</label>
                <input type="text" name="targa" value="{{ old('targa', $bus->targa) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Driver Name</label>
                <input type="text" name="driver_name" value="{{ old('driver_name', $bus->driver_name) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Driver Phone</label>
                <input type="text" name="driver_phone" value="{{ old('driver_phone', $bus->driver_phone) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Redat Name</label>
                <input type="text" name="redat_name" value="{{ old('redat_name', $bus->redat_name) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Level</label>
                <select name="level" class="w-full border p-2" required>
                    <option value="level1" {{ $bus->level == 'level1' ? 'selected' : '' }}>Level 1</option>
                    <option value="level2" {{ $bus->level == 'level2' ? 'selected' : '' }}>Level 2</option>
                    <option value="level3" {{ $bus->level == 'level3' ? 'selected' : '' }}>Level 3</option>
                </select>
            </div>

            <div>
                <label>Total Seats</label>
                <input type="number" name="total_seats" value="{{ old('total_seats', $bus->total_seats) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Status</label>
                <select name="status" class="w-full border p-2" required>
                    <option value="active" {{ $bus->status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="maintenance" {{ $bus->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="out_of_service" {{ $bus->status == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                </select>
            </div>

            <div>
                <label>Model Year</label>
                <input type="text" name="model_year" value="{{ old('model_year', $bus->model_year) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Model</label>
                <input type="text" name="model" value="{{ old('model', $bus->model) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Bolo ID</label>
                <input type="text" name="bolo_id" value="{{ old('bolo_id', $bus->bolo_id) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Motor Number</label>
                <input type="text" name="motor_number" value="{{ old('motor_number', $bus->motor_number) }}" class="w-full border p-2" required>
            </div>

            <div>
                <label>Color</label>
                <input type="text" name="color" value="{{ old('color', $bus->color) }}" class="w-full border p-2" required>
            </div>
        </div>

        <div class="mt-4">
            <label>Upload File 1</label>
            <input type="file" name="file1" class="w-full border p-2">
        </div>
        <div class="mt-2">
            <label>Upload File 2</label>
            <input type="file" name="file2" class="w-full border p-2">
        </div>
        <div class="mt-2">
            <label>Upload File 3</label>
            <input type="file" name="file3" class="w-full border p-2">
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update Bus
            </button>
        </div>
    </form>
</div>
@endsection
