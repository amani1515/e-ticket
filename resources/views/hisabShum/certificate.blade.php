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
        }
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #fff;
        }
        .certificate {
            width: 210mm;
            min-height: 297mm;
            padding: 40px;
            border: 2px solid #333;
            margin: auto;
            background: #fff;
        }
        .logo-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .logo-section .logo {
            height: 70px;
        }
        .logo-section .org-info {
            text-align: right;
            font-size: 1.1em;
        }
        .title {
            text-align: center;
            font-size: 2em;
            font-weight: bold;
            margin-bottom: 40px;
            margin-top: 20px;
        }
        .info {
            margin-bottom: 20px;
            font-size: 1.1em;
        }
        .footer {
            margin-top: 60px;
            text-align: right;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table th, .info-table td {
            border: 1px solid #aaa;
            padding: 8px 12px;
            text-align: left;
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
                <!-- Replace src with your actual logo path -->
<img src="{{ asset('logo.png') }}" alt="Sevastopol technologies" class="logo">            </div>
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
        </div>
        <button class="no-print" onclick="window.print()" style="margin-top:40px;padding:10px 30px;font-size:1em;">Print</button>
    </div>
</body>
</html>