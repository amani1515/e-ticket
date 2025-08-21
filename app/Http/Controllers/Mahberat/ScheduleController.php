<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// ScheduleController manages scheduling of buses for a Mahberat (association).
// It allows Mahberat users to create, view, and delete schedules for their buses.
class ScheduleController extends Controller
{
    // List all schedules
    public function index()
    {
        // Eager load related bus, destination, and scheduledBy user - show all schedules
        $schedules = Schedule::with(['bus', 'destination', 'scheduledBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('mahberat.schedule.index', compact('schedules'));
    }

    // Show the form to create a new schedule
    public function create()
    {
        // Get all destinations for mahberat user to access any destination
        $destinations = Destination::all();
        $buses = Bus::where('status', 'active')->get();
        return view('mahberat.schedule.create', compact('destinations', 'buses'));
    }

    // Store a new schedule for a bus
    public function store(Request $request)
    {
        // Debug: Log the request data
        \Log::info('Schedule store request data:', $request->all());
        
        $request->validate([
            'unique_bus_id' => 'required|string',
            'destination_id' => 'required|exists:destinations,id',
        ]);

        $user = Auth::user();
        $mahberatId = $user->mahberat_id;

        // Get the bus using unique_bus_id (allow any mahberat's bus)
        $bus = Bus::where('unique_bus_id', $request->unique_bus_id)->first();

        if (!$bus) {
            return back()->withErrors(['unique_bus_id' => 'Selected bus not found or not available.']);
        }

        // Prevent scheduling the same bus if already queued or loading
        $alreadyScheduled = Schedule::where('bus_id', $bus->id)
            ->whereIn('status', ['queued', 'on loading'])
            ->exists();

        if ($alreadyScheduled) {
            return back()->withErrors(['unique_bus_id' => 'This bus is already scheduled.']);
        }

        // Generate a unique schedule UID
        $scheduleUid = 'sevastopoltechs-' . strtoupper(Str::random(10));

        // Create the schedule
        Schedule::create([
            'schedule_uid'    => $scheduleUid,
            'bus_id'          => $bus->id,
            'destination_id'  => $request->destination_id,
            'scheduled_by'    => $user->id,
            'mahberat_id'     => $bus->mahberat_id,
            'scheduled_at' => now(),  
        'status' => 'queued',
        'capacity' => $bus->total_seats,
        'cargo_capacity' => $bus->cargo_capacity,
        'boarding' => 0,
    ]);

    return redirect()->route('mahberat.schedule.index')->with('success', 'Bus scheduled successfully.');
}


public function cardView()
{
    $user = Auth::user();
    $mahberatId = $user->mahberat_id;

    // Get schedules belonging to this mahberat, grouped by destination
    $schedules = \App\Models\Schedule::with(['bus', 'destination'])
        ->where('mahberat_id', $mahberatId)
        ->whereIn('status', ['queued', 'on loading'])
        ->get()
        ->groupBy('destination_id');

    return view('mahberat.schedule.card-view', compact('schedules'));
}


    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        
        // Only allow removal of queued schedules
        if ($schedule->status !== 'queued') {
            return redirect()->route('mahberat.schedule.index')->with('error', 'Only queued schedules can be removed.');
        }

        // Trigger sync for delete before deleting
        $schedule->syncDelete();
        
        $schedule->delete();

        return redirect()->route('mahberat.schedule.index')->with('success', 'Schedule removed successfully.');
    }

    // Update schedule bus
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        // Only allow updating queued schedules
        if ($schedule->status !== 'queued') {
            return redirect()->route('mahberat.schedule.index')->with('error', 'Only queued schedules can be updated.');
        }

        $request->validate([
            'unique_bus_id' => 'required|string'
        ]);

        // Find the new bus
        $bus = Bus::where('unique_bus_id', $request->unique_bus_id)->first();
        if (!$bus) {
            return redirect()->route('mahberat.schedule.index')->with('error', 'Selected bus not found.');
        }

        // Check if the new bus is already scheduled
        $alreadyScheduled = Schedule::where('bus_id', $bus->id)
            ->where('id', '!=', $id)
            ->whereIn('status', ['queued', 'on loading'])
            ->exists();

        if ($alreadyScheduled) {
            return redirect()->route('mahberat.schedule.index')->with('error', 'Selected bus is already scheduled.');
        }

        // Update the schedule
        $schedule->bus_id = $bus->id;
        $schedule->mahberat_id = $bus->mahberat_id;
        $schedule->capacity = $bus->total_seats;
        $schedule->cargo_capacity = $bus->cargo_capacity ?? 0;
        $schedule->save();
        
        // Trigger sync for update
        $schedule->syncUpdate();

        return redirect()->route('mahberat.schedule.index')->with('success', 'Schedule bus updated successfully.');
    }
}
