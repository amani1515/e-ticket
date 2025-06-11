@extends('mahberat.layout.app')

@section('content')
<div class="container mx-auto px-4 py-8 animate-fade-in">
    <h2 class="text-2xl font-bold text-blue-700 mb-6 border-b pb-2">🚌 Register New Bus</h2>

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

    <form action="{{ route('mahberat.bus.store') }}" method="POST" enctype="multipart/form-data"
          class="max-w-3xl mx-auto space-y-8 bg-gradient-to-br from-blue-50 via-white to-blue-100 border border-blue-200 rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="flex flex-col gap-3">
                <label for="targa" class="font-semibold text-gray-700">Targa <span class="text-red-500">*</span></label>
                <input type="text" id="targa" name="targa" placeholder="Targa" required class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="driver_name" class="font-semibold text-gray-700">Driver Name <span class="text-red-500">*</span></label>
                <input type="text" id="driver_name" name="driver_name" placeholder="Driver Name" required class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="driver_phone" class="font-semibold text-gray-700">Driver Phone <span class="text-red-500">*</span></label>
                <input type="text" id="driver_phone" name="driver_phone" placeholder="Driver Phone" required class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="redat_name" class="font-semibold text-gray-700">Redat Name <span class="text-red-500">*</span></label>
                <input type="text" id="redat_name" name="redat_name" placeholder="Redat Name" required class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="level" class="font-semibold text-gray-700">Level <span class="text-red-500">*</span></label>
                <select id="level" name="level" required class="input-field">
                   
                    <option value="level1">Level 1</option>
                    <option value="level2">Level 2</option>
                    <option value="level3">Level 3</option>
                </select>
            </div>
            <div class="flex flex-col gap-3">
                <label for="sub-level" class="font-semibold text-gray-700">Sub-Level <span class="text-red-500">*</span></label>
                <select id="sub-level" name="sub-level" required class="input-field">
                    
                    <option value="high">High</option>
                    <option value="mid">Mid</option>
                    <option value="low">Low</option>
                </select>
            </div>
             <div class="flex flex-col gap-3">
                <label for="distance" class="font-semibold text-gray-700">distance <span class="text-red-500">*</span></label>
                <select id="sub-level" name="sub-level" required class="input-field">
                    
                    <option value="long">Long Distance</option>
                    <option value="short">Short Distance</option>
                    </select>
            </div>
            <div class="flex flex-col gap-3">
                <label for="total_seats" class="font-semibold text-gray-700">Total Seats</label>
                <input type="number" id="total_seats" name="total_seats" placeholder="Total Seats" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="cargo_capacity" class="font-semibold text-gray-700">Cargo Capacity (kg) <span class="text-red-500">*</span></label>
                <input type="number" id="cargo_capacity" name="cargo_capacity" placeholder="Cargo Capacity in kg" required class="input-field" step="0.01" min="0">
            </div>
            <div class="flex flex-col gap-3">
                <label for="status" class="font-semibold text-gray-700">Status</label>
                <select id="status" name="status" class="input-field" required>
    <option value="active" {{ old('status', $bus->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
    <option value="maintenance" {{ old('status', $bus->status ?? '') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
    <option value="out_of_service" {{ old('status', $bus->status ?? '') == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
    <option value="bolo_expire" {{ old('status', $bus->status ?? '') == 'bolo_expire' ? 'selected' : '' }}>Bolo Expired</option>
    <option value="accident" {{ old('status', $bus->status ?? '') == 'accident' ? 'selected' : '' }}>Accident</option>
    <option value="gidaj_yeweta" {{ old('status', $bus->status ?? '') == 'gidaj_yeweta' ? 'selected' : '' }}>ግዳጅ የወጣ</option>
    <option value="not_paid" {{ old('status', $bus->status ?? '') == 'not_paid' ? 'selected' : '' }}>Not Paid</option>
    <option value="punished" {{ old('status', $bus->status ?? '') == 'punished' ? 'selected' : '' }}>Punished</option>
    <option value="driver_shortage" {{ old('status', $bus->status ?? '') == 'driver_shortage' ? 'selected' : '' }}>Driver Shortage</option>
</select>
            </div>
            <div class="flex flex-col gap-3">
                <label for="model_year" class="font-semibold text-gray-700">Model Year</label>
                <input type="text" id="model_year" name="model_year" placeholder="Model Year" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="model" class="font-semibold text-gray-700">Model</label>
                <input type="text" id="model" name="model" placeholder="Model" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="bolo_id" class="font-semibold text-gray-700">Bolo ID</label>
                <input type="text" id="bolo_id" name="bolo_id" placeholder="Bolo ID" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="motor_number" class="font-semibold text-gray-700">Motor Number</label>
                <input type="text" id="motor_number" name="motor_number" placeholder="Motor Number" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="color" class="font-semibold text-gray-700">Color</label>
                <input type="text" id="color" name="color" placeholder="Color" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="owner_id" class="font-semibold text-gray-700">Owner</label>
                <select id="owner_id" name="owner_id" class="input-field">
                    
                    @foreach (App\Models\User::where('usertype', 'balehabt')->get() as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-3">
                <label for="file1" class="font-semibold text-gray-700">File 1 /libre/</label> 
                <input type="file" id="file1" name="file1" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="file2" class="font-semibold text-gray-700">File 2/3ኛ ወገን/ </label>
                <input type="file" id="file2" name="file2" class="input-field">
            </div>
            <div class="flex flex-col gap-3">
                <label for="file3" class="font-semibold text-gray-700">File 3</label>
                <input type="file" id="file3" name="file3" class="input-field">
            </div>
        </div>

        <div class="pt-6 flex justify-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition-colors duration-300 text-white font-semibold px-8 py-3 rounded-lg shadow-lg text-lg flex items-center gap-2">
                🚀 Save Bus
            </button>
        </div>
    </form>
</div>

{{-- Optional: Add simple fade animation --}}
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

{{-- Tailwind-friendly input style --}}
<style>
    .input-field {
        @apply w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 bg-white;
    }
</style>
@endsection
