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
        $schedule = \App\Models\Schedule::findOrFail($id);
        if ($schedule->status === 'departed') {
            $schedule->status = 'wellgo';
            $schedule->save();
        }
        return redirect()->back()->with('success', 'Status changed to WellGo!');
    }
}
