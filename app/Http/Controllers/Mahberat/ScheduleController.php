<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ScheduleController extends Controller
{
    public function index()
    {
        // Show all scheduled buses ordered by created time (FIFO)
        $schedules = Schedule::with(['bus', 'destination', 'scheduledBy'])
            ->orderBy('created_at', 'asc')
            ->get();
            

        return view('mahberat.schedule.index', compact('schedules'));
    }

    public function create()
    {
        $user = auth()->user();
    
        // Fetch all destinations assigned to the current user
        $destinations = $user->destinations; // Assuming the relationship is already defined
    
        // Fetch buses registered by the user and with status 'active'
        $buses = Bus::where('registered_by', $user->id)
                    ->where('status', 'active')
                    ->get();
    
        return view('mahberat.schedule.create', compact('destinations', 'buses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bus_id' => 'required|exists:buses,id',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        Schedule::create([
            'bus_id' => $validated['bus_id'],
            'destination_id' => $validated['destination_id'],
            'scheduled_by' => Auth::id(),
            'scheduled_at' => now(),
            'status' => 'queued',
        ]);

        return redirect()->route('mahberat.schedule.index')->with('success', 'Bus successfully scheduled!');
    }

    public function cardView()
{
    $user = Auth::user();
    $destinations = $user->destinations()->with(['schedules.bus'])->get();

    return view('mahberat.schedule.card-view', compact('destinations'));
}
}
