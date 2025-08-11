<?php

// Simple test to check if sync components work
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Sync Components...\n";
echo "==========================\n\n";

try {
    // Test 1: Check if SyncService can be instantiated
    echo "1. Testing SyncService...\n";
    $syncService = new App\Services\SyncService();
    echo "✅ SyncService created successfully\n\n";
    
    // Test 2: Check if we can get sync status
    echo "2. Testing getSyncStatus...\n";
    $status = $syncService->getSyncStatus();
    echo "✅ Status retrieved: " . json_encode($status) . "\n\n";
    
    // Test 3: Check if SyncQueue model works
    echo "3. Testing SyncQueue model...\n";
    $count = App\Models\SyncQueue::count();
    echo "✅ SyncQueue count: {$count}\n\n";
    
    // Test 4: Check if SyncSettings model works
    echo "4. Testing SyncSettings model...\n";
    App\Models\SyncSettings::set('test_key', 'test_value');
    $value = App\Models\SyncSettings::get('test_key');
    echo "✅ SyncSettings test: {$value}\n\n";
    
    echo "All tests passed! Sync page should work now.\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
?>