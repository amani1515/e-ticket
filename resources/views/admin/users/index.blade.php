@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-[#fdf6e3] p-4 sm:p-8">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-extrabold text-[#b58900] mb-6 animate-fade-in-down">👥 All Users</h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded-md shadow mb-6 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.users.create') }}"
            class="inline-block mb-6 bg-[#d4af37] text-white px-6 py-2 rounded-xl shadow hover:bg-[#c19a29] transition-all duration-300 animate-fade-in">
            ➕ Add New User
        </a>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden animate-fade-in-up">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-[#b58900] text-white">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Email</th>
                            <th class="px-4 py-3">Phone</th>
                            <th class="px-4 py-3">User Type</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#f6e8c0]">
                        @foreach($users as $user)
                        <tr class="hover:bg-[#fcf6dc] transition duration-200">
                            <td class="px-4 py-4 text-gray-800">{{ $user->name }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-4 text-gray-600">{{ $user->phone ?? '-' }}</td>
                            <td class="px-4 py-4 capitalize text-gray-600">{{ $user->usertype }}</td>
                            <td class="px-4 py-4">
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="bg-[#6c63ff] hover:bg-[#574fd1] text-white px-3 py-1 rounded-md text-xs sm:text-sm transition duration-300 text-center">
                                        View
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="bg-[#f4c542] hover:bg-[#e5b729] text-white px-3 py-1 rounded-md text-xs sm:text-sm transition duration-300 text-center">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="bg-[#e63946] hover:bg-[#c92d3b] text-white px-3 py-1 rounded-md text-xs sm:text-sm transition duration-300 text-center">
        Delete
    </button>
</form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Animation classes --}}
@push('styles')
<style>
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fade-in-down {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fade-in-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .animate-fade-in {
        animation: fade-in 0.5s ease-in-out;
    }

    .animate-fade-in-down {
        animation: fade-in-down 0.5s ease-out;
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out;
    }
</style>
@endpush
@endsection
