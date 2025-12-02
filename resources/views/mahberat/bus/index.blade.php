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

<div class="container mx-auto px-2 sm:px-4 py-4 sm:py-8 animate-fade-in">
    <h2 class="text-xl sm:text-2xl font-bold text-blue-700 mb-4 sm:mb-6 border-b pb-2">🚌 Registered Buses</h2>

    {{-- Search Form --}}
    <div class="mb-6">
        <form method="GET" action="{{ route('mahberat.bus.index') }}" class="flex flex-col sm:flex-row gap-2 sm:gap-4 items-stretch sm:items-center">
            <div class="flex-1">
                <input type="text" 
                       name="search" 
                       value="{{ $search }}" 
                       placeholder="Search buses..." 
                       class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div class="flex gap-2">
                <button type="submit" 
                        class="flex-1 sm:flex-none px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-150">
                    Search
                </button>
                @if($search)
                    <a href="{{ route('mahberat.bus.index') }}" 
                       class="flex-1 sm:flex-none px-4 py-2 text-sm text-center bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition duration-150">
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Mobile Card View --}}
    <div class="block sm:hidden space-y-4">
        @if($search)
            <div class="px-4 py-3 bg-blue-50 rounded-lg">
                <p class="text-sm text-blue-700">
                    <strong>{{ $buses->total() }}</strong> buses found
                </p>
            </div>
        @endif
        
        @forelse($buses as $bus)
            <div class="bg-white rounded-lg shadow p-4 border">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-lg text-gray-900">{{ $bus->targa }}</h3>
                        <p class="text-sm text-gray-600">{{ $bus->driver_name }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $bus->status === 'active' ? 'bg-green-100 text-green-800' : ($bus->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($bus->status) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-sm mb-3">
                    <div><span class="text-gray-500">Phone:</span> {{ $bus->driver_phone }}</div>
                    <div><span class="text-gray-500">Level:</span> {{ $bus->level }}</div>
                    <div><span class="text-gray-500">Model:</span> {{ $bus->model }}</div>
                    <div><span class="text-gray-500">Sub-Level:</span> {{ $bus->sub_level }}</div>
                </div>
                
                <div class="flex gap-2">
                    <a href="{{ route('mahberat.bus.edit', $bus->id) }}"
                       class="flex-1 text-center px-3 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">
                        Edit
                    </a>
                    <form action="{{ route('mahberat.bus.destroy', $bus->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Delete this bus?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-3 py-2 text-sm bg-red-500 text-white rounded hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-gray-500">
                No buses registered yet.
            </div>
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden sm:block bg-white rounded-lg shadow overflow-x-auto transition duration-300 hover:shadow-md">
        @if($search)
            <div class="px-6 py-3 bg-blue-50 border-b">
                <p class="text-sm text-blue-700">
                    <strong>{{ $buses->total() }}</strong> buses found for "<strong>{{ $search }}</strong>"
                </p>
            </div>
        @endif
        
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
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No buses registered yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination Links --}}
    <div class="mt-4 sm:mt-6">
        {{ $buses->links() }}
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
