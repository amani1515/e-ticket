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
        'gender', // <-- Make sure this is here!
        'cargo_id', // <-- Add this line!

        'age_status',
        'destination_id',
        'bus_id',
            'schedule_id', // <-- make sure this is here!

        'departure_datetime',
        'ticket_code',
        'ticket_status',
        'creator_user_id',
        'tax',
        'service_fee',
        'fayda_id',
        'phone_no', // <-- Add this line if you have a phone number field
        'disability_status', // <-- Add this line if you have a disability status field
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
    public function bus()
{
    return $this->belongsTo(Bus::class);
}

public function schedule()
{
    return $this->belongsTo(\App\Models\Schedule::class);
}
public function cargo()
{
    return $this->belongsTo(\App\Models\Cargo::class);
}
public function creator() {
    return $this->belongsTo(\App\Models\User::class, 'creator_user_id');
}
}
