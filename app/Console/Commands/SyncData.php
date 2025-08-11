<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SyncService;

class SyncData extends Command
{
    protected $signature = 'sync:data {--force : Force sync even if offline}';
    protected $description = 'Sync local data with remote server';

    public function handle()
    {
        $syncService = new SyncService();
        
        $this->info('Starting data synchronization...');
        
        if (!$syncService->isOnline() && !$this->option('force')) {
            $this->warn('Remote server is not reachable. Sync cancelled.');
            return 1;
        }
        
        $results = $syncService->syncPendingData();
        
        $this->info("Sync completed:");
        $this->info("- Total items: {$results['total']}");
        $this->info("- Successful: {$results['success']}");
        $this->info("- Failed: {$results['failed']}");
        
        if ($results['failed'] > 0) {
            $this->warn("Some items failed to sync. Check logs for details.");
        }
        
        return 0;
    }
}