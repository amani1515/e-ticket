<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Destination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardReportsController extends Controller
{

    
public function index()
{
    if (Auth::id()) {
        $usertype = Auth::user()->usertype;

        if ($usertype == 'admin') {
            $today = now()->toDateString();

            // Summary counts
            $passengersToday = \App\Models\Ticket::whereDate('created_at', $today)->count();
            $totalUsers = \App\Models\User::count();
            $totalDestinations = \App\Models\Destination::count();

            // Today's tickets with destination
            $todayTickets = \App\Models\Ticket::with('destination')->whereDate('created_at', $today)->get();

            $taxTotal = $todayTickets->sum(fn($t) => $t->destination->tax ?? 0);
            $serviceFeeTotal = $todayTickets->sum(fn($t) => $t->destination->service_fee ?? 0);
            $tariffTotal = $todayTickets->sum(fn($t) => $t->destination->tariff ?? 0);

            $totalRevenue = $taxTotal + $serviceFeeTotal + $tariffTotal;

            // Passengers by destination
            $grouped = $todayTickets->groupBy('destination.destination_name');
            $destinationLabels = $grouped->keys();
            $passengerCounts = $grouped->map->count();

            // Passengers by gender
$genderLabels = ['Male', 'Female'];
$genderCounts = [
    \App\Models\Ticket::whereDate('created_at', $today)->where('gender', 'male')->count(),
    \App\Models\Ticket::whereDate('created_at', $today)->where('gender', 'female')->count(),
];

            // Passengers by age status
            $ageStatuses = \App\Models\Ticket::whereDate('created_at', $today)->pluck('age_status')->unique()->values();
            $ageStatusLabels = $ageStatuses->toArray();
            $ageStatusCounts = $ageStatuses->map(function ($status) use ($today) {
                return \App\Models\Ticket::whereDate('created_at', $today)->where('age_status', $status)->count();
            })->toArray();
            

            // Passengers by disability status
            $disabilityLabels = ['None', 'Blind / Visual Impairment', 'Deaf / Hard of Hearing', 'Speech Impairment'];
            $disabilityCounts = DB::table('tickets')
                ->select('disability_status', DB::raw('count(*) as total'))
                ->whereDate('created_at', $today)
                ->groupBy('disability_status')
                ->pluck('total', 'disability_status')
                ->toArray();

            $disabilityCounts = array_map(function($label) use ($disabilityCounts) {
                return $disabilityCounts[$label] ?? 0;
            }, $disabilityLabels);


return view('admin.index', compact(
    'passengersToday',
    'totalUsers',
    'totalDestinations',
    'taxTotal',
    'serviceFeeTotal',
    'totalRevenue',
    'destinationLabels',
    'passengerCounts',
    'genderLabels',
    'genderCounts',
    'ageStatusLabels',
    'ageStatusCounts',
     'disabilityLabels',
    'disabilityCounts' 
));
        } else {
            return view('errors.403');
        }
    }
    // If not authenticated, redirect or show error
    return redirect('/login');
}
}
