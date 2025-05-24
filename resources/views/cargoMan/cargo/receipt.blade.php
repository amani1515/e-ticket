@extends('cargoMan.layout.app')

@section('title', 'Cargo Receipt')

@section('content')
<div class="max-w-lg mx-auto bg-white p-8 rounded shadow text-center">
    <h2 class="text-2xl font-bold mb-4">Cargo Receipt</h2>
    <div class="mb-2"><strong>Receipt No:</strong> {{ $cargo->cargo_uid }}</div>
    <div class="mb-2"><strong>Bus:</strong> {{ $cargo->bus->targa ?? '-' }}</div>
    <div class="mb-2"><strong>Destination:</strong> {{ $cargo->destination->destination_name ?? '-' }}</div>
    <div class="mb-2"><strong>Schedule:</strong> {{ $cargo->schedule->schedule_uid ?? '-' }}</div>
    <div class="mb-2"><strong>Weight:</strong> {{ $cargo->weight }} kg</div>
    <div class="mb-2"><strong>Service Fee:</strong> {{ number_format($cargo->service_fee, 2) }}</div>
    <div class="mb-2"><strong>Tax:</strong> {{ number_format($cargo->tax, 2) }}</div>
    <div class="mb-2"><strong>Total Amount:</strong> <span class="font-bold text-lg">{{ number_format($cargo->total_amount, 2) }}</span></div>
    <div class="my-4">
        {{-- Barcode (optional, use a package or just show UID) --}}
        <div style="font-size: 1.5em; letter-spacing: 0.2em;">{{ $cargo->cargo_uid }}</div>
    </div>
    <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow mt-4">Print</button>
</div>
<script>
    window.onload = function() {
        window.print();
    };
</script>
@endsection