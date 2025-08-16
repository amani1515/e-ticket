<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SyncService;
use App\Models\SyncSettings;

class AutoSyncCommand extends Command
{
    protected $signature = 'sync:auto';
    protected $description = 'Run automatic sync if enabled';

    public function handle()
    {
        $enabled = SyncSettings::get('auto_sync_enabled', false);
        
        if (!$enabled) {
            $this->info('Auto-sync is disabled');
            return;
        }

        $syncService = new SyncService();
        $results = $syncService->syncPendingData();
        
        $this->info("Auto-sync completed: {$results['success']} successful, {$results['failed']} failed");
    }
}