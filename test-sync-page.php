<?php

// Quick test to create some sync queue entries for testing
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\SyncQueue;
use App\Services\UuidService;

echo "Creating test sync queue entries...\n";

// Create some test entries
$testEntries = [
    [
        'model_type' => 'App\Models\User',
        'model_id' => 1,
        'model_uuid' => UuidService::generate('user', ['usertype' => 'admin']),
        'action' => 'create',
        'data' => ['name' => 'Test Admin', 'email' => 'admin@test.com'],
        'synced' => false,
        'retry_count' => 0
    ],
    [
        'model_type' => 'App\Models\Ticket',
        'model_id' => 1,
        'model_uuid' => UuidService::generate('ticket', ['destination' => 'Addis']),
        'action' => 'create',
        'data' => ['passenger_name' => 'John Doe', 'destination_id' => 1],
        'synced' => true,
        'retry_count' => 0
    ],
    [
        'model_type' => 'App\Models\Schedule',
        'model_id' => 1,
        'model_uuid' => UuidService::generate('schedule', ['mahberat' => 'Test']),
        'action' => 'update',
        'data' => ['status' => 'departed'],
        'synced' => false,
        'retry_count' => 2,
        'error_message' => 'Connection timeout'
    ]
];

foreach ($testEntries as $entry) {
    SyncQueue::create($entry);
    echo "Created: {$entry['model_type']} - {$entry['action']}\n";
}

echo "\nTest entries created! Now visit: /admin/sync\n";
?>