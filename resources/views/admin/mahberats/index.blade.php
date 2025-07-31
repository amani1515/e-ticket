@extends('admin.layout.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-amber-100 p-4 sm:p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-amber-900 mb-2">🏢 Mahberat Management</h1>
            <p class="text-amber-700">Manage mahberat groups and their destinations</p>
            <!-- Debug info -->
            <div class="text-xs text-gray-500 mt-2">
                Debug: {{ count($destinations ?? []) }} destinations, {{ $mahberats->count() }} mahberats
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Action Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <a href="{{ route('admin.mahberats.create') }}"
                class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg shadow-lg transition-all duration-300 transform hover:scale-105">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Mahber
            </a>
            
            <!-- Stats Cards -->
            <div class="flex gap-4">
                <div class="bg-white rounded-lg shadow px-4 py-2">
                    <div class="text-sm text-amber-600">Total Mahberats</div>
                    <div class="text-2xl font-bold text-amber-900">{{ $mahberats->total() }}</div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-2xl shadow-xl p-6 mb-6">
            <form method="GET" action="{{ route('admin.mahberats.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-amber-700 mb-2">Search Mahberats</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Search by mahberat name..."
                                   class="w-full pl-10 pr-4 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <svg class="absolute left-3 top-2.5 h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <!-- Destination Filter -->
                    <div>
                        <label class="block text-sm font-medium text-amber-700 mb-2">Filter by Destination</label>
                        <select name="destination_filter" class="w-full px-3 py-2 border border-amber-200 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Destinations</option>
                            @if(isset($destinations))
                                @foreach($destinations as $destination)
                                    <option value="{{ $destination->id }}" {{ request('destination_filter') == $destination->id ? 'selected' : '' }}>
                                        {{ $destination->start_from }} → {{ $destination->destination_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.207A1 1 0 013 6.5V4z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    <a href="{{ route('admin.mahberats.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Mahberats Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            @if($mahberats->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gradient-to-r from-amber-600 to-yellow-600 text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Mahberat Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Assigned Destinations</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Total Users</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-amber-100">
                            @foreach($mahberats as $index => $mahberat)
                            <tr class="hover:bg-amber-50 transition-colors duration-200">
                                <td class="px-6 py-4 text-sm text-amber-900 font-medium">
                                    {{ ($mahberats->currentPage() - 1) * $mahberats->perPage() + $index + 1 }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-amber-900">{{ $mahberat->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1">
                                        @forelse($mahberat->destinations as $destination)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                                {{ $destination->start_from }} → {{ $destination->destination_name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-500 text-sm">No destinations assigned</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $mahberat->users->count() }} users
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.mahberats.show', $mahberat->id) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-md transition-colors duration-200">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-amber-900">No mahberats found</h3>
                    <p class="mt-1 text-sm text-amber-600">Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($mahberats->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow px-6 py-4">
                {{ $mahberats->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
