<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
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
}