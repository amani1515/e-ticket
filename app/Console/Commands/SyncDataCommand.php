<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SyncService;
use App\Models\SyncQueue;
use Exception;

class SyncDataCommand extends Command
{
    protected $signature = 'sync:data {--retry-failed : Retry failed items}';
    protected $description = 'Sync pending data to remote server in background';

    public function handle()
    {
        try {
            $syncService = new SyncService();
            
            // Retry failed items if requested
            if ($this->option('retry-failed')) {
                $this->retryFailedItems();
            }
            
            // Sync pending data
            $results = $syncService->syncPendingData();
            
            $successCount = $results['success'] ?? 0;
            $failedCount = $results['failed'] ?? 0;
            $totalCount = $results['total'] ?? 0;
            
            if ($totalCount > 0) {
                $this->info("Sync completed: {$successCount} successful, {$failedCount} failed");
            }
            
            return 0;
        } catch (Exception $e) {
            $this->error('Sync failed: ' . $e->getMessage());
            return 1;
        }
    }
    
    private function retryFailedItems()
    {
        $retryCount = SyncQueue::where('synced', false)
            ->where('retry_count', '>=', 3)
            ->update([
                'retry_count' => 0,
                'error_message' => null,
                'last_attempt' => null
            ]);
            
        if ($retryCount > 0) {
            $this->info("Reset {$retryCount} failed items for retry");
        }
    }
}
