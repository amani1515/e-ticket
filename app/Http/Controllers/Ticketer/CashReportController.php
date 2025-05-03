<?php

namespace App\Http\Controllers\Ticketer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashReport;
use App\Models\Ticket;
use Carbon\Carbon;

class CashReportController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();
    
        // Calculate total amount for unreported tickets
        $totalAmount = Ticket::where('creator_user_id', $user->id)
            ->where('reported', false)
            ->join('destinations', 'tickets.destination_id', '=', 'destinations.id')
            ->sum(\DB::raw('destinations.tax + destinations.service_fee'));
    
        $alreadySubmitted = CashReport::where('user_id', $user->id)
            ->whereDate('report_date', Carbon::today())
            ->exists();
    
        return view('ticketer.cash_report.index', compact('totalAmount', 'alreadySubmitted'));
    }


    public function submit(Request $request)
{
    $user = auth()->user();
    $today = Carbon::today();

    // Calculate total tax, service fee, and total amount for unreported tickets
    $reportData = Ticket::where('creator_user_id', $user->id)
        ->where('reported', false) // Only include unreported tickets
        ->join('destinations', 'tickets.destination_id', '=', 'destinations.id')
        ->selectRaw('SUM(destinations.tax) as total_tax, SUM(destinations.service_fee) as total_service_fee, SUM(destinations.tariff + destinations.tax + destinations.service_fee) as total_amount')
        ->first();

    if ($reportData->total_amount > 0) {
        // Create a new cash report
        $cashReport = CashReport::create([
            'user_id' => $user->id,
            'report_date' => $today,
            'total_amount' => $reportData->total_amount,
            'tax' => $reportData->total_tax,
            'service_fee' => $reportData->total_service_fee,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);

        // Mark the tickets as reported
        Ticket::where('creator_user_id', $user->id)
            ->where('reported', false)
            ->update(['reported' => true]);
    }

    return redirect()->back()->with('success', 'Cash report submitted successfully.');
}

    //admin permissions
    // Show all submitted cash reports to admin
public function adminIndex()
{
    $reports = CashReport::with('user')->latest()->get();
    return view('admin.cash_reports.index', compact('reports'));
}

// Admin marks a report as received
public function markAsReceived($id)
{
    $report = CashReport::findOrFail($id);
    $report->status = 'received';
    $report->save();

    return redirect()->back()->with('success', 'Cash report marked as received.');
}

}
