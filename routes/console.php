<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\SyncData;
use App\Console\Commands\BackgroundSync;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Register sync command
Artisan::command('sync:data {--continuous : Run continuously}', function () {
    $syncService = new \App\Services\SyncService();
    
    if ($this->option('continuous')) {
        $this->info('Starting continuous sync process...');
        
        while (true) {
            try {
                if (\App\Models\SyncSettings::get('auto_sync_enabled', false)) {
                    $results = $syncService->syncPendingData();
                    
                    if ($results['synced'] > 0 || $results['failed'] > 0) {
                        $this->info($results['message']);
                    }
                }
                
                $interval = \App\Models\SyncSettings::get('auto_sync_interval', 300);
                sleep($interval);
                
            } catch (\Exception $e) {
                $this->error('Sync error: ' . $e->getMessage());
                sleep(60);
            }
        }
    } else {
        $results = $syncService->syncPendingData();
        $this->info($results['message']);
        
        if (!empty($results['errors'])) {
            foreach ($results['errors'] as $error) {
                $this->error($error);
            }
        }
    }
})->purpose('Sync pending data to remote server');

// Background sync command
Artisan::command('sync:background', function () {
    $command = new BackgroundSync();
    return $command->handle();
})->purpose('Run background sync (called every minute)');
