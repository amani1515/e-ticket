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
        $this->remoteUrl = config('sync.remote_url') ?? env('SYNC_REMOTE_URL', 'https://eticket.capitalltechs.com');
        $this->apiToken = config('sync.api_token') ?? env('SYNC_API_TOKEN', 'your-api-token');
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
            return ['success' => false, 'message' => 'Remote server is not reachable'];
        }

        $pendingItems = SyncQueue::where('synced', false)
            ->where('retry_count', '<', 3)
            ->orderBy('created_at')
            ->limit(10) // Reduce batch size for testing
            ->get();

        if ($pendingItems->isEmpty()) {
            return ['success' => true, 'message' => 'No pending items to sync', 'total' => 0, 'synced' => 0, 'failed' => 0];
        }

        $results = [
            'success' => true,
            'total' => $pendingItems->count(),
            'synced' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($pendingItems as $item) {
            try {
                $this->syncItem($item);
                $item->updateQuietly([
                    'synced' => true,
                    'last_attempt' => now(),
                    'error_message' => null
                ]);
                $results['synced']++;
            } catch (Exception $e) {
                $item->updateQuietly([
                    'retry_count' => $item->retry_count + 1,
                    'last_attempt' => now(),
                    'error_message' => $e->getMessage()
                ]);
                $results['failed']++;
                $results['errors'][] = $e->getMessage();
                Log::error('Sync failed for item ' . $item->id . ': ' . $e->getMessage());
            }
        }

        SyncSettings::set('last_sync_attempt', now()->toDateTimeString());
        
        $message = "Synced {$results['synced']} items";
        if ($results['failed'] > 0) {
            $message .= ", {$results['failed']} failed";
        }
        $results['message'] = $message;
        
        return $results;
    }

    private function syncItem(SyncQueue $item): void
    {
        $endpoint = $this->getEndpoint($item->model_type);
        
        // Clean and prepare data
        $data = $item->data;
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        
        // Remove problematic fields
        $fieldsToRemove = [
            'created_at', 'updated_at', 'synced', 'synced_at', 'last_modified',
            'email_verified_at', 'two_factor_secret', 'two_factor_recovery_codes',
            'remember_token', 'profile_photo_path', 'current_team_id'
        ];
        
        foreach ($fieldsToRemove as $field) {
            unset($data[$field]);
        }
        
        // Handle User model specific requirements
        if (strpos($item->model_type, 'User') !== false) {
            // Ensure password exists for User creation
            if ($item->action === 'create' && empty($data['password'])) {
                $data['password'] = bcrypt('password123'); // Default password
            } elseif (isset($data['password']) && strlen($data['password']) < 60) {
                $data['password'] = bcrypt($data['password']);
            }
            
            // Ensure required fields exist
            if (empty($data['email_verified_at'])) {
                $data['email_verified_at'] = now()->toDateTimeString();
            }
        }
        
        $payload = [
            'uuid' => $item->model_uuid,
            'action' => $item->action,
            'data' => $data,
            'model_type' => $item->model_type
        ];
        
        Log::info('Syncing item', [
            'endpoint' => $endpoint, 
            'model' => class_basename($item->model_type),
            'uuid' => $item->model_uuid,
            'action' => $item->action
        ]);
        
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ])->timeout(30)->post($this->remoteUrl . $endpoint, $payload);

        if (!$response->successful()) {
            $errorBody = $response->body();
            Log::error('Sync API Error', ['status' => $response->status(), 'body' => $errorBody]);
            throw new Exception('API Error ' . $response->status() . ': ' . $errorBody);
        }
        
        Log::info('Sync successful', ['response' => $response->json()]);
    }

    private function getEndpoint(string $modelType): string
    {
        $model = strtolower(class_basename($modelType));
        
        // Map model names to correct endpoints
        $endpointMap = [
            'cashreport' => 'cash_report',
            'syncqueue' => 'sync_queue'
        ];
        
        $endpoint = $endpointMap[$model] ?? $model;
        return "/api/sync/{$endpoint}";
    }
    
    public function syncBatch(array $items): array
    {
        if (!$this->isOnline()) {
            return ['success' => false, 'message' => 'No internet connection'];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->timeout(60)->post($this->remoteUrl . '/api/sync/batch', [
                'items' => $items
            ]);

            if (!$response->successful()) {
                throw new Exception('Batch sync failed: ' . $response->status() . ' - ' . $response->body());
            }

            return $response->json();
        } catch (Exception $e) {
            Log::error('Batch sync error: ' . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getSyncStatus(): array
    {
        try {
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
        } catch (Exception $e) {
            return [
                'online' => false,
                'pending' => 0,
                'failed' => 0,
                'last_sync' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}