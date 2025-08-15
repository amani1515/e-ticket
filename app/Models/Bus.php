<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Syncable;

class Bus extends Model
{
    use Syncable;
    //

protected $fillable = [
    'targa',
    'driver_name',
    'driver_phone',
    'redat_name',
    'level',
    'sub_level',
    'total_seats',
    'cargo_capacity',
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
    'mahberat_id',
    'unique_bus_id',
    'uuid',
    'synced',
    'synced_at',
    'last_modified',
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
public function mahberat()
{
    return $this->belongsTo(Mahberat::class);
}

protected function getUuidData(): array
{
    return [
        'level' => $this->level ?? 'level1',
    ];
}

}
