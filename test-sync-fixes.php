<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Sync Fixes...\n";
echo "====================\n\n";

use App\Models\SyncQueue;
use App\Models\User;
use App\Models\Ticket;

// Test 1: Check failed items data
echo "1. Checking failed User sync data...\n";
$failedUser = SyncQueue::where('model_type', 'App\Models\User')
    ->where('synced', false)
    ->first();

if ($failedUser) {
    $data = $failedUser->data;
    echo "User data includes password: " . (isset($data['password']) ? 'YES' : 'NO') . "\n";
    echo "Password length: " . (isset($data['password']) ? strlen($data['password']) : 'N/A') . "\n";
    echo "Email: " . ($data['email'] ?? 'N/A') . "\n";
    echo "UUID: " . $failedUser->model_uuid . "\n";
}

echo "\n";

// Test 2: Create a test ticket update
echo "2. Testing ticket update sync...\n";
$ticket = Ticket::first();
if ($ticket) {
    echo "Original ticket status: " . $ticket->ticket_status . "\n";
    
    // Update ticket
    $ticket->update(['ticket_status' => 'confirmed']);
    
    echo "Updated ticket status: " . $ticket->ticket_status . "\n";
    
    // Check if sync queue entry was created
    $syncEntry = SyncQueue::where('model_type', 'App\Models\Ticket')
        ->where('model_id', $ticket->id)
        ->where('action', 'update')
        ->where('synced', false)
        ->latest()
        ->first();
    
    echo "Sync queue entry created: " . ($syncEntry ? 'YES' : 'NO') . "\n";
    if ($syncEntry) {
        echo "Sync entry UUID: " . $syncEntry->model_uuid . "\n";
    }
}

echo "\n";

// Test 3: Check sync queue counts
echo "3. Current sync queue status...\n";
$pending = SyncQueue::where('synced', false)->where('retry_count', '<', 3)->count();
$failed = SyncQueue::where('synced', false)->where('retry_count', '>=', 3)->count();
$synced = SyncQueue::where('synced', true)->count();

echo "Pending: {$pending}\n";
echo "Failed: {$failed}\n";
echo "Synced: {$synced}\n";

echo "\nTest completed!\n";
?>