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
        'level1_tariff',
        'level2_tariff', 
        'level3_tariff',
        'same_for_all_levels',
        'distance',
        'tax',
        'service_fee',
        'uuid',
        'synced',
        'synced_at',
        'last_modified',
    ];
    
    protected $casts = [
        'tariff' => 'float',
        'level1_tariff' => 'float',
        'level2_tariff' => 'float',
        'level3_tariff' => 'float',
        'tax' => 'float',
        'service_fee' => 'float',
        'distance' => 'float',
        'same_for_all_levels' => 'boolean',
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

public function getTariffForLevel($level): float
{
    if ($this->same_for_all_levels) {
        return (float) $this->tariff;
    }
    
    switch ($level) {
        case 'level1':
            return (float) ($this->level1_tariff ?: $this->tariff);
        case 'level2':
            return (float) ($this->level2_tariff ?: $this->tariff);
        case 'level3':
            return (float) ($this->level3_tariff ?: $this->tariff);
        default:
            return (float) $this->tariff;
    }
}

protected function getUuidData(): array
{
    return [
        'name' => $this->destination_name ?? 'unknown',
    ];
}

}
