<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HeadOfficeAdminReadOnlyController extends Controller
{
    // Dashboard (admin.index -> headOffice.index)
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        if (!$user || !in_array($user->usertype, ['admin_readonly', 'headoffice'])) {
            abort(403);
        }

        // Copy logic from AdminController@index for admin (readonly)
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
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
        $genderLabels = ['Male', 'Female'];
        $genderCounts = [
            $tickets->where('gender', 'male')->count(),
            $tickets->where('gender', 'female')->count(),
        ];
        $ageStatuses = $tickets->pluck('age_status')->unique()->values();
        $ageStatusLabels = $ageStatuses->toArray();
        $ageStatusCounts = $ageStatuses->map(function ($status) use ($tickets) {
            return $tickets->where('age_status', $status)->count();
        })->toArray();
        return view('headOffice.index', compact(
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
            'ageStatusCounts'
        ));
    }

    // Add more methods for each admin page as needed, all returning headOffice views in read-only mode
}
