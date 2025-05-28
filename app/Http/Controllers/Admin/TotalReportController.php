<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TotalReportController extends Controller
{
public function index(Request $request)
{
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

    foreach ($destinations as $destination) {
        // Male count
        $destination->male_count = $destination->tickets()
            ->where('gender', 'male')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        // Female count
        $destination->female_count = $destination->tickets()
            ->where('gender', 'female')
            ->when($from, fn($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('created_at', '<=', $to))
            ->count();

        // Total KM covered = schedules count * distance
        $scheduleCount = $destination->schedules()
            ->when($from, fn($q) => $q->whereDate('scheduled_at', '>=', $from))
            ->when($to, fn($q) => $q->whereDate('scheduled_at', '<=', $to))
            ->count();

        $destination->total_km = $scheduleCount * ($destination->distance ?? 0);
    }

    return view('admin.reports.total', compact('destinations'));
}
}