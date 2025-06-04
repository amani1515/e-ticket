<!DOCTYPE html>
<html>
<head>
    <title>Sevastopol Technologies PLC</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f0f0f0;
            font-family: monospace;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .receipt {
            background: #fff;
            width: 80mm;
            padding: 5px;
            font-size: 12px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            margin: 20px auto;
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

        .logo {
            width: 40mm;
            margin: 0 auto 5px auto;
            display: block;
        }

        .footer-info {
            font-size: 11px;
            color: #333;
            margin-top: 10px;
            text-align: center;
        }

        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }

            .buttons {
                display: none;
            }

            .receipt {
                box-shadow: none;
                margin: 0;
                padding: 5px;
                width: 80mm;
                height: auto !important;
                overflow: hidden;
            }

            .barcode, svg, img {
                display: block !important;
                visibility: visible !important;
                height: auto !important;
                width: auto !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body>

    <div class="receipt">

        <div class="center">
            <img src="{{ asset('logo.png') }}" alt="SEBUS Logo" class="logo">
            <h3>E-TICKET</h3>
            <div class="divider"></div>
        </div>

        <p><strong style="font-size: 1.3em;">ሰሌዳ ቁጥር:</strong> {{ $ticket->bus->targa ?? $ticket->bus_id }}</p>
        <p><strong>የተጓዥ ስም:</strong> {{ $ticket->passenger_name }}</p>
        <p><strong>ጾታ:</strong> {{ ucfirst($ticket->gender) }}</p>
@php
    $ageStatusAmharic = [
        'baby' => 'ህጻን',
        'adult' => 'ወጣት',
        'middle_aged' => 'ጎልማሳ',
        'senior' => 'ሽማግሌ',
    ];
@endphp

<p><strong>የእድሜ ሁኔታ :</strong> {{ $ageStatusAmharic[$ticket->age_status] ?? $ticket->age_status }}</p>
        <p><strong>  disability status :</strong>  {{ $ticket->disability_status }}</p>

        <p><strong>መነሻ :</strong> {{ $ticket->destination->start_from }}</p>
        <p><strong>መድረሻ :</strong> {{ $ticket->destination->destination_name }}</p>
        <p><strong>የመነሻ ቀን :</strong> {{ \Carbon\Carbon::parse($ticket->departure_datetime)->format('Y-m-d') }}</p>
        <p><strong>የመሳፈሪያ ሰዓት :</strong> {{ \Carbon\Carbon::parse($ticket->departure_datetime)->format('H:i') }}</p>
        <p><strong>የትኬት መለያ ቁጥር :</strong> {{ $ticket->id }}</p>
        <p><strong>ትኬት ወኪል:</strong> {{ $ticket->creator ? $ticket->creator->name : 'N/A' }}</p>
        <p><strong>ታሪፍ :</strong> {{ $ticket->destination->tariff }}</p>
        <p><strong>ታክስ :</strong> {{ $ticket->destination->tax }}</p>
        <p><strong>አገልግሎት ክፍያ :</strong> {{ $ticket->destination->service_fee }}</p>

        {{-- Display cargo information if available --}}
        @if($ticket->cargo)
            {{-- <p><strong>Cargo Ticket:</strong> {{ $ticket->cargo->cargo_uid }}</p> --}}
            <p><strong>የእቃ ክብደት :</strong> {{ $ticket->cargo->weight }} kg</p>
            <p><strong>የእቃ ክፍያ:</strong> {{ number_format($ticket->cargo->total_amount, 2) }} ETB</p>
        @endif

        <p><strong>አጠቃላይ ክፍያ :</strong>
            {{
                $ticket->destination->tariff +
                $ticket->destination->tax +
                $ticket->destination->service_fee +
                ($ticket->cargo ? $ticket->cargo->total_amount : 0)
            }} ETB
        </p>

        <div class="center barcode">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($ticket->ticket_code, 'C128', 2, 60) }}" alt="barcode" style="max-width: 100%;" />
        </div>

        <div class="center divider"></div>

        <div class="center">
            <p>Thank you for choosing SEBus</p>
        </div>

        <div class="footer-info">
            For additional information or to report a service issue, please call: <strong>0956407670</strong>
        </div>

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
