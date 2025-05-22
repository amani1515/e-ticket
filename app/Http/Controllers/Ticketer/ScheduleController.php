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
}
