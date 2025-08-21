<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Syncable;

class Schedule extends Model
{
    use Syncable;
    //
    protected $fillable = [
        'bus_id',
        'schedule_uid',
        'destination_id',
        'scheduled_by',
        'scheduled_at',
        'status',
        'mahberat_id',
        'ticketer_id',
        'capacity',
        'boarding',
        'wellgo_at',
        'mewucha_fee',
        'mewucha_status',
        'traffic_name',
        'uuid',
        'synced',
        'synced_at',
        'last_modified',
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
public function mahberat()
{
    return $this->belongsTo(Mahberat::class);
}

public function ticketer()
{
    return $this->belongsTo(User::class, 'ticketer_id');
}


public function departedBy()
{
    return $this->belongsTo(\App\Models\User::class, 'departed_by');
}

protected function getUuidData(): array
{
    return [
        'mahberat' => $this->mahberat->name ?? 'unknown',
    ];
}
}
