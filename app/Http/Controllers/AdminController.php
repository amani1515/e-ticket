<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
    
            if ($usertype == 'user') {
                return view('dashboard');
            } 
            elseif ($usertype == 'admin') {
                return redirect('/admin');            } 
            elseif ($usertype == 'ticketer') {
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
    
                return view('ticketer.index', compact(
                    'passengersToday',
                    'totalUsers',
                    'totalDestinations',
                    'taxTotal',
                    'serviceFeeTotal',
                    'totalRevenue',
                    'destinationLabels',
                    'passengerCounts'
                ));
            } else {
                return redirect()->back();
            }
        }
    }
    
}