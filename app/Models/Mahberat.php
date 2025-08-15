<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Syncable;

class Mahberat extends Model
{
    use Syncable;
    protected $fillable = [
        'name',
        'uuid',
        'synced',
        'synced_at',
        'last_modified',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_mahberat');
    }
    public function schedules()
{
    return $this->hasMany(Schedule::class);
}

protected function getUuidData(): array
{
    return [
        'name' => $this->name ?? 'unknown',
    ];
}

}
