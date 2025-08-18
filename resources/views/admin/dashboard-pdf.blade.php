<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard Report</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        .pdf-header { text-align: center; margin-bottom: 30px; padding: 20px; border-bottom: 2px solid #333; }
        .pdf-footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; padding: 10px; border-top: 1px solid #ddd; background: white; }
        .logo { width: 80px; height: 80px; margin: 0 auto 10px; }
        .company-name { font-size: 24px; font-weight: bold; color: #333; margin: 10px 0; }
        .header { text-align: center; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { border: 1px solid #ddd; padding: 15px; border-radius: 8px; }
        .stat-title { font-size: 14px; color: #666; margin-bottom: 5px; }
        .stat-value { font-size: 24px; font-weight: bold; color: #333; }
        .stat-desc { font-size: 12px; color: #999; margin-top: 5px; }
        .section { margin-bottom: 30px; }
        .section-title { font-size: 18px; font-weight: bold; margin-bottom: 15px; border-bottom: 2px solid #333; padding-bottom: 5px; }
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table th, .data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .data-table th { background-color: #f5f5f5; font-weight: bold; }
        .data-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .data-label { font-weight: bold; }
        .data-value { color: #666; }
        .content { margin-bottom: 60px; }
    </style>
</head>
<body>
    <div class="pdf-header">
        <img src="{{ public_path('tik1.png') }}" alt="Sevastopol Technologies Logo" class="logo">
        <div class="company-name">Sevastopol Technologies</div>
        <h1>📊 E-Ticket Dashboard Report</h1>
        <p>Generated on: {{ now()->format('F j, Y g:i A') }}</p>
        @if($startDate && $endDate)
            <p>Period: {{ $startDate }} to {{ $endDate }}</p>
        @else
            <p>Period: Today ({{ \Carbon\Carbon::today()->format('F j, Y') }})</p>
        @endif
    </div>

    <div class="content">

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">👥 Passengers Today</div>
            <div class="stat-value">{{ $passengersToday }}</div>
            <div class="stat-desc">Active travelers</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">👤 Total Users</div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-desc">System accounts</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">📍 Total Destinations</div>
            <div class="stat-value">{{ $totalDestinations }}</div>
            <div class="stat-desc">Available routes</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">🏛️ Today's Tax</div>
            <div class="stat-value">{{ number_format($taxTotal, 2) }} ETB</div>
            <div class="stat-desc">Government tax</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">⚙️ Service Fee</div>
            <div class="stat-value">{{ number_format($serviceFeeTotal, 2) }} ETB</div>
            <div class="stat-desc">Platform fee</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">💰 Total Revenue</div>
            <div class="stat-value">{{ number_format($totalRevenue, 2) }} ETB</div>
            <div class="stat-desc">Today's earnings</div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">📈 Gender Distribution</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Gender</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($genderData as $gender => $count)
                <tr>
                    <td>{{ $gender === 'male' ? '♂️ Male' : '♀️ Female' }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ $passengersToday > 0 ? round(($count/$passengersToday)*100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">👶 Age Distribution</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Age Group</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ageData as $age => $count)
                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $age)) }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ $passengersToday > 0 ? round(($count/$passengersToday)*100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">♿ Accessibility Status</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Count</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @foreach($disabilityData as $disability => $count)
                <tr>
                    <td>{{ $disability === 'None' ? '✅' : '♿' }} {{ $disability ?: 'None' }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ $passengersToday > 0 ? round(($count/$passengersToday)*100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">🗺️ Top 5 Destinations</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>Destination</th>
                    <th>Passengers</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                @php $rank = 1; @endphp
                @foreach($destinationData->take(5) as $destination => $count)
                <tr>
                    <td>#{{ $rank++ }}</td>
                    <td>{{ $destination ?: 'Unknown' }}</td>
                    <td>{{ $count }}</td>
                    <td>{{ $passengersToday > 0 ? round(($count/$passengersToday)*100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>

    <div class="pdf-footer">
        <img src="{{ public_path('tik1.png') }}" alt="Sevastopol Technologies Logo" style="width: 30px; height: 30px; vertical-align: middle; margin-right: 10px;">
        <span style="font-size: 12px; color: #666;">© {{ date('Y') }} Sevastopol Technologies. All rights reserved.</span>
    </div>
</body>
</html>