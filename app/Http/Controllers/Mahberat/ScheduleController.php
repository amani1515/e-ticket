<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

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
    $request->validate([
        'bus_id' => 'required|exists:buses,id',
        'destination_id' => 'required|exists:destinations,id',
    ]);

    // Check if the bus is already scheduled
    $alreadyScheduled = Schedule::where('bus_id', $request->bus_id)
        ->whereIn('status', ['queued', 'on loading'])
        ->exists();

    if ($alreadyScheduled) {
        return back()->withErrors(['bus_id' => 'This bus is already scheduled.']);
    }

    // Fetch the bus to get its total_seats
    $bus = Bus::findOrFail($request->bus_id);

   // Generate unique schedule_uid
    $scheduleUid = 'sevastopoltechs-' . strtoupper(Str::random(10));

    // Create the schedule with capacity from bus
  Schedule::create([
    'bus_id' => $request->bus_id,
        'schedule_uid' => $scheduleUid, // <-- Add this line!
    'destination_id' => $request->destination_id,
    'scheduled_by' => auth()->id(),
    'scheduled_at' => now(),
    'status' => 'queued',
    'capacity' => $bus->total_seats,
    'cargo_capacity' => $bus->cargo_capacity,

    'boarding' => 0,
]);
    

    return redirect()->route('mahberat.schedule.index')->with('success', 'Bus scheduled successfully.');
}

        // Prevent duplicate scheduling for the same destination
      

    public function cardView()
{
    $user = Auth::user();
    $destinations = $user->destinations()->with(['schedules.bus'])->get();

    return view('mahberat.schedule.card-view', compact('destinations'));
}

public function destroy($id)
{
    $schedule = Schedule::findOrFail($id);
    $schedule->delete();

    return redirect()->route('mahberat.schedule.index')->with('success', 'Schedule removed successfully.');
}
}
