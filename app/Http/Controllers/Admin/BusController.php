<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Mahberat;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index(Request $request)
    {
        $query = Bus::with(['owner', 'registeredBy', 'mahberat']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('targa', 'like', "%{$search}%")
                  ->orWhere('driver_name', 'like', "%{$search}%")
                  ->orWhere('driver_phone', 'like', "%{$search}%")
                  ->orWhere('unique_bus_id', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status_filter')) {
            $query->where('status', $request->status_filter);
        }
        
        // Filter by mahberat
        if ($request->filled('mahberat_filter')) {
            $query->where('mahberat_id', $request->mahberat_filter);
        }
        
        $buses = $query->paginate(15)->withQueryString();
        $mahberats = Mahberat::all();
        
        return view('admin.reports.buses', compact('buses', 'mahberats'));
    }

    public function overallBusReport()
    {
        $buses = Bus::with(['schedules.destination'])
            ->where('owner_id', auth()->id()) // Only fetch buses for the logged-in owner
            ->get();
        return view('balehabt.overallBusReport', compact('buses'));
    }

    public function show($id)
    {
        $bus = Bus::with(['owner', 'registeredBy', 'mahberat', 'schedules'])->findOrFail($id);
        return view('admin.buses.show', compact('bus'));
    }

    public function banner($id)
    {
        // Fetch the bus and pass it to the view
        $bus = Bus::findOrFail($id);
        return view('admin.reports.banner', compact('bus'));
    }
}