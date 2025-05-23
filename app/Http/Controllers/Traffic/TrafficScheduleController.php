<?php
// app/Http/Controllers/TrafficScheduleController.php

namespace App\Http\Controllers\Traffic;

use Illuminate\Http\Request;
use App\Models\Schedule;

class TrafficScheduleController extends \App\Http\Controllers\Controller
{
    public function scan(Request $request)
    {
        $request->validate([
            'schedule_uid' => 'required|string',
        ]);

        $schedule = Schedule::with('bus')
            ->where('schedule_uid', $request->schedule_uid)
            ->first();

        if (!$schedule) {
            return back()->with('error', 'Schedule not found.');
        }

        return view('traffic.schedule.result', compact('schedule'));
    }

    public function markWellgo($id)
    {
        $schedule = \App\Models\Schedule::with(['bus', 'destination'])->findOrFail($id);
        if ($schedule->status === 'departed') {
            $schedule->status = 'wellgo';
            $schedule->wellgo_at = now();
            $schedule->traffic_name = auth()->user()->name ?? 'Unknown';
            $schedule->save();
        }
        // Return the same result view with the updated schedule
        return view('traffic.schedule.result', compact('schedule'));
    }
}
