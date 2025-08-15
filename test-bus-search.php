<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing Bus Search Functionality...\n";
echo "===================================\n\n";

use App\Models\Bus;

// Test bus search
$targa = '12'; // Example search
$mahberatId = 1; // Example mahberat ID

$buses = Bus::where('mahberat_id', $mahberatId)
    ->where('targa', 'like', '%' . $targa . '%')
    ->where('status', 'active')
    ->select('id', 'targa', 'driver_name', 'total_seats', 'color', 'status', 'unique_bus_id')
    ->limit(5)
    ->get();

echo "Search results for targa containing '{$targa}':\n";
echo "Found " . $buses->count() . " buses:\n\n";

foreach ($buses as $bus) {
    echo "- Targa: {$bus->targa}\n";
    echo "  Driver: {$bus->driver_name}\n";
    echo "  Seats: {$bus->total_seats}\n";
    echo "  Status: {$bus->status}\n";
    echo "  Unique ID: {$bus->unique_bus_id}\n";
    echo "  ---\n";
}

echo "\nTest completed!\n";
?>