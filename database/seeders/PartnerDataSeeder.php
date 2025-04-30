<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Destination;
use App\Models\Ticket;

class PartnerDataSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Users
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@gmail.com'),
            'role' => 'admin',
        ]);

        $ticketer = User::create([
            'name' => 'Ticketer One',
            'email' => 'ticketer@gmail.com',
            'password' => Hash::make('ticketer@gmail.com'),
            'role' => 'ticketer',
        ]);

        // Seed Destinations
        $destination1 = Destination::create([
            'destination_name' => 'Addis Ababa',
            'start_from' => 'Bahirdar',
            'tariff' => 500,
            'tax' => 10,
            'service_fee' => 5,
        ]);

        $destination2 = Destination::create([
            'destination_name' => 'Debre Markos',
            'start_from' => 'Bahirdar',
            'tariff' => 400,
            'tax' => 8,
            'service_fee' => 5,
        ]);

        // Seed Tickets
        Ticket::create([
            'passenger_name' => 'John',
            'age_status' => 'adult',
            'destination_id' => $destination1->id,
            'bus_id' => 'AB-12345',
            'departure_datetime' => now()->addDays(1),
            'ticket_code' => 'SE' . now()->format('Ymd') . '1',
            'ticket_status' => 'created',
            'creator_user_id' => $ticketer->id,
            'tax' => $destination1->tax,
            'service_fee' => $destination1->service_fee,
        ]);
    }
}
