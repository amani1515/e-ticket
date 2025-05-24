<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleReportController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'destination', 'scheduledBy', 'paidBy', 'departedBy'])
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.reports.scheduleReports', compact('schedules'));
    }
}