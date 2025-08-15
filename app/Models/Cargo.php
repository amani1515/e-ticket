<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Syncable;

class Cargo extends Model
{
    use Syncable;
    protected $fillable = [
        'cargo_uid',
        'bus_id',
        'schedule_id',
        'destination_id',
        'measured_by',
        'weight',
        'service_fee',
        'tax',
        'total_amount',
        'status',
        'uuid',
        'synced',
        'synced_at',
        'last_modified',
    ];

    // Add these relationships
    public function bus()
    {
        return $this->belongsTo(\App\Models\Bus::class);
    }

    public function schedule()
    {
        return $this->belongsTo(\App\Models\Schedule::class);
    }

    public function destination()
    {
        return $this->belongsTo(\App\Models\Destination::class);
    }

    protected function getUuidData(): array
    {
        return [
            'destination' => $this->destination->destination_name ?? 'unknown',
        ];
    }
}