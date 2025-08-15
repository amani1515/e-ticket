<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Sync Functionality...\n";
echo "=============================\n\n";

use App\Services\SyncService;
use App\Models\SyncQueue;

try {
    $syncService = new SyncService();
    
    // Test 1: Check connection
    echo "1. Testing connection to remote server...\n";
    $isOnline = $syncService->isOnline();
    echo $isOnline ? "✅ Remote server is reachable\n" : "❌ Remote server is not reachable\n";
    echo "\n";
    
    // Test 2: Check pending items
    echo "2. Checking pending sync items...\n";
    $pendingCount = SyncQueue::where('synced', false)->count();
    echo "Pending items: {$pendingCount}\n";
    
    if ($pendingCount > 0) {
        $items = SyncQueue::where('synced', false)->limit(3)->get();
        foreach ($items as $item) {
            echo "- {$item->model_type} ({$item->action}): {$item->model_uuid}\n";
        }
    }
    echo "\n";
    
    // Test 3: Check API token
    echo "3. Checking API configuration...\n";
    $remoteUrl = config('sync.remote_url') ?? env('SYNC_REMOTE_URL');
    $apiToken = config('sync.api_token') ?? env('SYNC_API_TOKEN');
    
    echo "Remote URL: {$remoteUrl}\n";
    echo "API Token: " . substr($apiToken, 0, 20) . "...\n";
    echo "\n";
    
    // Test 4: Try sync if online and has pending items
    if ($isOnline && $pendingCount > 0) {
        echo "4. Testing sync operation...\n";
        $results = $syncService->syncPendingData();
        echo "Sync results: " . json_encode($results, JSON_PRETTY_PRINT) . "\n";
    } else {
        echo "4. Skipping sync test (offline or no pending items)\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>