@extends('admin.layout.app')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Mahberat Groups</h1>
        <a href="{{ route('admin.mahberats.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            + Add New Mahber
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 shadow-sm">
            <thead class="bg-gray-100 text-left text-sm font-semibold">
                <tr>
                    <th class="px-4 py-2 border-b">#</th>
                    <th class="px-4 py-2 border-b">Mahberat Name</th>
                    <th class="px-4 py-2 border-b">Assigned Destinations</th>
                    <th class="px-4 py-2 border-b">Total Users</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($mahberats as $mahberat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b font-semibold">{{ $mahberat->name }}</td>
                        <td class="px-4 py-2 border-b">
                            @foreach($mahberat->destinations as $destination)
                                <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded text-xs mb-1 mr-1">
                                    {{ $destination->start_from }} → {{ $destination->destination_name }}
                                </span>
                            @endforeach
                        </td>
                        <td class="px-4 py-2 border-b">{{ $mahberat->users->count() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-gray-500 py-4">No mahberat groups found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
