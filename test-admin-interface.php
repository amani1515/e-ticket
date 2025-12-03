<?php

// Simple test to simulate admin send functionality
$testData = [
    'tickets' => [
        ['id' => 1, 'passenger_name' => 'John Doe', 'phone' => '0911234567'],
        ['id' => 2, 'passenger_name' => 'Jane Smith', 'phone' => '0922345678']
    ],
    'buses' => [
        ['id' => 1, 'targa' => 'AA-12345', 'level' => 'level1', 'capacity' => 45],
        ['id' => 2, 'targa' => 'BB-67890', 'level' => 'level2', 'capacity' => 50]
    ],
    'schedules' => [
        ['id' => 1, 'from' => 'Addis Ababa', 'to' => 'Bahir Dar', 'departure' => '2025-01-01 08:00:00']
    ]
];

echo "Testing Admin Send to Transport Authority...\n\n";

$postData = [
    'type' => 'all',
    'date' => '2025-01-01',
    'csv_data' => json_encode($testData),
    'api_key' => 'transport-authority-2025-secure-key'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8001/api/upload-csv');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Response (HTTP $httpCode): $response\n\n";

if ($httpCode === 200) {
    echo "✅ SUCCESS: Data sent to Transport Authority!\n";
    echo "📊 Data included:\n";
    echo "   - Tickets: " . count($testData['tickets']) . "\n";
    echo "   - Buses: " . count($testData['buses']) . "\n";
    echo "   - Schedules: " . count($testData['schedules']) . "\n\n";
    echo "🌐 Check the web interface at: http://127.0.0.1:8001/\n";
} else {
    echo "❌ FAILED: Could not send data\n";
}
?>