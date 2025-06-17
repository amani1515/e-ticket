<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        if(auth::id())
        {
            $usertype = Auth::user()->usertype;

            if($usertype == 'user')
            {
                return view('dashboard');
            }
            else if($usertype == 'mahberat')
            {
                return view('mahberat.index');}

            else if($usertype == 'balehabt') {
        $buses = \App\Models\Bus::where('owner_id', Auth::id())->get();
        return view('balehabt.index', compact('buses'));
    }
            elseif($usertype == 'traffic')
            {
                return view('traffic.index');
            }

elseif($usertype == 'headoffice' || $usertype == 'admin')
{
    $startDate = request('start_date');
    $endDate = request('end_date');

    // Default: today's date if no date range provided
    if ($startDate && $endDate) {
        $tickets = \App\Models\Ticket::with('destination')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();
    } else {
        $today = \Carbon\Carbon::today();
        $tickets = \App\Models\Ticket::with('destination')
            ->whereDate('created_at', $today)
            ->get();
        $startDate = $endDate = $today->toDateString();
    }

    $passengersToday = $tickets->count();
    $totalUsers = \App\Models\User::count();
    $totalDestinations = \App\Models\Destination::count();

    $taxTotal = $tickets->sum(fn($t) => $t->destination->tax ?? 0);
    $serviceFeeTotal = $tickets->sum(fn($t) => $t->destination->service_fee ?? 0);
    $tariffTotal = $tickets->sum(fn($t) => $t->destination->tariff ?? 0);
    $totalRevenue = $taxTotal + $serviceFeeTotal + $tariffTotal;

    $grouped = $tickets->groupBy('destination.destination_name');
    $destinationLabels = $grouped->keys();
    $passengerCounts = $grouped->map->count();

    // Passengers by gender
    $genderLabels = ['Male', 'Female'];
    $genderCounts = [
        $tickets->where('gender', 'male')->count(),
        $tickets->where('gender', 'female')->count(),
    ];

    // Passengers by age status
    $ageStatuses = $tickets->pluck('age_status')->unique()->values();
    $ageStatusLabels = $ageStatuses->toArray();
    $ageStatusCounts = $ageStatuses->map(function ($status) use ($tickets) {
        return $tickets->where('age_status', $status)->count();
    })->toArray();

    // Passengers by disability status
    $disabilityLabels = ['None', 'Blind / Visual Impairment', 'Deaf / Hard of Hearing', 'Speech Impairment'];
    $disabilityCounts = $tickets->groupBy('disability_status')->map->count()->toArray();
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
        'startDate',
        'endDate',
        'genderLabels',
        'genderCounts',
        'ageStatusLabels',
        'ageStatusCounts',
        'disabilityLabels',
        'disabilityCounts'
    ));
}

            else if($usertype == 'ticketer')
            {
                return view('ticketer.index');
            }
            else if($usertype == 'cargoMan')
            {
                return view('cargoMan.index');
            }
             else if($usertype == 'hisabshum')
            {
                return view('hisabShum.index');
            }
            else
            {
                return redirect()->back();
            }
        }
        
    }
}