{{--
    User Creation Form (Admin Panel)
    --------------------------------
    This Blade file provides a form for administrators to add new users to the system.
    Features:
    - Collects user details: name, email, phone, password, and user type
    - Allows assignment of destinations (multi-select)
    - Optionally assigns user to a Mahberat (association)
    - Includes validation error display for each field
    - Uses CSRF protection and POST method
    - Data for destinations and mahberats is injected from the controller
    - Styled with Tailwind CSS classes
--}}
@extends('admin.layout.app')
@include('admin.users.modals')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Add New User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Name: User's full name -->
        <div>
            <label for="name" class="block font-medium">Full Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                class="w-full px-4 py-2 border rounded" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email: User's email address -->
        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                class="w-full px-4 py-2 border rounded" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Phone: User's phone number -->
        <div>
            <label for="phone" class="block font-medium">Phone</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                class="w-full px-4 py-2 border rounded">
            @error('phone')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- User Type: Select the user's role in the system -->
        <div>
            <label for="usertype" class="block font-medium">User Type</label>
            <select name="usertype" id="usertype" class="w-full px-4 py-2 border rounded" required>
                <option value="">Select User Type</option>
                <option value="admin" {{ old('usertype') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="ticketer" {{ old('usertype') == 'ticketer' ? 'selected' : '' }}>Ticket agent</option>
                <option value="traffic" {{ old('usertype') == 'traffic' ? 'selected' : '' }}>Traffic</option>
                <option value="hisabshum" {{ old('usertype') == 'hisabshum' ? 'selected' : '' }}>Hisabshum</option>
                <option value="mahberat" {{ old('usertype') == 'mahberat' ? 'selected' : '' }}>Mahberat</option>
                <option value="headoffice" {{ old('usertype') == 'headoffice' ? 'selected' : '' }}>headOffice</option>
                <option value="cargoMan" {{ old('usertype') == 'cargoMan' ? 'selected' : '' }}>cargoMan</option>
                <option value="balehabt" {{ old('usertype') == 'balehabt' ? 'selected' : '' }}>balehabt</option>
            </select>
            @error('usertype')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Assigned Destinations: Multi-select for destinations -->
        <div>
            <label for="assigned_destinations" class="block font-medium">Assign Destinations</label>
            <select name="assigned_destinations[]" id="assigned_destinations" multiple
                class="w-full px-4 py-2 border rounded">
                @foreach ($destinations as $destination)
                    <option value="{{ $destination->id }}"
                        {{ collect(old('assigned_destinations'))->contains($destination->id) ? 'selected' : '' }}>
                        {{ $destination->start_from }} → {{ $destination->destination_name }}
                    </option>
                @endforeach
            </select>
            <small class="text-gray-500">Hold Ctrl (Windows) or Cmd (Mac) to select multiple.</small>
            @error('assigned_destinations')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Mahberat Select: Optionally assign user to a Mahberat (association) -->
        <div>
            <label for="mahberat_id" class="block font-medium">Assign to Mahberat</label>
            <select name="mahberat_id" id="mahberat_id" class="w-full px-4 py-2 border rounded">
                <option value="">None</option>
                @foreach ($mahberats as $m)
                    <option value="{{ $m->id }}" {{ old('mahberat_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Password: Set the user's password -->
        <div>
            <label for="password" class="block font-medium">Password</label>
            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded" required>
            @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password: Repeat password for confirmation -->
        <div>
            <label for="password_confirmation" class="block font-medium">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="w-full px-4 py-2 border rounded" required>
        </div>

        <!-- Submit Button: Add the new user -->
        <div>
            <button type="submit"
                class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition">Add User</button>
        </div>
    </form>
@endsection
