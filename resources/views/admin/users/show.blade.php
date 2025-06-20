@extends('admin.layout.app')

@section('content')
<div class="p-4">
    <h2 class="text-xl font-bold mb-4">User Details</h2>

    <div class="bg-white p-4 rounded shadow">
        <p><strong>Full Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone:</strong> {{ $user->phone }}</p>
        <p><strong>User Type:</strong> {{ $user->usertype }}</p>
        <p><strong>National ID:</strong> {{ $user->national_id }}</p>
        

        @if ($user->profile_picture)
            <p><strong>Profile Picture:</strong><br>
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile" class="w-32 mt-2">
            </p>
        @endif

        @if ($user->pdf_file)
            <p><strong>File:</strong> 
                <a href="{{ asset('storage/' . $user->pdf_file) }}" target="_blank" class="text-blue-500 underline">Download</a>
            </p>
        @endif
    </div>

    <a href="{{ route('admin.users.index') }}" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2 rounded">Back</a>
</div>
@endsection
