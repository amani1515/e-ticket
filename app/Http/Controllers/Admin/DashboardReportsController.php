<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Destination;
use Illuminate\Support\Carbon;

class DashboardReportsController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $passengersToday = Ticket::whereDate('created_at', $today)->count();
        $totalUsers = User::count();
        $totalDestinations = Destination::count();

        $todayTickets = Ticket::with('destination')->whereDate('created_at', $today)->get();

        $taxTotal = $todayTickets->sum(fn($t) => $t->destination->tax);
        $serviceFeeTotal = $todayTickets->sum(fn($t) => $t->destination->service_fee);
        $tariffTotal = $todayTickets->sum(fn($t) => $t->destination->tariff);

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
}
