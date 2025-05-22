<?php
namespace App\Http\Controllers\HisabShum;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Models\User;



class AllReportController extends Controller
{
public function index(Request $request)
{
    $query = \App\Models\Schedule::with(['bus', 'destination', 'departedBy'])
        ->where('status', 'departed');

    // Filters
    if ($request->filled('from_date')) {
        $query->whereDate('departed_at', '>=', $request->from_date);
    }
    if ($request->filled('to_date')) {
        $query->whereDate('departed_at', '<=', $request->to_date);
    }
    if ($request->filled('bus_id')) {
        $query->where('bus_id', $request->bus_id);
    }
    if ($request->filled('destination_id')) {
        $query->where('destination_id', $request->destination_id);
    }
    if ($request->filled('departed_by')) {
        $query->where('departed_by', $request->departed_by);
    }

    $schedules = $query->orderByDesc('departed_at')->paginate(10);

    // For filter dropdowns
    $buses = \App\Models\Bus::all();
    $destinations = \App\Models\Destination::all();
$users = User::where('usertype', 'hisabshum')->get();
return view('hisabShum.allReports', compact('schedules', 'buses', 'destinations', 'users'));}
}