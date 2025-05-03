<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_date',
        'total_amount',
        'tax',
        'service_fee',
        'status',
        'submitted_at',
        'received_at',
    ];

    // Relationship to User (ticketer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
