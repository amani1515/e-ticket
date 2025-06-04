<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
    'tx_ref',
    'amount',
    'currency',
    'payment_gateway',
    'payment_method',
    'level',
    'schedule_id',
    'status',
    'paid_at',
];
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Add any other relationships or methods you need
}
