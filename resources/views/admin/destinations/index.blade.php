@extends('admin.layout.app')

@section('content')
<div class="max-w-6xl mx-auto p-4">
    <h2 class="text-3xl font-bold text-yellow-600 mb-6">All Destinations</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.destinations.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded shadow transition duration-200">
            + Add New Destination
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-left">
            <thead class="bg-yellow-100 text-yellow-700">
                <tr>
                    <th class="px-6 py-3 font-medium">#</th>
                    <th class="px-6 py-3 font-medium">Destination</th>
                    <th class="px-6 py-3 font-medium">Start From</th>
                    <th class="px-6 py-3 font-medium">Tariff</th>
                </tr>
            </thead>
            <tbody>
                @forelse($destinations as $destination)
                    <tr class="border-b hover:bg-yellow-50 transition">
                        <td class="px-6 py-3">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">{{ $destination->destination_name }}</td>
                        <td class="px-6 py-3">{{ $destination->start_from }}</td>
                        <td class="px-6 py-3">{{ $destination->tariff }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No destinations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
