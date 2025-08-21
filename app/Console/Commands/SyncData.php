<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SyncService;
use App\Models\SyncSettings;

class SyncData extends Command
{
    protected $signature = 'sync:data {--continuous : Run continuously}';
    protected $description = 'Sync pending data to remote server';

    public function handle()
    {
        $syncService = new SyncService();
        
        if ($this->option('continuous')) {
            $this->info('Starting continuous sync process...');
            
            while (true) {
                try {
                    if (SyncSettings::get('auto_sync_enabled', false)) {
                        $results = $syncService->syncPendingData();
                        
                        if ($results['synced'] > 0 || $results['failed'] > 0) {
                            $this->info($results['message']);
                        }
                    }
                    
                    $interval = SyncSettings::get('auto_sync_interval', 300);
                    sleep($interval);
                    
                } catch (\Exception $e) {
                    $this->error('Sync error: ' . $e->getMessage());
                    sleep(60); // Wait 1 minute on error
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
    }
}