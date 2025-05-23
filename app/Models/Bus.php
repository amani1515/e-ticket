<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    //
    protected $fillable = [
        'targa',
        'driver_name',
        'driver_phone',
        'redat_name',
        'level',
        'total_seats',
        'status',
        'model_year',
        'model',
        'bolo_id',
        'motor_number',
        'color',
        'owner_id',
        'registered_by',
        'file1',
        'file2',
        'file3',
    ];


    public function owner()
{
    return $this->belongsTo(User::class, 'owner_id');
}

    public function registeredBy()
{
    return $this->belongsTo(User::class, 'registered_by');
}

    public function destination()
{
    return $this->belongsTo(Destination::class, 'registered_by');
}
public function schedules() {
    return $this->hasMany(Schedule::class, 'bus_id');
}
}
