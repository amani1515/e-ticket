<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Http;

// Test sync connection
$remoteUrl = 'https://eticket.capitalltechs.com';
$apiToken = 'SYNC_eef1dd558c848693a001821fd4d2072bb296fdd6c1911a53cccea3c7c9cbd1bf';

echo "Testing connection to: {$remoteUrl}\n";

try {
    // Test ping endpoint
    $response = Http::timeout(10)
        ->withHeaders(['User-Agent' => 'E-Ticket-Sync/1.0'])
        ->get($remoteUrl . '/api/ping');
    
    if ($response->successful()) {
        echo "✅ Ping successful: " . $response->body() . "\n";
    } else {
        echo "❌ Ping failed: HTTP " . $response->status() . "\n";
        echo "Response: " . $response->body() . "\n";
    }
    
    // Test sync endpoint with sample data
    $testPayload = [
        'uuid' => 'test-uuid-' . time(),
        'action' => 'create',
        'data' => [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'usertype' => 'user'
        ],
        'model_type' => 'App\\Models\\User'
    ];
    
    echo "\nTesting sync endpoint...\n";
    
    $syncResponse = Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiToken,
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
        'User-Agent' => 'E-Ticket-Sync/1.0'
    ])->timeout(30)->post($remoteUrl . '/api/sync/user', $testPayload);
    
    if ($syncResponse->successful()) {
        echo "✅ Sync test successful\n";
        echo "Response: " . $syncResponse->body() . "\n";
    } else {
        echo "❌ Sync test failed: HTTP " . $syncResponse->status() . "\n";
        echo "Response: " . $syncResponse->body() . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Connection error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n";