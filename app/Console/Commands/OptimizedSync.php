<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SyncService;
use App\Models\SyncQueue;

class OptimizedSync extends Command
{
    protected $signature = 'sync:optimized';
    protected $description = 'Run optimized sync with priority handling';

    public function handle()
    {
        // Set resource limits
        ini_set('memory_limit', '128M');
        ini_set('max_execution_time', 180);
        
        $syncService = new SyncService();
        
        // Check if system is busy
        if ($this->isSystemBusy()) {
            $this->info('System busy, skipping sync');
            return 0;
        }
        
        try {
            // Sync high priority items first (tickets, cash reports)
            $this->syncPriorityItems($syncService);
            
            // Clear memory
            gc_collect_cycles();
            
            return 0;
        } catch (\Exception $e) {
            $this->error('Optimized sync failed: ' . $e->getMessage());
            return 1;
        }
    }
    
    private function isSystemBusy(): bool
    {
        // Check if there are active user sessions
        $activeUsers = \DB::table('sessions')->where('last_activity', '>', now()->subMinutes(5))->count();
        return $activeUsers > 3; // Skip sync if more than 3 active users
    }
    
    private function syncPriorityItems(SyncService $syncService): void
    {
        // High priority models
        $priorityModels = ['App\\Models\\Ticket', 'App\\Models\\CashReport'];
        
        foreach ($priorityModels as $model) {
            $items = SyncQueue::where('synced', false)
                ->where('model_type', $model)
                ->orderBy('created_at')
                ->limit(2)
                ->get();
                
            if ($items->isNotEmpty()) {
                $this->info("Syncing {$items->count()} {$model} items");
                // Process items individually with delays
                foreach ($items as $item) {
                    try {
                        $syncService->syncPendingData();
                        sleep(2); // 2 second delay
                    } catch (\Exception $e) {
                        $this->error("Failed to sync {$model}: " . $e->getMessage());
                    }
                }
            }
        }
    }
}