<?php

namespace App\Http\Controllers\Ticketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// ScheduleController handles schedule reporting and payment actions for ticketers.
// Ticketers can view their schedules and mark them as paid.
class ScheduleController extends Controller
{
    // Show a report of all schedules created by the current ticketer (except queued)
    public function report()
    {
        $user = auth()->user();

        // Fetch schedules with related bus and destination, filtered by creator and status
        $schedules = \App\Models\Schedule::with(['bus', 'destination'])
            ->where('ticket_created_by', $user->id)
            ->where('status', '!=', 'queued')
            ->orderByDesc('scheduled_at')
            ->get();

        // Show the report view with the schedules
        return view('ticketer.schedule.report', compact('schedules'));
    }

    // Mark a schedule as paid by the current user
    public function pay($id)
    {
        $schedule = \App\Models\Schedule::findOrFail($id);
        $schedule->status = 'paid';
        $schedule->paid_by = auth()->id();
        $schedule->paid_at = now();
        $schedule->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Schedule marked as paid!');
    }
}
