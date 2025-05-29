<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with('owner')->where('registered_by', auth()->id())->get();
        return view('mahberat.bus.index', compact('buses'));
    }
    

    public function create()
    {
        return view('mahberat.bus.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'targa' => 'required|string',
        'driver_name' => 'required|string',
        'driver_phone' => 'required|string',
        'redat_name' => 'required|string',
        'level' => 'required|in:level1,level2,level3',
        'total_seats' => 'required|integer',
        'cargo_capacity' => 'required|numeric|min:0',
        'status' => 'nullable|in:active,maintenance,out of service',
        'model_year' => 'required|integer',
        'model' => 'required|string',
        'bolo_id' => 'required|string',
        'motor_number' => 'required|string',
        'color' => 'required|string',
        'owner_id' => 'nullable|exists:users,id',
        'file1' => 'nullable|file',
        'file2' => 'nullable|file',
        'file3' => 'nullable|file',
    ]);

    // Handle files if present
    foreach (['file1', 'file2', 'file3'] as $fileKey) {
        if ($request->hasFile($fileKey)) {
            $path = $request->file($fileKey)->store('bus_files', 'public');
            $validated[$fileKey] = $path;
        }
    }
    $validated['status'] = $validated['status'] ?? 'active';
    $validated['registered_by'] = Auth::id();

    // Generate unique bus id: SEV+year+date+random10+29
    $date = now()->format('Ymd');
    $random = strtoupper(substr(bin2hex(random_bytes(5)), 0, 10));
    $uniqueBusId = 'SEV' . now()->year . $date . $random . '29';

    $validated['unique_bus_id'] = $uniqueBusId;

    Bus::create($validated);

    return redirect()->back()->with('success', 'Bus added successfully.');
}

public function show($id)
{
    $bus = Bus::where('id', $id)->where('registered_by', auth()->id())->firstOrFail();
    return view('mahberat.bus.show', compact('bus'));
}

public function edit($id)
{
    $bus = Bus::findOrFail($id);
    return view('mahberat.bus.edit', compact('bus'));
}
public function destroy($id)
{
    $bus = Bus::where('id', $id)->where('registered_by', auth()->id())->firstOrFail();
    $bus->delete();
    return redirect()->route('mahberat.bus.index')->with('success', 'Bus deleted successfully.');
}

public function update(Request $request, $id)
{
    $validated = $request->validate([
        'targa' => 'required',
        'driver_name' => 'required',
        'driver_phone' => 'required',
        'redat_name' => 'required',
        'level' => 'required',
        'total_seats' => 'required|integer',
        'status' => 'required',
        'model_year' => 'required',
        'model' => 'required',
        'bolo_id' => 'required',
        'motor_number' => 'required',
        'color' => 'required',
    ]);

    $bus = Bus::findOrFail($id);
    $bus->update($validated);

    return redirect()->route('mahberat.bus.index')->with('success', 'Bus updated successfully!');
}
}
