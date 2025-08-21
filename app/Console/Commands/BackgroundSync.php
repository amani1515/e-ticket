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
        $syncService = new SyncService();
        
        try {
            $results = $syncService->syncPendingData();
            
            if ($results['synced'] > 0) {
                \Log::info("Background sync: {$results['message']}");
            }
            
            return 0;
        } catch (\Exception $e) {
            \Log::error('Background sync failed: ' . $e->getMessage());
            return 1;
        }
    }
}