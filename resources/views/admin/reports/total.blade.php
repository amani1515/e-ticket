@extends('admin.layout.app')
@section('content')
    <div class="p-8">
        <h2 class="text-2xl font-bold mb-6">Total Report</h2>

        <!-- Date Filter Form -->
        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end bg-yellow-50 p-4 rounded shadow">
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700">From</label>
                <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}"
                    class="border border-yellow-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700">To</label>
                <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}"
                    class="border border-yellow-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded transition duration-300">
                Filter
            </button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($destinations as $destination)
                <div class="bg-yellow-100 border border-yellow-300 rounded-lg shadow p-6 flex flex-col items-center">
                    <div class="text-lg font-semibold mb-2 text-yellow-800">{{ $destination->destination_name }}</div>
                    <div class="text-4xl font-bold text-yellow-700 mb-1">
                        {{ $destination->tickets_count }}
                    </div>
                    <div class="text-gray-700 mb-2">Passengers</div>
                    <div class="w-full text-sm text-gray-800">
                        <div>👨 Male: <span class="font-semibold">{{ $destination->male_count ?? 0 }}</span></div>
                        <div>👩 Female: <span class="font-semibold">{{ $destination->female_count ?? 0 }}</span></div>
                        <div>👥 Total: <span class="font-semibold">{{ ($destination->male_count ?? 0) + ($destination->female_count ?? 0) }}</span></div>
                        <div>🚌 Total KM Covered: <span class="font-semibold">{{ $destination->total_km ?? 0 }}</span> km</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection