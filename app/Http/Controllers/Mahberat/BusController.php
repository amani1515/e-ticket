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
        
        // If user doesn't have mahberat_id, show all buses or handle appropriately
        if ($mahberatId) {
            $buses = Bus::with('owner')->where('mahberat_id', $mahberatId)->get();
        } else {
            // Show all buses if no mahberat_id (for testing/admin purposes)
            $buses = Bus::with('owner')->get();
        }
        
        return view('mahberat.bus.index', compact('buses'));
    }
    
    // Show form to create a new bus
    public function create()
    {
        return view('mahberat.bus.create');
    }

    // Quick store for modal registration
    public function quickStore(Request $request)
    {
        try {
            $request->validate([
                'targa' => 'required|string|unique:buses,targa',
                'total_seats' => 'required|integer|min:1|max:100',
                'mahberat_id' => 'required|exists:mahberats,id',
                'driver_name' => 'required|string|max:255'
            ]);

            $bus = Bus::create([
                'targa' => $request->targa,
                'total_seats' => $request->total_seats,
                'mahberat_id' => $request->mahberat_id,
                'driver_name' => $request->driver_name,
                'unique_bus_id' => 'SEV' . now()->format('Ymd') . strtoupper(Str::random(6)),
                'registered_by' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Bus registered successfully',
                'bus' => $bus
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
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
        
        if ($mahberatId) {
            $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();
        } else {
            // Allow editing any bus if no mahberat_id (for testing/admin purposes)
            $bus = Bus::findOrFail($id);
        }
        
        return view('mahberat.bus.edit', compact('bus'));
    }

    // Update bus info, including file uploads and ownership check
    public function update(Request $request, $id)
    {
        $mahberatId = Auth::user()->mahberat_id;
        
        if ($mahberatId) {
            $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();
        } else {
            // Allow updating any bus if no mahberat_id (for testing/admin purposes)
            $bus = Bus::findOrFail($id);
        }

        $validated = $request->validate([
            'targa'           => 'required|string',
            'driver_name'     => 'nullable|string',
            'driver_phone'    => 'nullable|string',
            'redat_name'      => 'nullable|string',
            'level'           => 'nullable|in:level1,level2,level3',
            'total_seats'     => 'required|integer',
            'cargo_capacity'  => 'nullable|numeric|min:0',
            'status'          => 'nullable|in:active,maintenance,out_of_service,bolo_expire,accident,gidaj_yeweta,not_paid,punished,driver_shortage',
            'model_year'      => 'nullable|integer',
            'model'           => 'nullable|string',
            'bolo_id'         => 'nullable|string',
            'motor_number'    => 'nullable|string',
            'color'           => 'nullable|string',
            'distance'        => 'nullable|string',
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
        
        if ($mahberatId) {
            $bus = Bus::where('id', $id)->where('mahberat_id', $mahberatId)->firstOrFail();
        } else {
            // Allow deleting any bus if no mahberat_id (for testing/admin purposes)
            $bus = Bus::findOrFail($id);
        }

        // Delete associated files if any
        foreach (['file1', 'file2', 'file3'] as $fileKey) {
            if (!empty($bus->{$fileKey})) {
                Storage::disk('public')->delete($bus->{$fileKey});
            }
        }

        // Trigger sync for delete before deleting
        if (method_exists($bus, 'syncDelete')) {
            $bus->syncDelete();
        }
        
        $bus->delete();

        return redirect()->route('mahberat.bus.index')->with('success', 'Bus deleted successfully.');
    }
    
    // Search buses by targa for auto-suggestions
    public function search(Request $request)
    {
        $targa = $request->get('targa', '');
        
        // Show all buses without mahberat filtering for mahberat users
        $buses = Bus::where('targa', 'like', '%' . $targa . '%')
            ->where('status', 'active')
            ->select('id', 'targa', 'driver_name', 'total_seats', 'color', 'status', 'unique_bus_id')
            ->limit(10)
            ->get();
        
        return response()->json([
            'buses' => $buses
        ]);
    }
}
