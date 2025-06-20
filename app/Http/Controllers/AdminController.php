<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import the User model

// AdminController handles dashboard routing and statistics for different user roles
class AdminController extends Controller
{
    // Main entry point after login; routes user to the correct dashboard based on usertype
    public function index()
    {
        // Check if a user is authenticated
        if(auth::id())
        {
            // Get the type of the authenticated user
            $usertype = Auth::user()->usertype;

            // If the user is a regular user, show the standard dashboard
            if($usertype == 'user')
            {
                return view('dashboard');
            }
            // If the user is a mahberat (association), show the mahberat dashboard
            else if($usertype == 'mahberat')
            {
                return view('mahberat.index');}

            // If the user is a balehabt (bus owner), show their buses
            else if($usertype == 'balehabt') {
                // Fetch all buses owned by the current user
                $buses = \App\Models\Bus::where('owner_id', Auth::id())->get();
                return view('balehabt.index', compact('buses'));
            }
            // If the user is a traffic officer, show the traffic dashboard
            elseif($usertype == 'traffic')
            {
                return view('traffic.index');
            }

            // If the user is a headoffice or admin, show statistics and analytics dashboard
            elseif($usertype == 'headoffice' || $usertype == 'admin')
            {
                // Get date range from request (for filtering reports)
                $startDate = request('start_date');
                $endDate = request('end_date');

                // Default: today's date if no date range provided
                if ($startDate && $endDate) {
                    // Fetch tickets within the date range, including destination info
                    $tickets = \App\Models\Ticket::with('destination')
                        ->whereDate('created_at', '>=', $startDate)
                        ->whereDate('created_at', '<=', $endDate)
                        ->get();
                } else {
                    // If no date range, use today's tickets
                    $today = \Carbon\Carbon::today();
                    $tickets = \App\Models\Ticket::with('destination')
                        ->whereDate('created_at', $today)
                        ->get();
                    $startDate = $endDate = $today->toDateString();
                }

                // Calculate statistics for the dashboard
                $passengersToday = $tickets->count(); // Number of tickets (passengers)
                $totalUsers = \App\Models\User::count(); // Total registered users
                $totalDestinations = \App\Models\Destination::count(); // Total destinations

                // Calculate revenue components from tickets
                $taxTotal = $tickets->sum(fn($t) => $t->destination->tax ?? 0); // Total tax
                $serviceFeeTotal = $tickets->sum(fn($t) => $t->destination->service_fee ?? 0); // Total service fee
                $tariffTotal = $tickets->sum(fn($t) => $t->destination->tariff ?? 0); // Total tariff
                $totalRevenue = $taxTotal + $serviceFeeTotal + $tariffTotal; // Total revenue

                // Group tickets by destination for charting
                $grouped = $tickets->groupBy('destination.destination_name');
                $destinationLabels = $grouped->keys(); // Destination names
                $passengerCounts = $grouped->map->count(); // Passenger count per destination

                // Passengers by gender for charting
                $genderLabels = ['Male', 'Female'];
                $genderCounts = [
                    $tickets->where('gender', 'male')->count(),
                    $tickets->where('gender', 'female')->count(),
                ];

                // Passengers by age status for charting
                $ageStatuses = $tickets->pluck('age_status')->unique()->values();
                $ageStatusLabels = $ageStatuses->toArray();
                $ageStatusCounts = $ageStatuses->map(function ($status) use ($tickets) {
                    return $tickets->where('age_status', $status)->count();
                })->toArray();

                // Passengers by disability status for charting
                $disabilityLabels = ['None', 'Blind / Visual Impairment', 'Deaf / Hard of Hearing', 'Speech Impairment'];
                // Count tickets for each disability status label
                $disabilityCountsCollection = $tickets->groupBy('disability_status')->map(function($group) {
                    return count($group);
                });
                $disabilityCounts = array_map(function($label) use ($disabilityCountsCollection) {
                    return $disabilityCountsCollection[$label] ?? 0;
                }, $disabilityLabels);

                // Return the admin dashboard view with all statistics and chart data
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

            // If the user is a ticketer, show the ticketer dashboard
            else if($usertype == 'ticketer')
            {
                return view('ticketer.index');
            }
            // If the user is a cargo manager, show the cargo dashboard
            else if($usertype == 'cargoMan')
            {
                return view('cargoMan.index');
            }
            // If the user is an accountant (hisabshum), show the accountant dashboard
            else if($usertype == 'hisabshum')
            {
                return view('hisabShum.index');
            }
            // If the user type is not recognized, redirect back
            else
            {
                return redirect()->back();
            }
        }
        // If not authenticated, this block is not reached (middleware should handle it)
    }
}