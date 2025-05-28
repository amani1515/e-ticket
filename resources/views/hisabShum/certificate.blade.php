<!-- filepath: resources/views/hisabShum/certificate.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Departed Certificate</title>
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
            .certificate {
                width: 170mm !important;
                min-height: unset !important;
                padding: 20px !important;
                border: 2px solid #333;
                margin: 0 auto !important;
                background: #fff;
                box-sizing: border-box;
            }
            .logo-section .logo {
                height: 40px !important;
            }
            .title {
                font-size: 1.3em !important;
                margin-bottom: 20px !important;
                margin-top: 10px !important;
            }
            .info-table th, .info-table td {
                padding: 4px 6px !important;
                font-size: 0.95em !important;
            }
            .footer {
                margin-top: 30px !important;
            }
        }
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #fff;
        }
        .certificate {
            width: 170mm;
            min-height: unset;
            padding: 20px;
            border: 2px solid #333;
            margin: auto;
            background: #fff;
        }
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .logo-section .logo {
            height: 40px;
        }
        .logo-section .org-info {
            text-align: right;
            font-size: 1em;
        }
        .title {
            text-align: center;
            font-size: 1.3em;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 10px;
        }
        .info {
            margin-bottom: 10px;
            font-size: 1em;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .info-table th, .info-table td {
            border: 1px solid #aaa;
            padding: 4px 6px;
            text-align: left;
            font-size: 0.95em;
        }
        .info-table th {
            background: #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="logo-section">
            <div>
                <img src="{{ asset('logo.png') }}" alt="Sevastopol technologies" class="logo">
            </div>
            <div class="org-info">
                <div><strong>Sevastopol technologies</strong></div>
                <div>e-Ticket System</div>
                <div>www.sevastopoltechs.com</div>
                <div>Tel: +251-956-407-670</div>
            </div>
        </div>
        <div class="title">Departed Certificate</div>
        <table class="info-table">
            <tr>
                <th>Bus Targa</th>
                <td>{{ $schedule->bus->targa ?? '-' }}</td>
            </tr>
            <tr>
                <th>From</th>
                <td>{{ $schedule->from ?? ($schedule->bus->from ?? '-') }}</td>
            </tr>
            <tr>
                <th>To</th>
                <td>{{ $schedule->destination->destination_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Capacity</th>
                <td>{{ $schedule->capacity ?? '-' }}</td>
            </tr>
            <tr>
                <th>Boarding</th>
                <td>{{ $schedule->boarding ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ ucfirst($schedule->status) }}</td>
            </tr>
            <tr>
                <th>Scheduled At</th>
                <td>{{ $schedule->scheduled_at }}</td>
            </tr>
            <tr>
                <th>Departed By</th>
                <td>{{ $schedule->departedBy->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Departed At</th>
                <td>{{ $schedule->departed_at ?? '-' }}</td>
            </tr>
        </table>
        <div>
            This is to certify that the above bus schedule has been marked as <strong>departed</strong>.
        </div>
        <div class="footer">
            <div>Date: {{ now()->format('Y-m-d') }}</div> <br>
            <div>Signature: ____________________</div>
            <br><br>
            <div>Approved by: ____________________</div>
        </div>
        <div style="margin-top:30px; text-align:center;">
            <div style="font-size:1em; margin-bottom:6px;">
                Schedule ID: <strong>{{ $schedule->schedule_uid }}</strong>
            </div>
            <img 
                src="https://barcode.tec-it.com/barcode.ashx?data={{ $schedule->schedule_uid }}&code=Code128&translate-esc=off" 
                alt="Barcode for {{ $schedule->schedule_uid }}" 
                style="margin:auto; display:block; max-width:180px; height:40px;"
            >
            <button class="no-print" onclick="window.print()" style="margin-top:20px;padding:8px 20px;font-size:0.95em;">Print</button>
        </div>
    </div>
</body>
</html>