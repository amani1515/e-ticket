<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cash Report Receipt</title>
    <style>
        @media print {
            @page {
                size: 58mm auto;
                margin: 2mm;
            }
            body {
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.3;
            width: 58mm;
            margin: 0 auto;
            padding: 5mm;
            color: #000;
            background: white;
        }
        
        .receipt {
            width: 100%;
        }
        
        .center {
            text-align: center;
        }
        
        .bold {
            font-weight: bold;
        }
        
        .small {
            font-size: 10px;
        }
        
        .section {
            border-top: 1px dashed #000;
            margin: 8px 0;
            padding-top: 8px;
        }
        
        .print-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .back-btn {
            position: fixed;
            top: 10px;
            left: 10px;
            background: #2196F3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <!-- Print and Back buttons -->
    <button class="print-btn no-print" onclick="window.print()">🖨️ Print Receipt</button>
    <a href="{{ route('ticketer.cash-report.list') }}" class="back-btn no-print">← Back to List</a>

    <!-- Receipt Content -->
    <div class="receipt">
        <div class="center">
            <div class="bold">E-TICKET SYSTEM</div>
            <div class="small">Cash Report Receipt</div>
        </div>
        
        <div class="center section">
            <div class="bold" style="font-size: 14px;">CONGRATULATIONS! </div>
            <div class="small">Your cash report has been</div>
            <div class="bold">CONFIRMED</div>
        </div>
        
        <div class="section">
            <div class="bold">REPORT DETAILS</div>
            <div>Report Date: {{ \Carbon\Carbon::parse($report->report_date)->format('M d, Y') }}</div>
            <div>Status: {{ strtoupper($report->status) }}</div>
            <div>Submitted: {{ $report->submitted_at ? \Carbon\Carbon::parse($report->submitted_at)->format('M d, Y H:i') : 'N/A' }}</div>
        </div>
        
        <div class="section">
            <div class="bold">FINANCIAL SUMMARY</div>
            {{-- <div>Total Amount: {{ number_format($report->total_amount, 2) }} Birr</div>
            <div>Tax Amount: {{ number_format($report->tax, 2) }} Birr</div> --}}
            <div>Collected Service Fee: {{ number_format($report->service_fee, 2) }} Birr</div>
        </div>
        
        <div class="section">
            <div class="bold">TICKETER INFO</div>
            <div>Name: {{ auth()->user()->name }}</div>
            <div>ID: {{ auth()->user()->id }}</div>
        </div>
        
        <div class="center section small">
            <div>Thank you for your service!</div>
            <div>Generated: {{ now()->format('M d, Y H:i') }}</div>
        </div>
        
        <div class="center section small">
            <div>Sevastopol technologies PLC © 2025</div>
        </div>
    </div>
</body>
</html>