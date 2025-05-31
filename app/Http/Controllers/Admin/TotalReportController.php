<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TotalReportController extends Controller
{
public function index(Request $request)
{
    // Allow both admin and headoffice to view
    if (!auth()->check() || !in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
        return view('errors.403');
    }

    $from = $request->input('from_date');
    $to = $request->input('to_date');

    $destinations = \App\Models\Destination::withCount(['tickets' => function ($query) use ($from, $to) {
        if ($from) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('created_at', '<=', $to);
        }
    }])->get();

    $totalTickets = 0;
    $totalMale = 0;
    $totalFemale = 0;
    $totalKm = 0;

    foreach ($destinations as $destination) {
        $destination->male_count = $destination->tickets()
            ->where('gender', 'male')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $destination->female_count = $destination->tickets()
            ->where('gender', 'female')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        $scheduleCount = $destination->schedules()
            ->when($from, fn($q) => $q->whereDate('scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('scheduled_at', '<=', $to))
            ->count();

        $destination->total_km = $scheduleCount * ($destination->distance ?? 0);

        $totalTickets += $destination->tickets_count;
        $totalMale += $destination->male_count;
        $totalFemale += $destination->female_count;
        $totalKm += $destination->total_km;
    }

    return view('admin.reports.total', compact('destinations', 'totalTickets', 'totalMale', 'totalFemale', 'totalKm'));
}
}