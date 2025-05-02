<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use Illuminate\Support\Facades\Storage;

class BusController extends Controller
{
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

    Bus::create($validated);

    return redirect()->back()->with('success', 'Bus added successfully.');
}

}
