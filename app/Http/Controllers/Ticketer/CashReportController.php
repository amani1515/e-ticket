<?php

namespace App\Http\Controllers\Ticketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashReport;
use App\Models\Ticket;
use Carbon\Carbon;
use App\Services\UuidService;

// CashReportController handles cash reporting for ticketers and admin review.
// Ticketers can view, calculate, and submit daily cash reports for their tickets.
// Admins can view all reports and mark them as received.
class CashReportController extends Controller
{
   
    // Show the cash report page for the current ticketer
    public function index()
    {
        // Ensure the user is tiketer
        if (auth()->user()->usertype !== 'ticketer') {
            return view('errors.403'); // Forbidden access for non-ticketers
        }
        $user = auth()->user();

        // Get all unreported tickets for this user, including cargo info
        $tickets = Ticket::with('cargo')
            ->where('creator_user_id', $user->id)
            ->where('reported', false)
            ->join('destinations', 'tickets.destination_id', '=', 'destinations.id')
            ->select('tickets.*', 'destinations.tax', 'destinations.service_fee')
            ->get();

        // Calculate the total amount for all unreported tickets (including cargo)
        $totalAmount = 0;
        foreach ($tickets as $ticket) {
            $ticketTotal = $ticket->tax + $ticket->service_fee;
            if ($ticket->cargo) {
                $ticketTotal += ($ticket->cargo->tax ?? 0) + ($ticket->cargo->service_fee ?? 0);
            }
            $totalAmount += $ticketTotal;
        }

        // Check if the user has already submitted a report today
        $alreadySubmitted = CashReport::where('user_id', $user->id)
            ->whereDate('report_date', Carbon::today())
            ->exists();

        // Show the cash report view with total amount and submission status
        return view('ticketer.cash_report.index', compact('totalAmount', 'alreadySubmitted'));
    }

    // Handle submission of the daily cash report by the ticketer
    public function submit(Request $request)
    {

        if (auth()->user()->usertype !== 'ticketer') {
            return view('errors.403'); // Forbidden access for non-ticketers
        }
        $user = auth()->user();
        $today = Carbon::today();

        // Calculate total tax, service fee, and total amount for unreported tickets
        $reportData = Ticket::where('creator_user_id', $user->id)
            ->where('reported', false) // Only include unreported tickets
            ->join('destinations', 'tickets.destination_id', '=', 'destinations.id')
            ->selectRaw('SUM(destinations.tax) as total_tax, SUM(destinations.service_fee) as total_service_fee, SUM(destinations.tariff + destinations.tax + destinations.service_fee) as total_amount')
            ->first();

        if ($reportData->total_amount > 0) {
            // Create a new cash report for today
            $cashReport = CashReport::create([
                'uuid' => UuidService::generate('cash_report', ['user_name' => $user->name]),
                'user_id' => $user->id,
                'report_date' => $today,
                'total_amount' => $reportData->total_amount,
                'tax' => $reportData->total_tax,
                'service_fee' => $reportData->total_service_fee,
                'status' => 'pending',
                'submitted_at' => now(),
            ]);
            
            // Manually trigger sync since this is created without Syncable events
            $cashReport->addToSyncQueue('create');

            // Mark the tickets as reported so they are not included in future reports
            Ticket::where('creator_user_id', $user->id)
                ->where('reported', false)
                ->update(['reported' => true]);
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Cash report submitted successfully.');
    }

    // Show list of submitted cash reports for current ticketer
    public function list(Request $request)
    {
        if (auth()->user()->usertype !== 'ticketer') {
            return view('errors.403');
        }

        $user = auth()->user();
        $filter = $request->get('filter', 'all');
        
        $query = CashReport::where('user_id', $user->id);
        
        // Apply date filters
        if ($filter === 'today') {
            $query->whereDate('report_date', today());
        } elseif ($filter === 'week') {
            $query->whereBetween('report_date', [now()->startOfWeek(), now()->endOfWeek()]);
        }
        
        $reports = $query->orderBy('report_date', 'desc')->paginate(10);
        
        return view('ticketer.cash_report.list', compact('reports', 'filter'));
    }

    // Show receipt for cash report
    public function receipt($id)
    {
        if (auth()->user()->usertype !== 'ticketer') {
            return view('errors.403');
        }

        $report = CashReport::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'received')
            ->firstOrFail();

        return view('ticketer.cash_report.receipt', compact('report'));
    }

    // ADMIN PERMISSIONS
    // Show all submitted cash reports to admin for review
    public function adminIndex()
    {
        // Ensure the user is admin
        if (auth()->user()->usertype !== 'admin') {
            return view('errors.403'); // Forbidden access for non-admins
        }
        $reports = CashReport::with('user')->latest()->get();
        return view('admin.cash_reports.index', compact('reports'));
    }

    // Admin marks a report as received (status update)
    public function markAsReceived($id)
    {
        // Ensure the user is admin
        if (auth()->user()->usertype !== 'admin') { 
            return view('errors.403'); // Forbidden access for non-admins
        }   
        $report = CashReport::findOrFail($id);
        $report->status = 'received';
        $report->save();

        return redirect()->back()->with('success', 'Cash report marked as received.');
    }

}
