{{--
    User Edit Form (Admin Panel)
    ---------------------------
    This Blade file provides a form for administrators to edit an existing user's information.
    Features:
    - Allows editing of user details: name, email, phone, user type, birth date, and national ID
    - Supports uploading a new profile picture and PDF file
    - Uses CSRF protection and PUT method for update
    - Pre-fills form fields with the current user's data
    - Styled with Tailwind CSS classes
    - Data for the user is injected from the controller
--}}
@extends('admin.layout.app')

@section('content')
    <div class="p-4">
        <h2 class="text-xl font-bold mb-4">Edit User</h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4 bg-white p-4 rounded shadow">
            @csrf
            @method('PUT')

            <!-- Full Name: User's name -->
            <div>
                <label>Full Name</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded">
            </div>

            <!-- Email: User's email address -->
            <div>
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 rounded">
            </div>

            <!-- Phone: User's phone number -->
            <div>
                <label>Phone</label>
                <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border p-2 rounded">
            </div>

            <!-- User Type: Select the user's role in the system -->
            <div>
                <label>User Type</label>
                <select name="usertype" class="w-full border p-2 rounded">
                    <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="ticketer" {{ $user->usertype == 'ticketer' ? 'selected' : '' }}>Ticketer</option>
                    <option value="traffic" {{ $user->usertype == 'traffic' ? 'selected' : '' }}>Traffic</option>
                    <option value="hisabshum" {{ $user->usertype == 'hisabshum' ? 'selected' : '' }}>hisabshum</option>
                    <option value="mahberat" {{ $user->usertype == 'mahberat' ? 'selected' : '' }}>Mahberat</option>
                    <option value="balehabt" {{ $user->usertype == 'balehabt' ? 'selected' : '' }}>Balehabt</option>
                </select>
            </div>

            <!-- Birth Date: User's date of birth -->
            <div>
                <label>Birth Date</label>
                <input type="date" name="birth_date" value="{{ $user->birth_date }}" class="w-full border p-2 rounded">
            </div>

            <!-- National ID: User's national identification number -->
            <div>
                <label>National ID</label>
                <input type="text" name="national_id" value="{{ $user->national_id }}"
                    class="w-full border p-2 rounded">
            </div>

            <!-- Profile Picture: Upload a new profile image -->
            <div>
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" class="w-full">
            </div>

            <!-- PDF File: Upload a PDF document for the user -->
            <div>
                <label>PDF File</label>
                <input type="file" name="pdf_file" class="w-full">
            </div>

            <!-- Submit and Cancel Buttons -->
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
        </form>
    </div>
@endsection
