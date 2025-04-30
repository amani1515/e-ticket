<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;


class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'passenger_name',
        'age_status',
        'destination_id',
        'bus_id',
        'departure_datetime',
        'ticket_code',
        'ticket_status',
        'creator_user_id',
        'tax',
        'service_fee',
    ];

    // Relationship with Destination
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
    


    // Relationship with User (creator)
    public function user()
    {
        return $this->belongsTo(User::class, 'creator_user_id');
    }
    
}
