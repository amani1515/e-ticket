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
        'file1',
        'file2',
        'file3',
    ];
    
}
