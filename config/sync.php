<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Remote Server Configuration
    |--------------------------------------------------------------------------
    */
    'remote_url' => env('SYNC_REMOTE_URL', 'https://eticket.capitalltechs.com'),
    
    /*
    |--------------------------------------------------------------------------
    | API Authentication
    |--------------------------------------------------------------------------
    */
    'api_token' => env('SYNC_API_TOKEN', 'your-secure-api-token'),
    
    /*
    |--------------------------------------------------------------------------
    | Sync Settings
    |--------------------------------------------------------------------------
    */
    'sync_interval' => env('SYNC_INTERVAL', 300), // 5 minutes
    'batch_size' => env('SYNC_BATCH_SIZE', 50),
    'max_retries' => env('SYNC_MAX_RETRIES', 3),
    
    /*
    |--------------------------------------------------------------------------
    | Models to Sync
    |--------------------------------------------------------------------------
    */
    'syncable_models' => [
        'App\Models\User',
        'App\Models\Ticket',
        'App\Models\Schedule',
        'App\Models\Bus',
        'App\Models\CashReport',
        'App\Models\Destination',
        'App\Models\Mahberat',
        'App\Models\Cargo',
    ],
];