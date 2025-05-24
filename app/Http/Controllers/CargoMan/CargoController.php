<?php
namespace App\Http\Controllers\CargoMan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cargo;
use App\Models\Destination;
use App\Models\CargoSetting;

class CargoController extends Controller
{
    public function index()
    {
        // Show all cargos
        return view('cargoMan.cargo.index');
    }

// app/Http/Controllers/CargoMan/CargoController.php
public function create()
{
    $destinations = \App\Models\Destination::all();
    $cargoSettings = \App\Models\CargoSetting::first();

    return view('cargoMan.cargo.create', compact('destinations', 'cargoSettings'));
}

public function firstQueuedSchedule($destinationId)
{
    $schedule = \App\Models\Schedule::with('bus', 'destination')
        ->where('destination_id', $destinationId)
        ->where('status', 'queued')
        ->first();

    if ($schedule) {
        return response()->json([
            'schedule_id' => $schedule->id,
            'schedule_uid' => $schedule->schedule_uid,
            'bus_id' => $schedule->bus->id,
            'bus_targa' => $schedule->bus->targa,
            'distance' => $schedule->destination->distance,
            'destination_name' => $schedule->destination->destination_name,
        ]);
    } else {
        return response()->json([]);
    }
}
public function store(Request $request)
{
    $request->validate([
        'destination_id' => 'required|exists:destinations,id',
        'schedule_id' => 'required|exists:schedules,id',
        'bus_id' => 'required|exists:buses,id',
        'distance' => 'required|numeric',
        'weight' => 'required|numeric|min:0.01',
        'fee_per_km' => 'required|numeric',
        'tax_percent' => 'required|numeric',
        'service_fee' => 'required|numeric',
        'total_amount' => 'required|numeric',
    ]);

    $cargo = \App\Models\Cargo::create([
        'cargo_uid'     => uniqid('CARGO-'),
        'bus_id'        => $request->bus_id,
        'schedule_id'   => $request->schedule_id,
        'destination_id'=> $request->destination_id,
        'measured_by'   => auth()->id(),
        'weight'        => $request->weight,
        'service_fee'   => $request->service_fee,
        'tax'           => $request->tax_percent,
        'total_amount'  => $request->total_amount,
        'status'        => 'measured',
    ]);

    return redirect()->route('cargoMan.cargo.receipt', $cargo->id);
}

// Add this method for the receipt page
public function receipt($id)
{
    $cargo = \App\Models\Cargo::with(['bus', 'destination', 'schedule'])->findOrFail($id);
    return view('cargoMan.cargo.receipt', compact('cargo'));
}
}