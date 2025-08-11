<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyncQueue extends Model
{
    protected $table = 'sync_queue';
    
    protected $fillable = [
        'model_type',
        'model_id',
        'model_uuid',
        'action',
        'data',
        'synced',
        'retry_count',
        'last_attempt',
        'error_message'
    ];

    protected $casts = [
        'data' => 'array',
        'synced' => 'boolean',
        'last_attempt' => 'datetime'
    ];
}