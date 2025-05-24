<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoSetting extends Model
{
    protected $fillable = [
        'fee_per_km',
        'tax_percent',
        'service_fee',
    ];
}