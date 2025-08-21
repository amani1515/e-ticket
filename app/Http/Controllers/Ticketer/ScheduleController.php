<?php

namespace App\Http\Controllers\Ticketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// ScheduleController handles schedule reporting and payment actions for ticketers.
// Ticketers can view their schedules and mark them as paid.
class ScheduleController extends Controller
{
    // Show a report of all schedules created by the current ticketer with filters
    public function report(Request $request)
    {
        $user = auth()->user();
        $query = \App\Models\Schedule::with(['bus', 'destination'])
            ->where('ticketer_id', $user->id)
            ->whereIn('status', ['queued', 'on loading', 'full', 'paid']);

        // Filter by destination
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        // Filter by bus targa
        if ($request->filled('bus_targa')) {
            $query->whereHas('bus', function($q) use ($request) {
                $q->where('targa', 'like', '%' . $request->bus_targa . '%');
            });
        }

        // Filter by schedule ID
        if ($request->filled('schedule_id')) {
            $query->where('id', $request->schedule_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('scheduled_at', now()->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('scheduled_at', now()->subDay()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('scheduled_at', now()->month)
                          ->whereYear('scheduled_at', now()->year);
                    break;
            }
        }

        $schedules = $query->orderByDesc('scheduled_at')->paginate(15);
        
        // Debug info
        $totalSchedules = \App\Models\Schedule::count();
        $currentUserId = $user->id;
        
        return view('ticketer.schedule.report', compact('schedules', 'totalSchedules', 'currentUserId'));
    }

    // Mark a schedule as paid by the current user
    public function pay($id)
    {
        $schedule = \App\Models\Schedule::findOrFail($id);
        $schedule->status = 'departed';
        $schedule->paid_by = auth()->id();
        $schedule->paid_at = now();
        $schedule->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Schedule marked as paid!');
    }
}
