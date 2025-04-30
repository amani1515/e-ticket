@extends('admin.layout.app')

@section('content')
<h2 class="text-2xl font-bold mb-4">All Destinations</h2>

@if(session('success'))
    <div class="bg-green-100 p-2 mb-4 rounded">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.destinations.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Destination</a>

<table class="min-w-full bg-white rounded shadow">
    <thead class="bg-gray-200">
        <tr>
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Destination</th>
            <th class="px-4 py-2">Start From</th>
            <th class="px-4 py-2">Tarrif</th>
        </tr>
    </thead>
    <tbody>
        @foreach($destinations as $destination)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                <td class="px-4 py-2">{{ $destination->destination_name }}</td>
                <td class="px-4 py-2">{{ $destination->start_from }}</td>
                <td class="px-4 py-2">{{ $destination->tariff }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
