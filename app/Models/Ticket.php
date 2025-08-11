<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Destination;
use App\Traits\Syncable;


class Ticket extends Model
{
    use HasFactory;
    use Syncable;

    protected $fillable = [
        'passenger_name',
        'gender',
        'cargo_id',
        'age_status',
        'destination_id',
        'bus_id',
        'schedule_id',
        'departure_datetime',
        'ticket_code',
        'ticket_status',
        'creator_user_id',
        'tax',
        'service_fee',
        'fayda_id',
        'phone_no',
        'disability_status',
        'uuid',
        'synced',
        'synced_at',
        'last_modified',
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
public function mahberat()
{
    return $this->belongsTo(User::class, 'mahberat_id');
}
public function balehabt()
{
    return $this->belongsTo(User::class, 'balehabt_id');
}

protected function getUuidData(): array
{
    return [
        'destination' => $this->destination->destination_name ?? 'unknown',
    ];
}
}