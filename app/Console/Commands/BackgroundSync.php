<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SyncService;
use App\Models\SyncSettings;

class BackgroundSync extends Command
{
    protected $signature = 'sync:background';
    protected $description = 'Run background sync every minute';

    public function handle()
    {
        // Set memory and time limits for background process
        ini_set('memory_limit', '128M');
        ini_set('max_execution_time', 300);
        
        $syncService = new SyncService();
        
        try {
            $results = $syncService->syncPendingData();
            
            if ($results['synced'] > 0) {
                \Log::info("Background sync: {$results['message']}");
            }
            
            // Clear memory after sync
            gc_collect_cycles();
            
            return 0;
        } catch (\Exception $e) {
            \Log::error('Background sync failed: ' . $e->getMessage());
            return 1;
        }
    }
}