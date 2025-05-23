@extends('admin.layout.app')
@include('admin.users.modals')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Add New User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded" required>
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-4 py-2 border rounded" required>
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block font-medium">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border rounded">
            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- User Type -->
        <div>
            <label for="usertype" class="block font-medium">User Type</label>
            <select name="usertype" id="usertype" class="w-full px-4 py-2 border rounded" required>
                <option value="">Select User Type</option>
                <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="ticketer" {{ old('usertype') == 'ticketer' ? 'selected' : '' }}>Ticketer</option>
                <option value="traffic" {{ old('usertype') == 'traffic' ? 'selected' : '' }}>Traffic</option>
                <option value="hisabshum" {{ old('usertype') == 'hisabshum' ? 'selected' : '' }}>Hisabshum</option>
                <option value="mahberat" {{ old('usertype') == 'mahberat' ? 'selected' : '' }}>Mahberat</option>
                 <option value="cargoMan" {{ old('usertype') == 'cargoMan' ? 'selected' : '' }}>cargoMan</option>
                <option value="balehabt" {{ old('usertype') == 'balehabt' ? 'selected' : '' }}>balehabt</option>
            </select>
            @error('usertype') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Assigned Destinations -->
        <div>
            <label for="assigned_destinations" class="block font-medium">Assign Destinations</label>
            <select name="assigned_destinations[]" id="assigned_destinations" multiple class="w-full px-4 py-2 border rounded">
                @foreach ($destinations as $destination)
                    <option value="{{ $destination->id }}"
                        {{ collect(old('assigned_destinations'))->contains($destination->id) ? 'selected' : '' }}>
                        {{ $destination->start_from }} → {{ $destination->destination_name }}
                    </option>
                @endforeach
            </select>
            <small class="text-gray-500">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
            @error('assigned_destinations') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium">Password</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded" required>
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border rounded" required>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition">Add User</button>
        </div>
    </form>
@endsection
