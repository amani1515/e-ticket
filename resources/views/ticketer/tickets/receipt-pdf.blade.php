<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt - {{ $ticket->id }}</title>
    <style>
        @font-face {
            font-family: 'Noto Sans Ethiopic';
            src: url('https://fonts.googleapis.com/css2?family=Noto+Sans+Ethiopic:wght@400;700&display=swap');
        }
        body {
            font-family: 'Noto Sans Ethiopic', 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 5px;
            line-height: 1.2;
        }
        .center { text-align: center; font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 3px 0; }
        .logo { max-width: 15mm; height: auto; margin: 0 auto; display: block; }
        h3 { font-size: 12px; margin: 2px 0; }
        p { margin: 1px 0; font-size: 9px; }
        strong { font-weight: bold; }
    </style>
</head>
<body>
    <div class="center">
        <img src="{{ public_path('logo.png') }}" alt="SEBUS Logo" class="logo">
        <h3>E-TICKET</h3>
        @if($ticket->print_count > 1)
            <p style="font-weight: bold; color: red;">*** REPRINTED (COPY) ***</p>
        @endif
        <div class="divider"></div>
    </div>

    <p><strong>ሰሌዳ ቁጥር:</strong> {{ $ticket->bus->targa ?? $ticket->bus_id }}</p>
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
            'Blind / Visual Impairment' => 'ማየት የተሳነው',
            'Deaf / Hard of Hearing' => 'መስማት የተሳነው',
            'Speech Impairment' => 'መናገር የተሳነው',
        ];
    @endphp

    <p><strong>የእድሜ ሁኔታ:</strong> {{ $ageStatusAmharic[$ticket->age_status] ?? $ticket->age_status }}</p>
    <p><strong>የአካል ጉዳት:</strong> {{ $disabilityStatusAmharic[$ticket->disability_status] ?? $ticket->disability_status }}</p>
    <p><strong>መነሻ:</strong> {{ $ticket->destination->start_from }}</p>
    <p><strong>መድረሻ:</strong> {{ $ticket->destination->destination_name }}</p>
    <p><strong>የመነሻ ቀን:</strong> {{ \Carbon\Carbon::parse($ticket->departure_datetime)->format('Y-m-d') }}</p>
    <p><strong>የመሳፈሪያ ሰዓት:</strong> {{ \Carbon\Carbon::parse($ticket->departure_datetime)->format('H:i') }}</p>
    <p><strong>የትኬት መለያ ቁጥር:</strong> {{ $ticket->id }}</p>
    <p><strong>ትኬት ወኪል:</strong> {{ $ticket->creator ? $ticket->creator->name : 'N/A' }}</p>
    <p><strong>የማህበር ስም:</strong> {{ $ticket->bus && $ticket->bus->mahberat ? $ticket->bus->mahberat->name : 'N/A' }}</p>
    <p><strong>ታሪፍ:</strong> {{ $ticket->tariff ?? $ticket->destination->tariff }}</p>
    <p><strong>አገልግሎት ክፍያ:</strong> {{ $ticket->destination->service_fee }}</p>

    @if($ticket->cargo)
        <p><strong>የእቃ ክብደት:</strong> {{ $ticket->cargo->weight }} kg</p>
        <p><strong>የእቃ ክፍያ:</strong> {{ number_format($ticket->cargo->total_amount, 2) }} ብር</p>
    @endif

    <p><strong>አጠቃላይ ክፍያ:</strong> {{ ($ticket->tariff ?? $ticket->destination->tariff) + $ticket->destination->tax + $ticket->destination->service_fee + ($ticket->cargo ? $ticket->cargo->total_amount : 0) }} ብር</p>

    <div class="divider"></div>
    <div class="center">
        <p>ስለመረጡን እናመሰግናለን</p>
        <p>ለአንድ ጊዜ ጉዞ ብቻ የተፈቀደ</p>
        <p>ለተጨማሪ መረጃ: 0956407670</p>
    </div>
</body>
</html>