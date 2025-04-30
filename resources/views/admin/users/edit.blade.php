@extends('admin.layout.app')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">Edit User</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-4 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label>Full Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>User Type</label>
            <select name="usertype" class="w-full border p-2 rounded">
                <option value="admin" {{ $user->usertype == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="ticketer" {{ $user->usertype == 'ticketer' ? 'selected' : '' }}>Ticketer</option>
                <option value="traffic" {{ $user->usertype == 'traffic' ? 'selected' : '' }}>Traffic</option>
                <option value="mahberat" {{ $user->usertype == 'mahberat' ? 'selected' : '' }}>Mahberat</option>
                <option value="balehabt" {{ $user->usertype == 'balehabt' ? 'selected' : '' }}>Balehabt</option>
            </select>
        </div>

        <div>
            <label>Birth Date</label>
            <input type="date" name="birth_date" value="{{ $user->birth_date }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>National ID</label>
            <input type="text" name="national_id" value="{{ $user->national_id }}" class="w-full border p-2 rounded">
        </div>

        <div>
            <label>Profile Picture</label>
            <input type="file" name="profile_picture" class="w-full">
        </div>

        <div>
            <label>PDF File</label>
            <input type="file" name="pdf_file" class="w-full">
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update User</button>
        <a href="{{ route('admin.users.index') }}" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
    </form>
</div>
@endsection
