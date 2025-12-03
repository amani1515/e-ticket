<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

use App\Models\Ticket;
use App\Models\Bus;
use App\Models\Schedule;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

echo "Testing Admin Send Functionality...\n\n";

$date = '2025-01-01';

// Get sample data
$tickets = Ticket::whereDate('created_at', $date)
    ->with(['destination', 'bus.mahberat', 'creator'])
    ->limit(5)
    ->get();

$buses = Bus::with('mahberat')->limit(5)->get();

$schedules = Schedule::whereDate('created_at', $date)
    ->with(['destination', 'bus.mahberat'])
    ->limit(5)
    ->get();

echo "Found:\n";
echo "- Tickets: " . $tickets->count() . "\n";
echo "- Buses: " . $buses->count() . "\n";
echo "- Schedules: " . $schedules->count() . "\n\n";

// Generate data like the controller does
$data = [
    'tickets' => $tickets->map(function($ticket) {
        return [
            'id' => $ticket->id,
            'passenger_name' => $ticket->passenger_name,
            'phone' => $ticket->phone_no,
            'from' => $ticket->destination->start_from,
            'to' => $ticket->destination->destination_name,
            'tariff' => $ticket->tariff ?? $ticket->destination->tariff,
            'bus_targa' => $ticket->bus->targa ?? $ticket->bus_id,
            'mahberat' => $ticket->bus->mahberat->name ?? 'N/A',
            'departure' => $ticket->departure_datetime,
            'created_at' => $ticket->created_at
        ];
    }),
    'buses' => $buses->map(function($bus) {
        return [
            'id' => $bus->id,
            'targa' => $bus->targa,
            'level' => $bus->level,
            'capacity' => $bus->capacity,
            'mahberat' => $bus->mahberat->name ?? 'N/A'
        ];
    }),
    'schedules' => $schedules->map(function($schedule) {
        return [
            'id' => $schedule->id,
            'from' => $schedule->destination->start_from,
            'to' => $schedule->destination->destination_name,
            'bus_targa' => $schedule->bus->targa ?? $schedule->bus_id,
            'departure' => $schedule->departure_datetime,
            'available_seats' => $schedule->available_seats
        ];
    })
];

echo "Generated JSON data structure:\n";
echo "- Tickets: " . count($data['tickets']) . " records\n";
echo "- Buses: " . count($data['buses']) . " records\n";
echo "- Schedules: " . count($data['schedules']) . " records\n\n";

echo "Sample ticket data:\n";
if (!empty($data['tickets'])) {
    echo json_encode($data['tickets'][0], JSON_PRETTY_PRINT) . "\n\n";
}

echo "Ready to send to Transport Authority API!\n";
echo "Data size: " . strlen(json_encode($data)) . " bytes\n";