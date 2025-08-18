<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Destination;
use Illuminate\Http\Request;

class BusReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['bus', 'destination', 'tickets']);
        
        // Apply filters
        if ($request->filled('bus_id')) {
            $query->where('bus_id', $request->bus_id);
        }
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('scheduled_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('scheduled_at', '<=', $request->date_to);
        }
        
        $schedules = $query->latest()->paginate(15);
        $buses = Bus::all();
        $destinations = Destination::all();
        
        // Statistics
        $totalSchedules = Schedule::count();
        $activeSchedules = Schedule::where('status', 'active')->count();
        $completedSchedules = Schedule::where('status', 'completed')->count();
        $totalRevenue = Schedule::with('tickets')->get()->sum(function($schedule) {
            return $schedule->tickets->sum('ticket_price');
        });
        
        return view('admin.reports.bus_reports', compact(
            'schedules', 'buses', 'destinations', 'totalSchedules', 
            'activeSchedules', 'completedSchedules', 'totalRevenue'
        ));
    }
}