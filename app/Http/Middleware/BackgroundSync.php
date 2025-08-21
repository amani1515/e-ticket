<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\SyncService;
use App\Models\SyncSettings;

class BackgroundSync
{
    private static $lastSync = 0;
    
    public function handle(Request $request, Closure $next)
    {
        // Only run sync every 60 seconds
        if (time() - self::$lastSync >= 60) {
            $this->runBackgroundSync();
            self::$lastSync = time();
        }
        
        return $next($request);
    }
    
    private function runBackgroundSync()
    {
        try {
            $syncService = new SyncService();
            
            // Run sync in background without blocking request
            if (function_exists('fastcgi_finish_request')) {
                fastcgi_finish_request();
            }
            
            $results = $syncService->syncPendingData();
            
            if ($results['synced'] > 0) {
                \Log::info("Auto sync: {$results['message']}");
            }
            
        } catch (\Exception $e) {
            \Log::error('Auto sync failed: ' . $e->getMessage());
        }
    }
}