@extends('mahberat.layout.app')

@section('content')
<div class="ml-64 px-6 py-6"> {{-- Adjust margin based on sidebar width --}}
    <h2 class="text-2xl font-semibold mb-4">Scheduled Buses</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 p-4 rounded mb-4 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('mahberat.schedule.create') }}"
       class="inline-block mb-4 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow">
        + Schedule New Bus
    </a>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full table-auto border border-gray-200">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">#</th>
                    <th class="px-4 py-2 text-left">Targa</th>
                    <th class="px-4 py-2 text-left">Destination</th>
                    <th class="px-4 py-2 text-left">Scheduled At</th>
                    <th class="px-4 py-2 text-left">Scheduled By</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($schedules as $index => $schedule)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $schedule->bus->targa }}</td>
                        <td class="px-4 py-2">{{ $schedule->destination->destination_name }}</td>
                        <td class="px-4 py-2">{{ $schedule->scheduled_at }}</td>
                        <td class="px-4 py-2">{{ $schedule->scheduledBy->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2">{{ ucfirst($schedule->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                            No scheduled buses yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
