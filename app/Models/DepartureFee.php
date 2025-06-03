<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartureFee extends Model
{
    protected $fillable = ['level', 'fee'];

    /**
     * Disable auto-incrementing ID for mass update by 'level'
     */
    public $incrementing = true;

    /**
     * Use default timestamps
     */
    public $timestamps = true;
}
