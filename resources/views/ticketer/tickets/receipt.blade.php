<!DOCTYPE html>
<html>
<head>
    <title>Sevastopol Technologies PLC</title>
<style>
    body {
        margin: 0;
        padding: 0;
        background: #fff;
        font-family: monospace;
        width: 100vw;
        overflow-x: hidden;
    }

    .receipt {
        background: #fff;
        width: 100%;
        padding: 2mm;
        font-size: 10px;
        box-shadow: none;
        margin: 0;
        line-height: 1.1em;
    }

    .center {
        text-align: center;
        font-weight: bold;
        font-size: 18px;
    }

    .barcode {
        margin-top: 4px;
    }

    .divider {
        border-top: 2px dashed #000;
        margin: 3px 0;
    }



    .logo {
        max-width: 15mm;
        height: auto;
        display: block;
        margin: 0 auto 2px auto;
    }

    .footer-info {
        font-size: 14px;
        color: #333;
        margin-top: 3px;
        text-align: center;
    }

    .print-options {
        display: block;
    }
    
    @media print {
        body {
            background: none;
            margin: 0;
            padding: 0;
        }
        
        .print-options {
            display: none !important;
        }

        .receipt {
            box-shadow: none;
            margin: 0;
            padding: 1mm;
            width: 58mm;
            height: auto !important;
            font-size: 12px;
            line-height: 1.0em;
        }

        .barcode img {
            display: block;
            max-width: 100%;
            height: auto;
            max-height: 18mm;
        }

        .logo {
            max-width: 18mm;
            margin-bottom: 1px;
        }

        h3 {
            font-size: 12px;
            margin: 1px 0;
        }

        p {
            margin: 0.3px 0;
            font-size: 10px;
        }
        
        .center {
            font-size: 12px;
        }
        
        .footer-info {
            font-size: 10px;
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
    
    $genderAmharic = [
        'male' => 'ወንድ',
        'female' => 'ሴት',
    ];
    
    function convertToEthiopian($date) {
        $carbonDate = \Carbon\Carbon::parse($date);
        $year = $carbonDate->year;
        $month = $carbonDate->month;
        $day = $carbonDate->day;
        
        $ethiopianYear = $year - 7;
        $newYearDay = ($year % 4 == 0) ? 12 : 11;
        
        if ($month < 9 || ($month == 9 && $day < $newYearDay)) {
            $ethiopianYear--;
        }
        
        $dayOfYear = $carbonDate->dayOfYear;
        $newYearDayOfYear = mktime(0, 0, 0, 9, $newYearDay, $year);
        $newYearDayOfYear = date('z', $newYearDayOfYear) + 1;
        
        if ($dayOfYear >= $newYearDayOfYear) {
            $ethiopianDayOfYear = $dayOfYear - $newYearDayOfYear + 1;
        } else {
            $ethiopianDayOfYear = $dayOfYear + 365 - $newYearDayOfYear + 1;
        }
        
        $ethiopianMonth = intval(($ethiopianDayOfYear - 1) / 30) + 1;
        $ethiopianDay = (($ethiopianDayOfYear - 1) % 30) + 1;
        
        return "{$ethiopianDay}/{$ethiopianMonth}/{$ethiopianYear}";
    }
@endphp

        <div class="center">
            <img src="{{ asset('logo.png') }}" alt="SEBUS Logo" class="logo">
            <h3>E-TICKET</h3>
            @if($ticket->print_count > 1)
                <p style="font-weight: bold; color: red; font-size: 12px;">*** REPRINTED (COPY) ***</p>
            @endif
            <p style="font-size: 10px; margin: 2px 0;"><strong>{{ $ticket->destination->start_from }}</strong> → <strong>{{ $ticket->destination->destination_name }}</strong></p>
            <div class="divider"></div>
        </div>

        <p style="font-size: 14px;"><strong>ሰሌዳ ቁጥር:{{ $ticket->bus->targa ?? $ticket->bus_id }}</strong> </p>
        <pv ><strong >የተጓዥ ስም:</strong> {{ $ticket->passenger_name }}</pv>
        <p><strong>ጾታ:</strong> {{ $genderAmharic[$ticket->gender] ?? ucfirst($ticket->gender) }}</p>
        <p><strong>ፋይዳ ቁጥር:</strong> {{ $ticket->fayda_id }}</p>
        <p><strong>የተጓዥ ስልክ:</strong> {{ $ticket->phone_no }}</p>

<p><strong>የእድሜ ሁኔታ :</strong> {{ $ageStatusAmharic[$ticket->age_status] ?? $ticket->age_status }}</p>
        <p><strong>  የአካል ጉዳት  :</strong>  {{ $disabilityStatusAmharic[$ticket->disability_status] ?? $ticket->disability_status }}</p>

        <p><strong>መነሻ :</strong> {{ $ticket->destination->start_from }}</p>
        <p><strong>መድረሻ :</strong> {{ $ticket->destination->destination_name }}</p>
        <p><strong>የመነሻ ቀን :</strong> {{ convertToEthiopian($ticket->departure_datetime) }}</p>
        <p><strong>የመሳፈሪያ ሰዓት :</strong> {{ \Carbon\Carbon::parse($ticket->departure_datetime)->subHours(6)->format('H:i') }}</p>
        <p><strong>የትኬት መለያ ቁጥር :</strong> {{ $ticket->id }}</p>
        <p><strong>የማህበር ስም:</strong> 
            {{ $ticket->bus && $ticket->bus->mahberat ? $ticket->bus->mahberat->name : 'N/A' }}
        </p>
        <p><strong>ትኬት ወኪል:</strong> {{ $ticket->creator ? $ticket->creator->name : 'N/A' }}</p>

        <p><strong>ታሪፍ :</strong> {{ $ticket->destination->tariff }}</p>
        {{-- <p><strong>ታክስ :</strong> {{ $ticket->destination->tax }}</p> --}}
        <p><strong>የአገልግሎት ክፍያ :</strong> {{ $ticket->destination->service_fee }}</p>

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
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($ticket->ticket_code, 'C128', 3, 80) }}" alt="barcode" style="max-width: 100%;" />
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

    <!-- Print Button -->
    <div class="print-options" style="text-align: center; margin: 20px 0; background: #28a745; padding: 25px; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
        <button onclick="printReceipt()" 
           style="background: #fff; color: #28a745; border: none; padding: 20px 40px; border-radius: 12px; font-size: 18px; font-weight: bold; cursor: pointer; box-shadow: 0 3px 6px rgba(0,0,0,0.3); transition: all 0.3s ease; margin-right: 10px;">
            🖨️ ህትመት / PRINT
        </button>
        <button onclick="goBackToCreate()" 
           style="background: #007bff; color: #fff; border: none; padding: 20px 40px; border-radius: 12px; font-size: 18px; font-weight: bold; cursor: pointer; box-shadow: 0 3px 6px rgba(0,0,0,0.3); transition: all 0.3s ease;">
            ← Create New Ticket
        </button>
        <p style="margin: 15px 0 0 0; color: #fff; font-size: 16px; font-weight: bold;">Print Receipt or Create New Ticket</p>
    </div>

    <script>
    function printReceipt() {
        window.print();
        
        // Refresh page after print dialog closes to show REPRINTED text
        setTimeout(function() {
            window.location.reload();
        }, 1000);
    }
    
    function goBackToCreate() {
        // Force refresh of create page by adding timestamp
        window.location.href = '{{ route("ticketer.tickets.create") }}?refresh=' + Date.now();
    }
    </script>

</body>
</html>
