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
         elseif($usertype == 'hisabshum')
         {
             return view('hisabShum.index');
         }
       else if($usertype == 'admin')
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
        'endDate'
    ));
}
         else if($usertype == 'ticketer')
         {
             return view('ticketer.index');
         }
         
         else
         {
             return redirect()->back();
         }
      
    }
    
}
}