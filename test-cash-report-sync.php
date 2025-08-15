<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Cash Report Sync Fix...\n";
echo "===============================\n\n";

use App\Models\SyncQueue;

// Find failed cash report sync
$failedCashReport = SyncQueue::where('model_type', 'App\Models\CashReport')
    ->where('synced', false)
    ->first();

if ($failedCashReport) {
    echo "Found failed cash report sync:\n";
    echo "UUID: " . $failedCashReport->model_uuid . "\n";
    echo "Error: " . $failedCashReport->error_message . "\n\n";
    
    $data = $failedCashReport->data;
    echo "Original data:\n";
    echo "report_date: " . ($data['report_date'] ?? 'N/A') . "\n";
    echo "submitted_at: " . ($data['submitted_at'] ?? 'N/A') . "\n\n";
    
    // Fix the date formats
    if (isset($data['report_date'])) {
        $data['report_date'] = \Carbon\Carbon::parse($data['report_date'])->format('Y-m-d');
    }
    if (isset($data['submitted_at'])) {
        $data['submitted_at'] = \Carbon\Carbon::parse($data['submitted_at'])->format('Y-m-d H:i:s');
    }
    
    // Update the sync queue with fixed data
    $failedCashReport->update([
        'data' => $data,
        'retry_count' => 0,
        'error_message' => null
    ]);
    
    echo "Fixed data:\n";
    echo "report_date: " . ($data['report_date'] ?? 'N/A') . "\n";
    echo "submitted_at: " . ($data['submitted_at'] ?? 'N/A') . "\n\n";
    
    echo "Cash report sync data fixed and ready for retry!\n";
} else {
    echo "No failed cash report sync found.\n";
}
?>