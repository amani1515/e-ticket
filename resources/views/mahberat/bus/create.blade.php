@extends('mahberat.layout.app')

@section('content')
    <div class="ml-64 container mx-auto px-4 py-6"> {{-- Push content to the right of the sidebar --}}
        <h2 class="text-xl font-semibold mb-4">Register New Bus</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <form action="{{ route('mahberat.bus.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="targa" placeholder="Targa" required class="input">
                <input type="text" name="driver_name" placeholder="Driver Name" required class="input">
                <input type="text" name="driver_phone" placeholder="Driver Phone" required class="input">
                <input type="text" name="redat_name" placeholder="Redat Name" required class="input">

                <select name="level" required class="input">
                    <option value="">Select Level</option>
                    <option value="level1">Level 1</option>
                    <option value="level2">Level 2</option>
                    <option value="level3">Level 3</option>
                </select>

                <input type="number" name="total_seats" placeholder="Total Seats" class="input">

                <select name="status" class="input">
                    <option value="active" selected>Active</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="out_of_service">Out of Service</option>
                </select>

                <input type="text" name="model_year" placeholder="Model Year" class="input">
                <input type="text" name="model" placeholder="Model" class="input">
                <input type="text" name="bolo_id" placeholder="Bolo ID" class="input">
                <input type="text" name="motor_number" placeholder="Motor Number" class="input">
                <input type="text" name="color" placeholder="Color" class="input">

                <select name="owner_id" class="input">
                    <option value="">Select Owner</option>
                    @foreach (App\Models\User::where('usertype', 'owner')->get() as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                    @endforeach
                </select>

                <div>
                    <label>File 1</label>
                    <input type="file" name="file1" class="input">
                </div>
                <div>
                    <label>File 2</label>
                    <input type="file" name="file2" class="input">
                </div>
                <div>
                    <label>File 3</label>
                    <input type="file" name="file3" class="input">
                </div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save Bus</button>
        </form>
    </div>
@endsection
