@extends('hisabShum.layouts.app')

@section('title', 'Paid Reports')

@section('content')
    <h2 class="text-xl font-bold mb-4">Paid Bus Schedules</h2>
    <table class="min-w-full bg-white shadow rounded">
        <thead>
            <tr>
                <th class="px-4 py-2">የሰሌዳ ቁጥር </th>
                <th class="px-4 py-2">የተሽከርካሪ ደረጃ </th>
                <th class="px-4 py-2">መዳረሻ </th>
                <th class="px-4 py-2">የመውጫ ክፍያ </th> {{-- 👈 New column --}}
                <th class="px-4 py-2">የመዉጫ ክፍያ ያለበት ሁኔታ </th>
                <th class="px-4 py-2">ተራ የተመደበበት ቀንሰ እና ሰዓት </th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($schedules as $schedule)
                <tr>
                    <td class="border px-4 py-2">{{ $schedule->bus->targa ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->bus->level ?? '-' }}</td>
                    <td class="border px-4 py-2">{{ $schedule->destination->destination_name ?? '-' }}</td>
                    <td class="px-4 py-2">
                            @if($schedule->mewucha_fee == 0 || is_null($schedule->mewucha_fee))
                                <span class="inline-block px-2 py-1 text-sm font-semibold text-red-800 bg-red-200 rounded-full">
                                    0.00 ETB
                                </span>
                            @else
                                <span class="inline-block px-2 py-1 text-sm font-semibold text-green-800 bg-green-200 rounded-full">
                                    {{ number_format($schedule->mewucha_fee, 2) }} ETB
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($schedule->mewucha_status !== 'paid')
                                <span class="inline-block px-2 py-1 text-sm font-semibold text-red-800 bg-red-200 rounded-full">
                                    Unpaid
                                </span>
                            @else
                                <span class="inline-block px-2 py-1 text-sm font-semibold text-green-800 bg-green-200 rounded-full">
                                    Paid
                                </span>
                            @endif
                        </td>

                    <td class="border px-4 py-2">{{ $schedule->scheduled_at }}</td>
                    <td class="border px-4 py-2 space-x-2">
                       @if($schedule->mewucha_status === 'paid')
                        <a href="{{ route('hisabShum.certificate', $schedule->id) }}"
                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded"
                        target="_blank">
                            Certificate
                        </a>
                    @endif

                    <a href="{{ route('hisabShum.schedule.payForm', $schedule->id) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
                        Pay
                    </a>
<form action="{{ route('hisabShum.schedule.payCash', $schedule->id) }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded">
        Pay with cash
    </button>
</form>


                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No paid schedules found.</td> {{-- 👈 Update colspan --}}
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
