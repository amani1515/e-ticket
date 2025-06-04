<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Destination;
use Carbon\Carbon;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PassengersReportController extends Controller
{

    public function index(Request $request)
    {

        if(auth::id())
        {
         $usertype = Auth::user()->usertype;
         if($usertype == 'admin')
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
        else 
        {
           return view('errors.403');
        }
       
       }
    }

    public function show($id)
    {
        if(auth::id())
        {
         $usertype = Auth::user()->usertype;
         if($usertype == 'admin')
         {
        $ticket = Ticket::with('destination')->findOrFail($id);
        return view('admin.reports.passenger_show', compact('ticket'));
    
    }
    else 
    {
       return view('errors.403');
    }
   
   }
    }

    public function destroy($id)
    {

        if(auth::id())
        {
         $usertype = Auth::user()->usertype;
         if($usertype == 'admin')
         {
        Ticket::findOrFail($id)->delete();
        return redirect()->route('admin.passenger-report')->with('success', 'Passenger record deleted.');
    
    
    
        }
        else 
        {
        return view('errors.403');
        }
   
   }}

    public function export(Request $request)
    {
        if (!Auth::check() || Auth::user()->usertype !== 'admin') {
            return response()->view('errors.403', [], 403);
        }

        try {
            $filters = $request->only(['search', 'gender', 'destination_id', 'date_filter']);
            $fileName = 'tickets-export-' . now()->format('Y-m-d') . '.xlsx';
            
            return Excel::download(new TicketsExport($filters), $fileName);
        } catch (\Exception $e) {
            Log::error('Excel export failed: ' . $e->getMessage());
            return back()->with('error', 'Export failed. Please try again.');
        }
    }
}
