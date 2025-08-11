<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Test API connection
$remoteUrl = 'https://eticket.capitalltechs.com';
$apiToken = 'SYNC_eef1dd558c848693a001821fd4d2072bb296fdd6c1911a53cccea3c7c9cbd1bf';

echo "Testing API Connection...\n";
echo "========================\n\n";

// Test 1: Ping endpoint
echo "1. Testing ping endpoint:\n";
try {
    $response = Http::timeout(10)->get($remoteUrl . '/api/ping');
    if ($response->successful()) {
        echo "✅ Ping successful: " . $response->json()['status'] . "\n";
    } else {
        echo "❌ Ping failed: " . $response->status() . "\n";
    }
} catch (Exception $e) {
    echo "❌ Ping error: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: API authentication
echo "2. Testing API authentication:\n";
try {
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiToken,
        'Content-Type' => 'application/json'
    ])->post($remoteUrl . '/api/sync/user', [
        'uuid' => 'TEST-USR-123456789-ABC123',
        'action' => 'create',
        'data' => [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'uuid' => 'TEST-USR-123456789-ABC123'
        ]
    ]);
    
    if ($response->successful()) {
        echo "✅ API authentication successful\n";
    } else {
        echo "❌ API authentication failed: " . $response->status() . " - " . $response->body() . "\n";
    }
} catch (Exception $e) {
    echo "❌ API error: " . $e->getMessage() . "\n";
}

echo "\n";
echo "Test completed!\n";
?>