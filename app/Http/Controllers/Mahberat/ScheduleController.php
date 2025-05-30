<?php

namespace App\Http\Controllers\Mahberat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Bus;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ScheduleController extends Controller
{
    public function index()
    {
        $mahberatId = auth()->user()->mahberat_id;

        // Show only schedules for this Mahberat
        $schedules = Schedule::with(['bus', 'destination', 'scheduledBy'])
            ->where('mahberat_id', $mahberatId)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('mahberat.schedule.index', compact('schedules'));
    }

public function create()
{
    $user = auth()->user();

    // Get Mahberat model
    $mahberat = $user->mahberat;

    // Get destinations through the Mahberat relationship
    $destinations = $mahberat->destinations()->get();

    // Get active buses for this Mahberat
    $buses = Bus::where('mahberat_id', $mahberat->id)
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

        $user = auth()->user();
        $mahberatId = $user->mahberat_id;

        // Check if the bus is already scheduled
        $alreadyScheduled = Schedule::where('bus_id', $request->bus_id)
            ->whereIn('status', ['queued', 'on loading'])
            ->exists();

        if ($alreadyScheduled) {
            return back()->withErrors(['bus_id' => 'This bus is already scheduled.']);
        }

        $bus = Bus::findOrFail($request->bus_id);

        // Generate unique schedule UID
        $scheduleUid = 'sevastopoltechs-' . strtoupper(Str::random(10));

        // Create the schedule
        Schedule::create([
            'schedule_uid' => $scheduleUid,
            'bus_id' => $bus->id,
            'destination_id' => $request->destination_id,
            'scheduled_by' => $user->id,
            'mahberat_id' => $mahberatId, // ✅ Save Mahberat ID
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

        // Load destinations with schedules and buses (only for user's mahberat)
        $destinations = $user->destinations()->with(['schedules' => function ($query) use ($user) {
            $query->where('mahberat_id', $user->mahberat_id)->with('bus');
        }])->get();

        return view('mahberat.schedule.card-view', compact('destinations'));
    }

    public function destroy($id)
    {
        $schedule = Schedule::where('id', $id)
            ->where('mahberat_id', auth()->user()->mahberat_id)
            ->firstOrFail();

        $schedule->delete();

        return redirect()->route('mahberat.schedule.index')->with('success', 'Schedule removed successfully.');
    }
}
