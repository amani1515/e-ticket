@extends('ticketer.layout.app')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-4">Schedule Report</h2>
    <table class="min-w-full bg-white shadow rounded">
        <thead>
    <tr>
        <th class="px-4 py-2">Bus Targa</th>
        <th class="px-4 py-2">Destination</th>
        <th class="px-4 py-2">Status</th>
        <th class="px-4 py-2">Capacity</th>
        <th class="px-4 py-2">Boarding</th>
        <th class="px-4 py-2">Completed Tickets</th>
        <th class="px-4 py-2">Waiting Scan Tickets</th>
        <th class="px-4 py-2">Service Fee</th>
        <th class="px-4 py-2">Tariff</th>
        <th class="px-4 py-2">Tax</th>
        <th class="px-4 py-2">Mewucha</th>
        <th class="px-4 py-2">Scheduled At</th>
        <th class="px-4 py-2">Net Balance</th>
        <th class="px-4 py-2">Action</th>

    </tr>
</thead>
<tbody>
   @forelse($schedules as $schedule)
    <tr>
        <td class="border px-4 py-2">{{ $schedule->bus->targa ?? '-' }}</td>
        <td class="border px-4 py-2">{{ $schedule->destination->destination_name ?? '-' }}</td>
        <td class="border px-4 py-2">{{ ucfirst($schedule->status) }}</td>
        <td class="border px-4 py-2">{{ $schedule->capacity }}</td>
        <td class="border px-4 py-2">{{ $schedule->boarding }}</td>
       <td class="border px-4 py-2">
    {{ \App\Models\Ticket::where('bus_id', $schedule->bus_id)
        ->where('destination_id', $schedule->destination_id)
        ->where('schedule_id', $schedule->id)
        ->where('ticket_status', 'confirmed')
        ->count() }}
</td>
        <td class="border px-4 py-2">
            {{ \App\Models\Ticket::where('bus_id', $schedule->bus_id)
                ->where('destination_id', $schedule->destination_id)
                ->whereIn('ticket_status', ['waiting_scan', 'created'])
                ->count() }}
        </td>
        <td class="border px-4 py-2">
            {{ $schedule->tickets()->sum('service_fee') }}
        </td>
       <td class="border px-4 py-2">
    {{
        ($schedule->destination->tariff ?? 0) *
        \App\Models\Ticket::where('bus_id', $schedule->bus_id)
            ->where('destination_id', $schedule->destination_id)
            ->where('schedule_id', $schedule->id)
            ->whereIn('ticket_status', ['created', 'confirmed'])
            ->count()
    }}
</td>
        <td class="border px-4 py-2">
            {{ $schedule->tickets()->sum('tax') }}
        </td>
        <td class="border px-4 py-2">50</td>

        <td class="border px-4 py-2">{{ $schedule->scheduled_at }}</td>
        <td class="border px-4 py-2">
    {{
        (($schedule->destination->tariff ?? 0) *
        \App\Models\Ticket::where('bus_id', $schedule->bus_id)
            ->where('destination_id', $schedule->destination_id)
            ->where('schedule_id', $schedule->id)
            ->whereIn('ticket_status', ['created', 'confirmed'])
            ->count()) - 50
    }}
</td>
<td class="border px-4 py-2">
    @if($schedule->status === 'full')
        <form action="{{ route('ticketer.schedule.pay', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this schedule as paid?');">
            @csrf
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Pay</button>
        </form>
    @endif
</td>
    </tr>
@empty
    <tr>
        <td colspan="11" class="text-center py-4">No schedules found.</td>
    </tr>
@endforelse
</tbody>
    </table>
</div>
@endsection