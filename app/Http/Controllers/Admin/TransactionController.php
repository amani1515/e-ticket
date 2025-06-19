<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;   
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Destination;

class TransactionController extends Controller
{
   public function index(Request $request)
{
    if 
    $query = Transaction::query();

    if ($request->filled('level')) {
        $query->where('level', $request->level);
    }

    if ($request->filled('date_filter')) {
        switch ($request->date_filter) {
            case 'today':
                $query->whereDate('created_at', today());
                break;
            case 'thisweek':
                $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'thismonth':
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                break;
            case 'thisyear':
                $query->whereYear('created_at', now()->year);
                break;
        }
    }

    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('created_at', [
            $request->date_from . ' 00:00:00',
            $request->date_to . ' 23:59:59'
        ]);
    }

    // Total amount after filter
    $totalAmount = $query->sum('amount');

    // Paginated result
    $transactions = $query->orderBy('created_at', 'desc')->paginate(20)->appends($request->except('page'));

    return view('admin.reports.transactions', [
        'transactions' => $transactions,
        'totalAmount' => $totalAmount,
        'filters' => $request->only(['level', 'date_filter', 'date_from', 'date_to']),
    ]);
}


}
