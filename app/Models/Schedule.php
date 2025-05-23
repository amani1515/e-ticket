<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $fillable = [
        'bus_id',
            'schedule_uid',

        'destination_id',
        'scheduled_by',
        'scheduled_at',
        'status',
        'created_at',

        'updated_at',
        'capacity',
        'boarding',
        'wellgo_at',
        'traffic_name',
        // add any other fields you are submitting
    ];
    public function bus()
{
    return $this->belongsTo(Bus::class);
}

public function destination()
{
    return $this->belongsTo(Destination::class);
}

public function scheduler()
{
    return $this->belongsTo(User::class, 'scheduled_by');
}
public function scheduledBy()
{
    return $this->belongsTo(User::class, 'scheduled_by');
}

public function tickets()
{
    return $this->hasMany(\App\Models\Ticket::class);
}
public function paidBy()
{
    return $this->belongsTo(\App\Models\User::class, 'paid_by');
}

public function departedBy()
{
    return $this->belongsTo(\App\Models\User::class, 'departed_by');
}
}
