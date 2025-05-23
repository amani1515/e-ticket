<?php
namespace App\Http\Controllers\Admin;

use App\Exports\PassengersExport;
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
}