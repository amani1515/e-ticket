<!-- filepath: resources/views/ticketer/tickets/receipt.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Ticket Receipt</title>
    <style>
        body {
            font-family: monospace;
            width: 58mm; /* or 80mm depending on your printer */
            font-size: 12px;
            margin: 0;
            padding: 5px;
        }

        .center {
            text-align: center;
        }

        .barcode {
            margin-top: 10px;
        }

        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }

        .buttons {
            margin-top: 20px;
            text-align: center;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
        }

        .btn-back {
            background-color: #f44336;
        }

        .btn:hover {
            opacity: 0.8;
        }

        @media print {
            .buttons {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="center">
        <h3>SEBUS TICKET</h3>
        <div class="divider"></div>
    </div>

    <p><strong>Name:</strong> {{ $ticket->passenger_name }}</p>
    <p><strong>Age Status:</strong> {{ ucfirst($ticket->age_status) }}</p>
    <p><strong>From:</strong> {{ $ticket->destination->start_from }}</p>
    <p><strong>To:</strong> {{ $ticket->destination->destination_name }}</p>
    <p><strong>Departure:</strong> {{ $ticket->departure_datetime }}</p>
    <p><strong>Bus No:</strong> {{ $ticket->bus_id }}</p>
    <p><strong>Ticket Code:</strong> {{ $ticket->ticket_code }}</p>

@if($ticket->cargo)
    <p><strong>Cargo Ticket:</strong> {{ $ticket->cargo->cargo_uid }}</p>
    <p><strong>Cargo Weight:</strong> {{ $ticket->cargo->weight }} kg</p>
    <p><strong>Cargo Fee:</strong> {{ number_format($ticket->cargo->total_amount, 2) }} ETB</p>
@endif
<p><strong>Total Price:</strong>
    {{
        $ticket->destination->tariff +
        $ticket->destination->tax +
        $ticket->destination->service_fee +
        ($ticket->cargo ? $ticket->cargo->total_amount : 0)
    }} ETB
</p>
    <!-- Barcode -->
    <div class="center barcode">
        {!! DNS1D::getBarcodeHTML($ticket->ticket_code, 'C128', 1, 30) !!}
    </div>

    <div class="center divider"></div>
    <div class="center">
        <p>Thank you for choosing SEBus</p>
    </div>

    <!-- Print and Back Buttons -->
    <div class="buttons">
        <button class="btn" onclick="window.print()">Print Receipt</button>
        <a href="{{ route('ticketer.tickets.create') }}">
            <button class="btn btn-back">Back</button>
        </a>
    </div>

</body>
</html>