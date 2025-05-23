@extends('balehabt.layout.app')

@section('content')
<div class="flex flex-col min-h-screen bg-gray-50 py-8 px-4">
    <h2 class="text-2xl md:text-3xl font-bold text-blue-700 mb-6 text-center">My Buses</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">ID</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Targa</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Driver Name</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Model</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Color</th>
                    <th class="px-4 py-2 text-left text-gray-700 font-semibold">Schedules</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buses as $bus)
                <tr class="border-b hover:bg-blue-50 align-top">
                    <td class="px-4 py-2">{{ $bus->id }}</td>
                    <td class="px-4 py-2">{{ $bus->targa }}</td>
                    <td class="px-4 py-2">{{ $bus->driver_name }}</td>
                    <td class="px-4 py-2">{{ $bus->model }}</td>
                    <td class="px-4 py-2">{{ $bus->color }}</td>
                    <td class="px-4 py-2">
                        @if($bus->schedules->count())
                            <div class="space-y-2">
                                @foreach($bus->schedules->sortByDesc('id') as $schedule)
                                    <div class="p-2 bg-gray-100 rounded mb-1">
                                        <div><span class="font-semibold">ID:</span> <span class="text-blue-900">{{ $schedule->id }}</span></div>
                                        <div><span class="font-semibold">Schedule UID:</span> <span class="text-blue-900">{{ $schedule->schedule_uid }}</span></div>
                                      
                                        <div><span class="font-semibold">Destination ID:</span> <span class="text-blue-900">{{ $schedule->destination_id }}</span></div>
                                        <div><span class="font-semibold">Scheduled By:</span> <span class="text-blue-900">{{ $schedule->scheduled_by }}</span></div>
                                        <div><span class="font-semibold">Ticket Created By:</span> <span class="text-blue-900">{{ $schedule->ticket_created_by }}</span></div>
                                        <div><span class="font-semibold">Scheduled At:</span> <span class="text-blue-900">{{ $schedule->scheduled_at }}</span></div>
                                        <div><span class="font-semibold">Status:</span> <span class="text-blue-900">{{ $schedule->status }}</span></div>
                                        <div><span class="font-semibold">Paid At:</span> <span class="text-blue-900">{{ $schedule->paid_at }}</span></div>
                                        <div><span class="font-semibold">Departed At:</span> <span class="text-blue-900">{{ $schedule->departed_at }}</span></div>
                                        <div><span class="font-semibold">Wellgo At:</span> <span class="text-blue-900">{{ $schedule->wellgo_at }}</span></div>
                                        <div><span class="font-semibold">Traffic Name:</span> <span class="text-blue-900">{{ $schedule->traffic_name }}</span></div>
                                        @if($schedule->destination)
                                            <div class="mt-2 p-2 bg-blue-50 rounded">
                                                <div class="font-semibold text-blue-700">Destination Info:</div>
                                                <div><span class="font-semibold">Name:</span> <span class="text-blue-900">{{ $schedule->destination->destination_name }}</span></div>
                                                <div><span class="font-semibold">From:</span> <span class="text-blue-900">{{ $schedule->destination->start_from }}</span></div>
                                                <div><span class="font-semibold">Tariff:</span> <span class="text-blue-900">{{ $schedule->destination->tariff }}</span></div>
                                                <div><span class="font-semibold">Tax:</span> <span class="text-blue-900">{{ $schedule->destination->tax }}</span></div>
                                                       </div>
                                        @endif
                                    </div>
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
