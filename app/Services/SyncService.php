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
            $response = Http::timeout(10)
                ->withHeaders(['User-Agent' => 'E-Ticket-Sync/1.0'])
                ->get($this->remoteUrl . '/api/ping');
            return $response->successful();
        } catch (Exception $e) {
            Log::warning('Connection check failed: ' . $e->getMessage());
            return false;
        }
    }

    public function syncPendingData(): array
    {
        if (!$this->isOnline()) {
            return ['success' => false, 'message' => 'Remote server is not reachable'];
        }

        $batchSize = config('sync.batch_size', 3);
        $pendingItems = SyncQueue::where('synced', false)
            ->orderBy('created_at')
            ->limit($batchSize)
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

        foreach ($pendingItems as $index => $item) {
            try {
                $this->syncItem($item);
                $item->updateQuietly([
                    'synced' => true,
                    'last_attempt' => now(),
                    'error_message' => null
                ]);
                $results['synced']++;
                Log::info('Successfully synced item: ' . $item->id);
                
                // Add delay between items to reduce system load
                if ($index < $pendingItems->count() - 1) {
                    $delay = config('sync.delay_seconds', 3);
                    sleep($delay);
                }
                
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
            
            // Clear memory after each item
            gc_collect_cycles();
        }

        SyncSettings::set('last_sync_attempt', now()->toDateTimeString());
        
        $message = "Synced {$results['synced']} items";
        if ($results['failed'] > 0) {
            $message .= ", {$results['failed']} will retry";
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
        
        if (!is_array($data)) {
            throw new Exception('Invalid data format for sync item');
        }
        
        // Convert datetime fields to proper format
        $dateTimeFields = ['submitted_at', 'departure_datetime', 'scheduled_at', 'wellgo_at', 'cancelled_at', 'received_at'];
        $dateOnlyFields = ['report_date', 'birth_date'];
        
        // Handle datetime fields (Y-m-d H:i:s format)
        foreach ($dateTimeFields as $field) {
            if (isset($data[$field]) && $data[$field]) {
                try {
                    $date = \Carbon\Carbon::parse($data[$field]);
                    $data[$field] = $date->format('Y-m-d H:i:s');
                } catch (Exception $e) {
                    unset($data[$field]);
                }
            }
        }
        
        // Handle date-only fields (Y-m-d format)
        foreach ($dateOnlyFields as $field) {
            if (isset($data[$field]) && $data[$field]) {
                try {
                    $date = \Carbon\Carbon::parse($data[$field]);
                    $data[$field] = $date->format('Y-m-d');
                } catch (Exception $e) {
                    unset($data[$field]);
                }
            }
        }
        
        // Remove problematic fields
        $fieldsToRemove = [
            'created_at', 'updated_at', 'synced', 'synced_at', 'last_modified',
            'two_factor_secret', 'two_factor_recovery_codes',
            'remember_token', 'profile_photo_path', 'current_team_id'
        ];
        
        foreach ($fieldsToRemove as $field) {
            unset($data[$field]);
        }
        
        // Handle User model specific requirements
        if (strpos($item->model_type, 'User') !== false) {
            if ($item->action === 'create' && empty($data['password'])) {
                $data['password'] = 'password123';
            }
            if (empty($data['email_verified_at'])) {
                $data['email_verified_at'] = now()->format('Y-m-d H:i:s');
            }
        }
        
        // Handle CashReport model specific requirements
        if (strpos($item->model_type, 'CashReport') !== false) {
            if (isset($data['report_date'])) {
                $data['report_date'] = \Carbon\Carbon::parse($data['report_date'])->format('Y-m-d');
            }
            if (isset($data['submitted_at'])) {
                $data['submitted_at'] = \Carbon\Carbon::parse($data['submitted_at'])->format('Y-m-d H:i:s');
            }
        }
        
        $payload = [
            'uuid' => $item->model_uuid,
            'action' => $item->action,
            'data' => $data,
            'model_type' => $item->model_type
        ];
        
        Log::info('Syncing item', [
            'id' => $item->id,
            'endpoint' => $this->remoteUrl . $endpoint, 
            'model' => class_basename($item->model_type),
            'uuid' => $item->model_uuid,
            'action' => $item->action,
            'retry_count' => $item->retry_count
        ]);
        
        $timeout = config('sync.timeout', 30);
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiToken,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'User-Agent' => 'E-Ticket-Sync/1.0'
        ])->timeout($timeout)->retry(1, 2000)->post($this->remoteUrl . $endpoint, $payload);

        if (!$response->successful()) {
            $errorBody = $response->body();
            $errorMessage = "HTTP {$response->status()}: {$errorBody}";
            Log::error('Sync API Error', [
                'item_id' => $item->id,
                'status' => $response->status(), 
                'body' => $errorBody,
                'endpoint' => $this->remoteUrl . $endpoint
            ]);
            throw new Exception($errorMessage);
        }
        
        $responseData = $response->json();
        Log::info('Sync successful', [
            'item_id' => $item->id,
            'response' => $responseData
        ]);
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
            $retrying = SyncQueue::where('synced', false)
                ->where('retry_count', '>', 0)
                ->count();
            
            return [
                'online' => $this->isOnline(),
                'pending' => $pending,
                'failed' => $retrying,
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