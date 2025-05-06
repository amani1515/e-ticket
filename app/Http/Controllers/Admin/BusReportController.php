<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class BusReportController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['bus', 'destination'])->get(); // Fetch schedules with related data
        return view('admin.reports.bus_reports', compact('schedules'));
    }
}