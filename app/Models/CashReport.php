<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\Syncable;

class CashReport extends Model
{
    use HasFactory;
    use Syncable;

    protected $fillable = [
        'user_id',
        'report_date',
        'total_amount',
        'tax',
        'service_fee',
        'status',
        'submitted_at',
        'received_at',
        'uuid',
        'synced',
        'synced_at',
        'last_modified',
    ];

    // Relationship to User (ticketer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function getUuidData(): array
    {
        return [
            'user_name' => $this->user->name ?? 'unknown',
        ];
    }
}
