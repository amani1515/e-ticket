<?php

namespace App\Http\Controllers\Ticketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
public function report()
{
    $user = auth()->user();

    $schedules = \App\Models\Schedule::with(['bus', 'destination'])
        ->where('ticket_created_by', $user->id)
        ->where('status', '!=', 'queued')
        ->orderByDesc('scheduled_at')
        ->get();

    return view('ticketer.schedule.report', compact('schedules'));
}
public function pay($id)
{
    $schedule = \App\Models\Schedule::findOrFail($id);
    $schedule->status = 'paid';
    $schedule->paid_by = auth()->id();
    $schedule->paid_at = now();
    $schedule->save();

    return redirect()->back()->with('success', 'Schedule marked as paid!');
}
}
