<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahberat extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function destinations()
    {
        return $this->belongsToMany(Destination::class, 'destination_mahberat');
    }
}
