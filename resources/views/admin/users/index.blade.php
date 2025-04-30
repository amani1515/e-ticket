@extends('admin.layout.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">All Users</h1>

@if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('admin.users.create') }}" class="mb-4 inline-block bg-green-600 text-white px-4 py-2 rounded">Add New User</a>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-yellow-800 text-white">
        <tr>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Phone</th>
            <th class="px-4 py-2 text-left">User Type</th>
            <th class="px-4 py-2 text-left">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-200">
        @foreach($users as $user)
        <tr>
            <td class="px-4 py-2">{{ $user->name }}</td>
            <td class="px-4 py-2">{{ $user->email }}</td>
            <td class="px-4 py-2">{{ $user->phone ?? '-' }}</td>
            <td class="px-4 py-2">{{ $user->usertype }}</td>
            <td class="flex space-x-2">
                <a href="{{ route('admin.users.show', $user->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">View</a>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                </form>
            </td>
            
        </tr>

        <!-- View Modal -->
        <div x-data="{ viewModal_{{ $user->id }}: false }" x-show="viewModal_{{ $user->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded w-96">
                <h2 class="text-xl font-bold mb-4">User Details</h2>
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
                <p><strong>User Type:</strong> {{ $user->usertype }}</p>
                <button @click="viewModal_{{ $user->id }} = false" class="mt-4 bg-yellow-800 text-white px-4 py-2 rounded">Close</button>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-data="{ editModal_{{ $user->id }}: false }" x-show="editModal_{{ $user->id }}" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded w-96">
                <h2 class="text-xl font-bold mb-4">Edit User</h2>
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded px-2 py-1">
                    </div>
                    <div class="mb-2">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-2 py-1">
                    </div>
                    <div class="mb-2">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border rounded px-2 py-1">
                    </div>
                    <div class="mb-2">
                        <label>User Type</label>
                        <select name="usertype" class="w-full border rounded px-2 py-1">
                            <option {{ $user->usertype === 'admin' ? 'selected' : '' }} value="admin">Admin</option>
                            <option {{ $user->usertype === 'ticketer' ? 'selected' : '' }} value="ticketer">Ticketer</option>
                            <option {{ $user->usertype === 'traffic' ? 'selected' : '' }} value="traffic">Traffic</option>
                        </select>
                    </div>
                    <div class="flex justify-between mt-4">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Update</button>
                        <button @click="editModal_{{ $user->id }} = false" type="button" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        @endforeach
    </tbody>
</table>
@endsection
