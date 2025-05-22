<?php

namespace App\Http\Controllers\HisabShum;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaidReportController extends Controller
{
    //
    public function index()
{
    $schedules = \App\Models\Schedule::with(['bus', 'destination'])
        ->where('status', 'paid')
        ->orderByDesc('scheduled_at')
        ->get();

    return view('hisabShum.paidReports', compact('schedules'));
}
public function departedCertificate($id)
{
    $schedule = \App\Models\Schedule::with(['bus', 'destination'])->findOrFail($id);
    $schedule->status = 'departed';
    $schedule->save();

    return view('hisabShum.certificate', compact('schedule'));
}
public function certificate($id)
{
    $schedule = \App\Models\Schedule::with(['bus', 'destination'])->findOrFail($id);
    $schedule->status = 'departed';
    $schedule->departed_by = auth()->id();
    $schedule->departed_at = now();
    $schedule->save();
    return view('hisabShum.certificate', compact('schedule'));

}
}
