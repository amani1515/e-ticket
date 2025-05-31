<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleReportController extends Controller
{
public function index(\Illuminate\Http\Request $request)
{
    // Allow both admin and headoffice to view
    if (!auth()->check() || !in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
        return view('errors.403');
    }

    $query = \App\Models\Schedule::with(['bus', 'destination', 'scheduledBy', 'paidBy', 'departedBy']);

    // Search by ID, UID, Bus ID
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('id', $search)
              ->orWhere('schedule_uid', 'like', "%$search%")
              ->orWhere('bus_id', $search);
        });
    }

    // Filter by destination
    if ($request->filled('destination_id')) {
        $query->where('destination_id', $request->destination_id);
    }

    // Filter by bus
    if ($request->filled('bus_id')) {
        $query->where('bus_id', $request->bus_id);
    }

    // Filter by status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter by scheduled_by
    if ($request->filled('scheduled_by')) {
        $query->where('scheduled_by', $request->scheduled_by);
    }

    // Filter by date range (scheduled_at)
    if ($request->filled('from_date')) {
        $query->whereDate('scheduled_at', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('scheduled_at', '<=', $request->to_date);
    }

    // For filter dropdowns
  $perPage = $request->input('per_page', 20); // default 20
    $buses = \App\Models\Bus::all();
    $destinations = \App\Models\Destination::all();
    $users = \App\Models\User::all();

    $schedules = $query->orderByDesc('created_at')->paginate($perPage)->appends($request->all());

    return view('admin.reports.scheduleReports', compact('schedules', 'buses', 'destinations', 'users'));
}
}