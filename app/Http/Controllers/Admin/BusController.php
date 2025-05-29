<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all(); // Fetch all buses
        return view('admin.reports.buses', compact('buses'));
    }

    public function overallBusReport()
    {
        $buses = Bus::with(['schedules.destination'])
            ->where('owner_id', auth()->id()) // Only fetch buses for the logged-in owner
            ->get();
        return view('balehabt.overallBusReport', compact('buses'));
    }

    public function banner($id)
    {
        // Fetch the bus and pass it to the view
        $bus = Bus::findOrFail($id);
        return view('admin.reports.banner', compact('bus'));
    }
}