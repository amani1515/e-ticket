@extends('mahberat.layout.app')

@section('content')


@if(session('success'))
    <div id="success-animation" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-green-100 border border-green-400 text-green-800 px-8 py-6 rounded-xl shadow-2xl flex flex-col items-center animate-fade-in-up">
            <svg class="w-16 h-16 mb-4 text-green-500 animate-bounce" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
            </svg>
            <div class="text-2xl font-bold mb-2">Successfully Added!</div>
            <div class="text-lg">{{ session('success') }}</div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('success-animation').style.display = 'none';
        }, 2000);
    </script>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.5s, fadeOut 0.5s 1.5s forwards;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px);}
            to { opacity: 1; transform: translateY(0);}
        }
        @keyframes fadeOut {
            to { opacity: 0; }
        }
    </style>
@endif

<div class="container mx-auto px-4 py-8 animate-fade-in">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-yellow-700 border-b pb-1">🗓️ Scheduled Buses</h2>
        <a href="{{ route('mahberat.schedule.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition duration-150">
            + Schedule New Bus
        </a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto transition duration-300 hover:shadow-md">
        <table class="min-w-full table-auto text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3 text-left">#</th>
                    <th class="px-6 py-3 text-left">Targa</th>
                    <th class="px-6 py-3 text-left">Destination</th>
                    <th class="px-6 py-3 text-left">Scheduled At</th>
                    <th class="px-6 py-3 text-left">Scheduled By</th>
                    <th class="px-6 py-3 text-left">Status</th>
                    <th class="px-6 py-3 text-left">Remove</th> <!-- Add Remove column -->
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($schedules as $index => $schedule)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 font-medium">{{ $index + 1 }}</td>
                        <td class="px-6 py-4">{{ $schedule->bus->targa }}</td>
                        <td class="px-6 py-4">{{ $schedule->destination->destination_name }}</td>
                        <td class="px-6 py-4">{{ $schedule->scheduled_at }}</td>
                        <td class="px-6 py-4">{{ $schedule->scheduledBy->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $schedule->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($schedule->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                {{ ucfirst($schedule->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <form action="{{ route('mahberat.schedule.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this schedule?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-bold px-3 py-1 rounded transition">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">
                            No scheduled buses yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Fade Animation --}}
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
