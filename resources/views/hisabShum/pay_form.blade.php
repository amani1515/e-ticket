@extends('hisabShum.layouts.app')

@section('title', 'Pay Mewucha Fee')

@section('content')
    <h2 class="text-xl font-bold mb-4">Pay Mewucha Fee for Schedule #{{ $schedule->id }}</h2>

    <p>Bus Level: <strong>{{ $schedule->bus->level ?? 'N/A' }}</strong></p>
    <p>Destination: <strong>{{ $schedule->destination->destination_name ?? 'N/A' }}</strong></p>
    <p>Mewucha Fee: <strong>ETB {{ number_format($feeAmount, 2) }}</strong></p>

    <form action="{{ route('hisabShum.schedule.pay', $schedule->id) }}" method="POST">
        @csrf
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
            Proceed to Pay with Chapa
        </button>
    </form>
@endsection
