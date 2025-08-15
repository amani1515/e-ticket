<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Syncable;

class Destination extends Model
{
    use HasFactory;
    use Syncable;

    protected $fillable = [
        'destination_name',
        'start_from',
        'tariff',
        'distance',
        'tax',
        'service_fee',
        'uuid',
        'synced',
        'synced_at',
        'last_modified',
    ];
   // app/Models/Destination.php
public function users()
{
    return $this->belongsToMany(User::class, 'destination_user', 'destination_id', 'user_id');
}
public function schedules()
{
    return $this->hasMany(\App\Models\Schedule::class);
}
public function tickets()
{
    return $this->hasMany(\App\Models\Ticket::class);
}

protected function getUuidData(): array
{
    return [
        'name' => $this->destination_name ?? 'unknown',
    ];
}

}
