<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Destination;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class DashboardReportsController extends Controller
{
    public function index()
    {

        if(auth::id())
        {
         $usertype = Auth::user()->usertype;

         if($usertype == 'admin')
         {
 // 👇 Reporting logic moved into ticketer block
                    $today = \Carbon\Carbon::today();
                        
                    $passengersToday = \App\Models\Ticket::whereDate('created_at', $today)->count();
                    $totalUsers = \App\Models\User::count();
                    $totalDestinations = \App\Models\Destination::count();

                    $todayTickets = \App\Models\Ticket::with('destination')->whereDate('created_at', $today)->get();

                    $taxTotal = $todayTickets->sum(fn($t) => $t->destination->tax ?? 0);
                    $serviceFeeTotal = $todayTickets->sum(fn($t) => $t->destination->service_fee ?? 0);
                    $tariffTotal = $todayTickets->sum(fn($t) => $t->destination->tariff ?? 0);

                    $totalRevenue = $taxTotal + $serviceFeeTotal + $tariffTotal;

                    $grouped = $todayTickets->groupBy('destination.destination_name');
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
                        'passengerCounts'
                    ));      
         }

         else 
         {
             return view('errors.403');
         }
         
        }
       
    }
}
