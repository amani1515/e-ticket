@extends('mahberat.layout.app')

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif

<div class="container mx-auto px-4 py-8 animate-fade-in">
    <h2 class="text-2xl font-bold text-blue-700 mb-6 border-b pb-2">🚌 Registered Buses</h2>

    <div class="bg-white rounded-lg shadow overflow-x-auto transition duration-300 hover:shadow-md">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">Targa</th>
                    <th class="px-6 py-3 text-left">Driver</th>
                    <th class="px-6 py-3 text-left">Driver phone</th>

                    <th class="px-6 py-3 text-left">Level</th>
                    <th class="px-6 py-3 text-left">Sub-Level</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Model</th>
                    <th class="px-6 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($buses as $bus)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 font-medium">{{ $bus->targa }}</td>
                        <td class="px-6 py-4">{{ $bus->driver_name }}</td>
                        <td class="px-6 py-4">{{ $bus->driver_phone }}</td>

                        <td class="px-6 py-4 capitalize">{{ $bus->level }}</td>
                        <td class="px-6 py-4 capitalize">{{ $bus->sub_level }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $bus->status === 'active' ? 'bg-green-100 text-green-800' : ($bus->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($bus->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $bus->model }}</td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="{{ route('mahberat.bus.edit', $bus->id) }}"
                               class="text-blue-600 hover:text-blue-800 font-medium transition duration-150">Edit</a>

                            <form action="{{ route('mahberat.bus.destroy', $bus->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this bus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition duration-150">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No buses registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Fade Animation Style --}}
<style>
    .animate-fade-in {
        animation: fadeIn 0.5s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
