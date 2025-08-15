<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bus;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// BusController manages CRUD operations for buses belonging to a Mahberat (association).
// It ensures only authorized users can manage their own buses and handles file uploads/cleanup.
class BusController extends Controller
{
    // List all buses for the logged-in user's mahberat
    public function index()
    {
        $mahberatId = Auth::user()->mahberat_id;
        // Eager load owner relationship for efficiency
        $buses = Bus::with('owner')->where('mahberat_id', $mahberatId)->get();
        return view('mahberat.bus.index', compact('buses'));
    }
    
    // Show form to create a new bus
    public function create()
    {
        return view('mahberat.bus.create');
    }

    // Store a new bus in the database
    public function store(Request $request)
    {
        // Validate request inputs
        $validated = $request->validate([
            'targa' => 'required|digits_between:1,8|unique:buses,targa',
            'driver_name'     => 'required|string',
            'driver_phone'    => 'required|string',
            'redat_name'      => 'required|string',
            'level'           => 'required|in:level1,level2,level3',
            'total_seats'     => 'required|integer',
            'cargo_capacity'  => 'required|numeric|min:0',
            'status'          => 'nullable|in:active,maintenance,out_of_service,bolo_expire,accident,gidaj_yeweta,not_paid,punished,driver_shortage',
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

        // Handle file uploads (store in public disk)
        // Handle file uploads (store in public disk)
foreach (['file1', 'file2', 'file3'] as $fileKey) {
    if ($request->hasFile($fileKey)) {
        $file = $request->file($fileKey);
        $path = $file->store('bus_files', 'public'); // storage/app/public/bus_files
        $validated[$fileKey] = $path;
    } else {
        $validated[$fileKey] = null;
    }
}


        

        // Set default values and assign system fields
        $validated['status']         = $validated['status'] ?? 'active';
        $validated['registered_by']  = Auth::id();
        $validated['mahberat_id']    = Auth::user()->mahberat_id;

        // Generate a unique bus ID
        $datePart   = now()->format('Ymd');
        $randomPart = strtoupper(Str::random(10));
        $validated['unique_bus_id'] = "SEV" . now()->year . $datePart . $randomPart . "29";

        // Save the new bus
        Bus::create($validated);

        // Redirect with success messages
        return redirect()->back()
            ->with('success', 'Bus added successfully.')
            ->with('second_success', 'Second success message.');
    }


// Check if a bus with the given targa already exists
    public function checkTarga(Request $request)
            {
                $exists = \App\Models\Bus::where('targa', $request->targa)->exists();
                return response()->json(['exists' => $exists]);
            }

    // Show details for a single bus, ensuring ownership
    public function show($id)
    {
        $mahberatId = Auth::user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();
        return view('mahberat.bus.show', compact('bus'));
    }

    // Show form for editing a bus, ensuring ownership
    public function edit($id)
    {
        $mahberatId = Auth::user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();
        return view('mahberat.bus.edit', compact('bus'));
    }

    // Update bus info, including file uploads and ownership check
    public function update(Request $request, $id)
    {
        $mahberatId = Auth::user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();

        $validated = $request->validate([
            'targa'           => 'required|string',
            'driver_name'     => 'required|string',
            'driver_phone'    => 'required|string',
            'redat_name'      => 'required|string',
            'level'           => 'required|in:level1,level2,level3',
            'total_seats'     => 'required|integer',
            'cargo_capacity'  => 'required|numeric|min:0',
            'status'          => 'nullable|in:active,maintenance,out_of_service,bolo_expire,accident,gidaj_yeweta,not_paid,punished,driver_shortage',
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
                if (!empty($bus->{$fileKey})) {
                    Storage::disk('public')->delete($bus->{$fileKey});
                }
                // Store new file
                $validated[$fileKey] = $request->file($fileKey)->store('bus_files', 'public');
            }
        }

        $bus->update($validated);
        
        // Trigger sync for update
        $bus->syncUpdate();

        return redirect()->route('mahberat.bus.index')->with('success', 'Bus updated successfully!');
    }

    // Delete a bus with ownership check and file cleanup
    public function destroy($id)
    {
        $mahberatId = Auth::user()->mahberat_id;
        $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();

        // Delete associated files if any
        foreach (['file1', 'file2', 'file3'] as $fileKey) {
            if (!empty($bus->{$fileKey})) {
                Storage::disk('public')->delete($bus->{$fileKey});
            }
        }

        // Trigger sync for delete before deleting
        $bus->syncDelete();
        
        $bus->delete();

        return redirect()->route('mahberat.bus.index')->with('success', 'Bus deleted successfully.');
    }
}
