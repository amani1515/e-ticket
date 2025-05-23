@extends('balehabt.layout.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50 py-8 px-4">
    <div class="flex justify-end mb-4">
        <a href="/home"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow transition">
           Go To Daily Report
        </a>
    </div>
    <h2 class="text-2xl md:text-3xl font-bold text-blue-700 mb-6 text-center">My Buses</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead>
                <tr>
                   
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Targa</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Driver Name</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Color</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Schedules</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buses as $bus)
                <tr class="border-b hover:bg-blue-50 align-top">
                    
                    <td class="px-4 py-2">{{ $bus->targa }}</td>
                    <td class="px-4 py-2">{{ $bus->driver_name }}</td>
                    <td class="px-4 py-2">{{ $bus->color }}</td>
                    <td class="px-4 py-2">
                        @if($bus->schedules->count())
                            <div class="space-y-4">
                                @foreach($bus->schedules->sortByDesc('id') as $schedule)
                                    <details class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-3 transition-all duration-200">
                                        <summary class="cursor-pointer flex items-center justify-between font-semibold text-blue-800 text-lg group-open:text-blue-600">
                                            <span>
                                                <span class="mr-2">#{{$schedule->destination->start_from   }} To {{ $schedule->destination->destination_name  }}</span>
                                                <span class="text-xl text-green-500">({{ $schedule->status }})</span>
                                            </span>
                                            <svg class="w-5 h-5 ml-2 transition-transform duration-200 group-open:rotate-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </summary>
                                        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-1 text-sm md:text-base">
                                            <div><span class="font-semibold">Schedule UID:</span> <span class="text-blue-900">{{ $schedule->schedule_uid }}</span></div>
                                            <div><span class="font-semibold">Scheduled At:</span> <span class="text-blue-900">{{ $schedule->scheduled_at }}</span></div>
                                            <div><span class="font-semibold">Paid At:</span> <span class="text-blue-900">{{ $schedule->paid_at }}</span></div>
                                            <div><span class="font-semibold">Departed At:</span> <span class="text-blue-900">{{ $schedule->departed_at }}</span></div>
                                            <div><span class="font-semibold">Wellgo At:</span> <span class="text-blue-900">{{ $schedule->wellgo_at }}</span></div>
                                            <div><span class="font-semibold">Tariff:</span> <span class="text-blue-900">{{ $schedule->destination->tariff }}</span></div>
                                                  
                                        </div>
                                       
                                    </details>
                                @endforeach
                            </div>
                        @else
                            <span class="text-gray-400">No schedules</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No buses found for your account.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
