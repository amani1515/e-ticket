<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Debugging Sync Issues...\n";
echo "========================\n\n";

use App\Models\SyncQueue;
use App\Services\SyncService;

// Get failed items
$failedItems = SyncQueue::where('synced', false)
    ->where('retry_count', '>=', 3)
    ->get();

echo "Failed Items Analysis:\n";
echo "---------------------\n";

foreach ($failedItems as $item) {
    echo "Model: " . class_basename($item->model_type) . "\n";
    echo "UUID: " . $item->model_uuid . "\n";
    echo "Action: " . $item->action . "\n";
    echo "Error: " . $item->error_message . "\n";
    echo "Data: " . json_encode($item->data, JSON_PRETTY_PRINT) . "\n";
    echo "---\n";
}

// Test specific endpoints
echo "\nTesting API Endpoints:\n";
echo "---------------------\n";

$syncService = new App\Services\SyncService();
$remoteUrl = config('sync.remote_url') ?? env('SYNC_REMOTE_URL');
$apiToken = config('sync.api_token') ?? env('SYNC_API_TOKEN');

$endpoints = ['user', 'cash_report', 'ticket'];

foreach ($endpoints as $endpoint) {
    echo "Testing /api/sync/{$endpoint}...\n";
    
    try {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiToken,
            'Content-Type' => 'application/json'
        ])->timeout(10)->post($remoteUrl . "/api/sync/{$endpoint}", [
            'uuid' => 'TEST-' . strtoupper($endpoint) . '-123456789-TEST',
            'action' => 'create',
            'data' => ['test' => 'data'],
            'model_type' => 'Test'
        ]);
        
        echo "Status: " . $response->status() . "\n";
        echo "Response: " . $response->body() . "\n";
        
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    echo "---\n";
}
?>