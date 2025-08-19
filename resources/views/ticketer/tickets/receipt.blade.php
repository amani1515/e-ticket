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
    }

    .receipt {
        background: #fff;
        width: 58mm;
        padding: 2mm;
        font-size: 7px;
        box-shadow: none;
        margin: 0 auto;
        line-height: 1.1em;
    }

    .center {
        text-align: center;
        font-weight: bold;
    }

    .barcode {
        margin-top: 4px;
    }

    .divider {
        border-top: 1px dashed #000;
        margin: 3px 0;
    }

    .buttons {
        margin-top: 12px;
        text-align: center;
    }

    .btn {
        background-color: #4CAF50;
        color: white;
        padding: 8px 16px;
        font-size: 13px;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        margin-right: 5px;
    }

    .btn-back {
        background-color: #f44336;
    }

    .btn:hover {
        opacity: 0.8;
    }

    .logo {
        max-width: 15mm;
        height: auto;
        display: block;
        margin: 0 auto 2px auto;
    }

    .footer-info {
        font-size: 6px;
        color: #333;
        margin-top: 3px;
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
            padding: 1mm;
            width: 58mm;
            height: auto !important;
            font-size: 6px;
            line-height: 1.0em;
        }

        .barcode img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        .logo {
            max-width: 12mm;
            margin-bottom: 1px;
        }

        h3 {
            font-size: 9px;
            margin: 1px 0;
        }

        p {
            margin: 0.5px 0;
        }

        @page {
            size: 58mm 200mm;
            margin: 0;
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

        <p><strong style="font-size: 1.4em;">ሰሌዳ ቁጥር:{{ $ticket->bus->targa ?? $ticket->bus_id }}</strong> </p>
        <p><strong>የተጓዥ ስም:</strong> {{ $ticket->passenger_name }}</p>
        <p><strong>ጾታ:</strong> {{ ucfirst($ticket->gender) }}</p>
        <p><strong>ፋይዳ ቁጥር:</strong> {{ $ticket->fayda_id }}</p>
        <p><strong>የተጓዥ ስልክ:</strong> {{ $ticket->phone_no }}</p>
@php
    $ageStatusAmharic = [
        'baby' => 'ህጻን',
        'adult' => 'ወጣት',
        'middle_aged' => 'ጎልማሳ',
        'senior' => 'ሽማግሌ',
    ];

    $disabilityStatusAmharic = [
        'None' => 'የለም',
        'Blind / Visual Impairment' => 'ማየት የተሳነው ',
        'Deaf / Hard of Hearing' => 'መስማት የተሳነው',
        'Speech Impairment' => 'መናገር የተሳነው', 
    ];
@endphp

<p><strong>የእድሜ ሁኔታ :</strong> {{ $ageStatusAmharic[$ticket->age_status] ?? $ticket->age_status }}</p>
        <p><strong>  የአካል ጉዳት  :</strong>  {{ $disabilityStatusAmharic[$ticket->disability_status] ?? $ticket->disability_status }}</p>

        <p><strong>መነሻ :</strong> {{ $ticket->destination->start_from }}</p>
        <p><strong>መድረሻ :</strong> {{ $ticket->destination->destination_name }}</p>
        <p><strong>የመነሻ ቀን :</strong> {{ \Carbon\Carbon::parse($ticket->departure_datetime)->format('Y-m-d') }}</p>
        <p><strong>የመሳፈሪያ ሰዓት :</strong> {{ \Carbon\Carbon::parse($ticket->departure_datetime)->format('H:i') }}</p>
        <p><strong>የትኬት መለያ ቁጥር :</strong> {{ $ticket->id }}</p>
        <p><strong>ትኬት ወኪል:</strong> {{ $ticket->creator ? $ticket->creator->name : 'N/A' }}</p>
        <p><strong>የማህበር ስም:</strong> 
            {{ $ticket->bus && $ticket->bus->mahberat ? $ticket->bus->mahberat->name : 'N/A' }}
        </p>

        <p><strong>ታሪፍ :</strong> {{ $ticket->destination->tariff }}</p>
        {{-- <p><strong>ታክስ :</strong> {{ $ticket->destination->tax }}</p> --}}
        <p><strong>አገልግሎት ክፍያ :</strong> {{ $ticket->destination->service_fee }}</p>

        {{-- Display cargo information if available --}}
        @if($ticket->cargo)
            {{-- <p><strong>Cargo Ticket:</strong> {{ $ticket->cargo->cargo_uid }}</p> --}}
            <p><strong>የእቃ ክብደት :</strong> {{ $ticket->cargo->weight }} kg</p>
            <p><strong>የእቃ ክፍያ:</strong> {{ number_format($ticket->cargo->total_amount, 2) }} ብር </p>
        @endif

        <p><strong>አጠቃላይ ክፍያ :</strong>
            {{
                $ticket->destination->tariff +
                $ticket->destination->tax +
                $ticket->destination->service_fee +
                ($ticket->cargo ? $ticket->cargo->total_amount : 0)
            }} ብር 
        </p>

        <div class="center barcode">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($ticket->ticket_code, 'C128', 2, 60) }}" alt="barcode" style="max-width: 100%;" />
        </div>

        <div class="center divider"></div>

        <div class="center">
            <p>ስለመረጡን እናመሰግናለን</p>
            <p>ለአንድ ጊዜ ጉዞ ብቻ የተፈቀደ </p>

        </div>

        <div class="footer-info">
            ለተጨማሪ መረጃ ወይም የአገልግሎት ጉድለት ለማመልከት እባኮትን ይደውሉ: <strong>0956407670</strong>
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
