<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

echo "TRANSPORT_API_URL: " . env('TRANSPORT_API_URL') . "\n";
echo "TRANSPORT_API_KEY: " . env('TRANSPORT_API_KEY') . "\n";

// Test the actual HTTP call
use Illuminate\Support\Facades\Http;

try {
    $response = Http::timeout(5)->post(env('TRANSPORT_API_URL') . '/api/upload-csv', [
        'type' => 'test',
        'date' => '2025-01-01',
        'csv_data' => 'test',
        'api_key' => env('TRANSPORT_API_KEY')
    ]);
    
    echo "HTTP Response: " . $response->status() . "\n";
    echo "Response Body: " . $response->body() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}