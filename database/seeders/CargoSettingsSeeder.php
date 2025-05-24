<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CargoSetting;

class CargoSettingsSeeder extends Seeder
{
    public function run()
    {
        CargoSetting::firstOrCreate([
            'id' => 1
        ], [
            'fee_per_km' => 0,
            'tax_percent' => 0,
            'service_fee' => 0,
        ]);
    }
}