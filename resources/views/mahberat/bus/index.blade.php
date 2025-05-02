@extends('mahberat.layout.app')

@section('content')
@if(session('success'))
    <div class="ml-64 px-4 mt-4"> {{-- Adjust ml-64 based on your sidebar width --}}
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded shadow" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    </div>
@endif



<div class="ml-64 container mx-auto mt-6"> {{-- Adjusted for sidebar width --}}
    <h2 class="text-2xl font-bold mb-4">Registered Buses</h2>
    <table class="min-w-full bg-white border border-gray-200 shadow rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-left">Targa</th>
                <th class="px-4 py-2 text-left">Driver</th>
                <th class="px-4 py-2 text-left">Level</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Model</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($buses as $bus)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $bus->targa }}</td>
                    <td class="px-4 py-2">{{ $bus->driver_name }}</td>
                    <td class="px-4 py-2">{{ $bus->level }}</td>
                    <td class="px-4 py-2">{{ $bus->status }}</td>
                    <td class="px-4 py-2">{{ $bus->model }}</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="{{ route('mahberat.bus.edit', $bus->id) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('mahberat.bus.destroy', $bus->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
