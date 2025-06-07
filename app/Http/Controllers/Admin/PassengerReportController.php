<?php
namespace App\Http\Controllers\Admin;


use App\Models\Ticket;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Models\Destination;

use Illuminate\Support\Facades\Auth;

class PassengerReportController extends Controller
{
    
    public function index(Request $request)
    {
        // Allow both admin and headoffice to view
        if (!auth()->check() || !in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
            return view('errors.403');
        }

        $destinations = Destination::all(); // Fetch all destinations
        $filters = $request->all();
    
        $query = Ticket::query();
    
        // Apply filters (if any)
        if (!empty($filters['search'])) {
            $query->where('id', $filters['search']);
        }
    
        if (!empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }
    
        if (!empty($filters['destination_id'])) {
            $query->where('destination_id', $filters['destination_id']);
        }
    
        if (!empty($filters['date_filter'])) {
            switch ($filters['date_filter']) {
                case 'today':
                    $query->whereDate('created_at', now()->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', now()->subDay()->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', now()->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
        }
    
        $tickets = $query->paginate(10); // Paginate the results
    
        return view('admin.reports.passengers', compact('tickets', 'destinations'));
    }

    public function printAll(Request $request)
    {
        // Allow both admin and headoffice to view
        if (!auth()->check() || !in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
            return view('errors.403');
        }

        $query = Ticket::query();
        // Apply filters as in your main report...
        // $query->where(...);
        $tickets = $query->with('destination')->get(); // No paginate()
        return view('admin.reports.passengers_print', compact('tickets'));
    }

    // this show function is used for show passengers detail for admin and headoffice
    public function show($id)
    {
        // Allow both admin and headoffice to view
        if (!auth()->check() || !in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
            return view('errors.403');
        }

        $ticket = Ticket::with(['destination', 'bus', 'schedule', 'cargo'])->findOrFail($id);
        return view('admin.passenger.passenger_detail', compact('ticket'));
    }
}