<?php

namespace App\Services;

use App\Models\SyncQueue;
use App\Models\SyncSettings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SyncService
{
    private string $remoteUrl;
    private string $apiToken;

    public function __construct()
    {
        $this->remoteUrl = config('sync.remote_url', 'https://eticket.capitalltechs.com');
        $this->apiToken = config('sync.api_token', 'your-api-token');
    }

    public function isOnline(): bool
    {
        try {
            $response = Http::timeout(5)->get($this->remoteUrl . '/api/ping');
            return $response->successful();
        } catch (Exception $e) {
            return false;
        }
    }

    public function syncPendingData(): array
    {
        if (!$this->isOnline()) {
            return ['success' => false, 'message' => 'No internet connection'];
        }

        $pendingItems = SyncQueue::where('synced', false)
            ->where('retry_count', '<', 3)
            ->orderBy('created_at')
            ->limit(50)
            ->get();

        $results = [
            'success' => 0,
            'failed' => 0,
            'total' => $pendingItems->count()
        ];

        foreach ($pendingItems as $item) {
            try {
                $this->syncItem($item);
                $item->update([
                    'synced' => true,
                    'last_attempt' => now()
                ]);
                $results['success']++;
            } catch (Exception $e) {
                $item->update([
                    'retry_count' => $item->retry_count + 1,
                    'last_attempt' => now(),
                    'error_message' => $e->getMessage()
                ]);
                $results['failed']++;
                Log::error('Sync failed for item ' . $item->id . ': ' . $e->getMessage());
            }
        }

        SyncSettings::set('last_sync_attempt', now()->toDateTimeString());
        
        return $results;
    }

    private function syncItem(SyncQueue $item): void
    {
        $endpoint = $this->getEndpoint($item->model_type, $item->action);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json'
        ])->post($this->remoteUrl . $endpoint, [
            'uuid' => $item->model_uuid,
            'action' => $item->action,
            'data' => $item->data,
            'model_type' => $item->model_type
        ]);

        if (!$response->successful()) {
            throw new Exception('API request failed: ' . $response->body());
        }
    }

    private function getEndpoint(string $modelType, string $action): string
    {
        $model = strtolower(class_basename($modelType));
        return "/api/sync/{$model}";
    }

    public function getSyncStatus(): array
    {
        $pending = SyncQueue::where('synced', false)->count();
        $failed = SyncQueue::where('synced', false)
            ->where('retry_count', '>=', 3)
            ->count();
        
        return [
            'online' => $this->isOnline(),
            'pending' => $pending,
            'failed' => $failed,
            'last_sync' => SyncSettings::get('last_sync_attempt', 'Never')
        ];
    }
}