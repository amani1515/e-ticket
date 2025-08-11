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

        static::updating(function ($model) {
            $model->synced = false;
            $model->last_modified = now();
        });

        static::created(function ($model) {
            $model->addToSyncQueue('create');
        });

        static::updated(function ($model) {
            $model->addToSyncQueue('update');
        });

        static::deleted(function ($model) {
            $model->addToSyncQueue('delete');
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

    protected function addToSyncQueue(string $action): void
    {
        SyncQueue::create([
            'model_type' => get_class($this),
            'model_id' => $this->id,
            'model_uuid' => $this->uuid,
            'action' => $action,
            'data' => $this->toArray(),
            'synced' => false,
            'retry_count' => 0
        ]);
    }

    public function markAsSynced(): void
    {
        $this->update([
            'synced' => true,
            'synced_at' => now()
        ]);
    }
}