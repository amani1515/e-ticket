<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
    protected $fillable = [
        'bus_id',
        'destination_id',
        'scheduled_by',
        'scheduled_at',
        'status',
        'created_at',
        'updated_at',
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



}
