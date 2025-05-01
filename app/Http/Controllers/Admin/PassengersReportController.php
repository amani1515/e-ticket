<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Destination;
use Carbon\Carbon;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PassengersExport;
use App\Exports\PassengerReportExport;

class PassengersReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query()->with('destination');

        // Search by Ticket ID
        if ($request->filled('search')) {
            $query->where('id', $request->search);
        }

        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by destination
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }

        // Filter by date
        if ($request->filled('date_filter')) {
            $now = Carbon::now();
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', $now);
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', $now->subDay());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', $now->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', $now->year);
                    break;
            }
        }

        $tickets = $query->latest()->paginate(10);
        $destinations = Destination::all();

        return view('admin.reports.passengers', compact('tickets', 'destinations'));
    }

    public function show($id)
    {
        $ticket = Ticket::with('destination')->findOrFail($id);
        return view('admin.reports.passenger_show', compact('ticket'));
    }

    public function destroy($id)
    {
        Ticket::findOrFail($id)->delete();
        return redirect()->route('admin.passenger-report')->with('success', 'Passenger record deleted.');
    }

 


    


public function export(Request $request)
{
    $tickets = Ticket::with('destination')->get(); // Add filters if needed

    $summaries = [
        'total_tariff' => $tickets->sum(fn($t) => $t->destination->tariff ?? 0),
        'total_tax' => $tickets->sum(fn($t) => $t->destination->tax ?? 0),
        'total_service_fee' => $tickets->sum(fn($t) => $t->destination->service_fee ?? 0),
        'male' => $tickets->where('gender', 'male')->count(),
        'female' => $tickets->where('gender', 'female')->count(),
        'adult' => $tickets->where('age_status', 'adult')->count(),
        'baby' => $tickets->where('age_status', 'baby')->count(),
        'senior' => $tickets->where('age_status', 'senior')->count(),
        'by_destination' => $tickets->groupBy('destination.destination_name')->map->count(),
    ];

    return Excel::download(new PassengerReportExport($tickets, $summaries), 'passenger_report.xlsx');
}

    
}
