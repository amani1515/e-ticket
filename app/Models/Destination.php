<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'destination_name',
        'start_from',
        'tariff',
        'tax',
        'service_fee',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'destination_user');
    }

}
