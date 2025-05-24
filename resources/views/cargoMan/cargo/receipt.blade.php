{{-- filepath: resources/views/cargoMan/cargo/receipt.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cargo Receipt</title>
    <style>
        body {
            background: #fff;
            color: #000;
            font-family: Arial, sans-serif;
        }
        .receipt-container {
            max-width: 350px;
            margin: 0 auto;
            padding: 16px;
            border: 1px dashed #333;
            text-align: center;
        }
        .receipt-container h2 {
            font-size: 1.3em;
            margin-bottom: 1em;
        }
        .receipt-container .mb-2 {
            margin-bottom: 0.5em;
            font-size: 1em;
        }
        .receipt-container .barcode {
            margin: 1em 0;
        }
       @media print {
    .receipt-container {
        box-shadow: none !important;
        border: none !important;
    }
    .no-print {
        display: none !important;
    }
}
    </style>
</head>
<body>
<div class="receipt-container">
    <h2>Cargo Receipt</h2>
    <div class="mb-2"><strong>Receipt No:</strong> {{ $cargo->cargo_uid }}</div>
    <div class="mb-2"><strong>Bus:</strong> {{ $cargo->bus->targa ?? '-' }}</div>
    <div class="mb-2"><strong>Destination:</strong> {{ $cargo->destination->destination_name ?? '-' }}</div>
    <div class="mb-2"><strong>Schedule:</strong> {{ $cargo->schedule->schedule_uid ?? '-' }}</div>
    <div class="mb-2"><strong>Weight:</strong> {{ $cargo->weight }} kg</div>
    <div class="mb-2"><strong>Service Fee:</strong> {{ number_format($cargo->service_fee, 2) }}</div>
    <div class="mb-2"><strong>Tax:</strong> {{ number_format($cargo->tax, 2) }}</div>
    <div class="mb-2"><strong>Total Amount:</strong> <span class="font-bold text-lg">{{ number_format($cargo->total_amount, 2) }}</span></div>
   <div class="barcode">
    {!! DNS1D::getBarcodeHTML($cargo->cargo_uid, 'C128', 1.2, 35) !!}
    <div style="font-size: 1.2em; letter-spacing: 0.2em;">{{ $cargo->cargo_uid }}</div>
</div>
<button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow mt-4 no-print">Print</button>
</div>
<script>
    window.onload = function() {
        window.print();
    };
</script>
</body>
</html>