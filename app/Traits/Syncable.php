<?php

namespace App\Traits;

use App\Services\UuidService;
use App\Models\SyncQueue;

trait Syncable
{
    protected static function bootSyncable()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = $model->generateUuid();
            }
            $model->synced = false;
            $model->last_modified = now();
        });

        static::created(function ($model) {
            $model->addToSyncQueue('create');
        });
    }

    protected function generateUuid(): string
    {
        $type = strtolower(class_basename($this));
        $data = $this->getUuidData();
        return UuidService::generate($type, $data);
    }

    protected function getUuidData(): array
    {
        return [];
    }

    public function addToSyncQueue(string $action): void
    {
        // Ensure UUID exists before adding to sync queue
        if (empty($this->uuid)) {
            $this->uuid = $this->generateUuid();
            $this->save();
        }
        
        $data = $this->getAttributes();
        
        // For User model, ensure password is included
        if (get_class($this) === 'App\Models\User' && isset($this->password)) {
            $data['password'] = $this->password;
        }
        
        // Remove sync-related fields
        unset($data['synced'], $data['synced_at'], $data['last_modified']);
        
        SyncQueue::create([
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'model_uuid' => $this->uuid,
            'action' => $action,
            'data' => $data,
            'synced' => false,
            'retry_count' => 0
        ]);
    }

    public function syncUpdate(): void
    {
        $this->update(['synced' => false, 'last_modified' => now()]);
        $this->addToSyncQueue('update');
    }

    public function syncDelete(): void
    {
        $this->addToSyncQueue('delete');
    }
}