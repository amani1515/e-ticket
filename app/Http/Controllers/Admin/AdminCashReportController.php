<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CashReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminCashReportController extends Controller
{
    
    public function index(Request $request)
    {
        $query = CashReport::with('user');
    
        // Apply filters
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('report_date', Carbon::today());
                    break;
                    
                case 'yesterday':
                    $query->whereDate('report_date', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('report_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('report_date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('report_date', Carbon::now()->month)
                          ->whereYear('report_date', Carbon::now()->year);
                    break;
                case 'this_year':
                    $query->whereYear('report_date', Carbon::now()->year);
                    break;
                case 'last_year':
                    $query->whereYear('report_date', Carbon::now()->subYear()->year);
                    break;
            }
        }
    
        if ($request->filled('ticketer_id')) {
            $query->where('user_id', $request->ticketer_id);
        }
    
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
    
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('id', $request->search)
                  ->orWhereHas('user', function ($q) use ($request) {
                      $q->where('name', 'like', '%' . $request->search . '%');
                  });
            });
        }
    
        // Fetch filtered reports for pagination
        $reports = $query->latest('report_date')->paginate(10);
    
        // Clone the query for totals calculation
        $totalsQuery = clone $query;
    
        // Remove ordering from the totals query
        $totalsQuery->getQuery()->orders = null;
    
        // Calculate totals for the filtered data
        $totals = $totalsQuery->selectRaw('SUM(total_amount) as grand_total, SUM(tax) as total_tax, SUM(service_fee) as total_service_fee')->first();
    
        // Fetch all ticketers for the dropdown
        $ticketers = \App\Models\User::all();
    
        return view('admin.cash_reports.index', compact('reports', 'totals', 'ticketers'));
    }
    public function markAsReceived($id)
    {
        $report = CashReport::findOrFail($id);
        $report->update(['status' => 'received']);

        return redirect()->back()->with('success', 'Cash report marked as received.');
    }
}