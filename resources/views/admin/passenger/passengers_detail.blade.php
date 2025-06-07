@extends('admin.layout.app')

@section('content')
<div class="p-6 bg-white rounded shadow">
    <h2 class="text-xl font-bold mb-4">Passenger Detail</h2>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p><strong>Name:</strong> {{ $ticket->passenger_name }}</p>
            <p><strong>Gender:</strong> {{ $ticket->gender }}</p>
            <p><strong>Phone:</strong> {{ $ticket->phone_no }}</p>
            <p><strong>Fayda ID:</strong> {{ $ticket->fayda_id }}</p>
            <p><strong>Age Status:</strong> {{ $ticket->age_status }}</p>
            <p><strong>Disability:</strong> {{ $ticket->disability_status }}</p>
        </div>
        <div>
            <p><strong>Ticket ID:</strong> {{ $ticket->id }}</p>
            <p><strong>Ticket Code:</strong> {{ $ticket->ticket_code }}</p>
            <p><strong>Ticket Status:</strong> {{ ucfirst($ticket->ticket_status) }}</p>
            <p><strong>Cancelled At:</strong> {{ $ticket->cancelled_at ?? '-' }}</p>
            <p><strong>Refunded At:</strong> {{ $ticket->refunded_at ?? '-' }}</p>
            <p><strong>Departure Date:</strong> {{ $ticket->departure_datetime }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <h3 class="font-semibold text-lg mb-2">Bus Info</h3>
            @if ($ticket->bus)
                <p><strong>Bus ID (Targa):</strong> {{ $ticket->bus->targa }}</p>
                <p><strong>Level:</strong> {{ $ticket->bus->level }}</p>
                <p><strong>Seat Count:</strong> {{ $ticket->bus->seat_count }}</p>
            @else
                <p>No Bus Info</p>
            @endif
        </div>

        <div>
            <h3 class="font-semibold text-lg mb-2">Destination Info</h3>
            @if ($ticket->destination)
                <p><strong>From:</strong> {{ $ticket->destination->start_from }}</p>
                <p><strong>To:</strong> {{ $ticket->destination->destination_name }}</p>
                <p><strong>Tariff:</strong> {{ $ticket->destination->tariff }} ETB</p>
            @else
                <p>No Destination Info</p>
            @endif
        </div>
    </div>

    @if ($ticket->cargo)
        <div class="mt-6">
            <h3 class="font-semibold text-lg mb-2">Cargo Info</h3>
            <p><strong>Item:</strong> {{ $ticket->cargo->item_name }}</p>
            <p><strong>Weight:</strong> {{ $ticket->cargo->weight }} KG</p>
            <p><strong>Price:</strong> {{ $ticket->cargo->price }} ETB</p>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ url()->previous() }}" class="bg-gray-600 text-white px-4 py-2 rounded">Back</a>
    </div>
</div>
@endsection
