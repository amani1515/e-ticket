<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Add this line

class BusController extends Controller
{
    // List buses belonging to the logged-in user's mahberat
    public function index()
    {
        $mahberatId = auth()->user()->mahberat_id;
        // Fetch buses where mahberat_id matches
        $buses = Bus::with('owner')->where('mahberat_id', $mahberatId)->get();
        return view('mahberat.bus.index', compact('buses'));
    }
    
    // Show form to create new bus
    public function create()
    {
        return view('mahberat.bus.create');
    }

    // Store new bus in DB
   public function store(Request $request)
{
    // ✅ Step 1: Validate Request Inputs
    $validated = $request->validate([
        'targa'           => 'required|string',
        'driver_name'     => 'required|string',
        'driver_phone'    => 'required|string',
        'redat_name'      => 'required|string',
        'level'           => 'required|in:level1,level2,level3',
        'total_seats'     => 'required|integer',
        'cargo_capacity'  => 'required|numeric|min:0',
        'status' => 'nullable|in:active,maintenance,out_of_service,bolo_expire,accident,gidaj_yeweta,not_paid,punished,driver_shortage',
        'model_year'      => 'required|integer',
        'model'           => 'required|string',
        'bolo_id'         => 'required|string',
        'motor_number'    => 'required|string',
        'color'           => 'required|string',
        'distance'        => 'required|string',
        'owner_id'        => 'nullable|exists:users,id',
        'file1'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file2'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file3'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]);

    // ✅ Step 2: Handle File Uploads (with fallback pathing)
    foreach (['file1', 'file2', 'file3'] as $fileKey) {
        if ($request->hasFile($fileKey)) {
            $validated[$fileKey] = $request->file($fileKey)->store("bus_files", "public");
        }
    }

    // ✅ Step 3: Add default or system-assigned values
    $validated['status']         = $validated['status'] ?? 'active';
    $validated['registered_by']  = Auth::id();
    $validated['mahberat_id']    = Auth::user()->mahberat_id;

    // ✅ Step 4: Generate a Unique Bus ID
    $datePart   = now()->format('Ymd');
    $randomPart = strtoupper(Str::random(10));
    $validated['unique_bus_id'] = "SEV" . now()->year . $datePart . $randomPart . "29";

    // ✅ Step 5: Save to DB
    Bus::create($validated);

    // ✅ Step 6: Redirect back with session flashes
    return redirect()->back()
        ->with('success', 'Bus added successfully.')
        ->with('second_success', 'Second success message.');
}

    // Show a single bus details, check ownership
    public function show($id)
    {
        $mahberatId = auth()->user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();

        return view('mahberat.bus.show', compact('bus'));
    }

    // Show form for editing a bus, check ownership
    public function edit($id)
    {
        $mahberatId = auth()->user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();

        return view('mahberat.bus.edit', compact('bus'));
    }

    // Update bus info, including file uploads and ownership check
    public function update(Request $request, $id)
    {
        $mahberatId = auth()->user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();

        $validated = $request->validate([
            'targa'           => 'required|string',
        'driver_name'     => 'required|string',
        'driver_phone'    => 'required|string',
        'redat_name'      => 'required|string',
        'level'           => 'required|in:level1,level2,level3',
        'total_seats'     => 'required|integer',
        'cargo_capacity'  => 'required|numeric|min:0',
        'status' => 'nullable|in:active,maintenance,out_of_service,bolo_expire,accident,gidaj_yeweta,not_paid,punished,driver_shortage',
        'model_year'      => 'required|integer',
        'model'           => 'required|string',
        'bolo_id'         => 'required|string',
        'motor_number'    => 'required|string',
        'color'           => 'required|string',
        'distance'        => 'required|string',
        'owner_id'        => 'nullable|exists:users,id',
        'file1'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file2'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'file3'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file replacements - delete old files if new ones uploaded
        foreach (['file1', 'file2', 'file3'] as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Delete old file if exists
                if ($bus->{$fileKey}) {
                    Storage::disk('public')->delete($bus->{$fileKey});
                }
                // Store new file
                $path = $request->file($fileKey)->store('bus_files', 'public');
                $validated[$fileKey] = $path;
            }
        }

        $bus->update($validated);

        return redirect()->route('mahberat.bus.index')->with('success', 'Bus updated successfully!');
    }

    // Delete bus with ownership check and file cleanup
    public function destroy($id)
    {
        $mahberatId = auth()->user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();

        // Delete associated files if any
        foreach (['file1', 'file2', 'file3'] as $fileKey) {
            if ($bus->{$fileKey}) {
                Storage::disk('public')->delete($bus->{$fileKey});
            }
        }

        $bus->delete();

        return redirect()->route('mahberat.bus.index')->with('success', 'Bus deleted successfully.');
    }
}
