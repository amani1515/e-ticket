<?php
namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PassengersExport implements FromView
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Ticket::with(['destination', 'user', 'bus']); // Include relationships

        // Apply filters
        if (!empty($this->filters['search'])) {
            $query->where('id', $this->filters['search']);
        }

        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }

        if (!empty($this->filters['destination_id'])) {
            $query->where('destination_id', $this->filters['destination_id']);
        }

        if (!empty($this->filters['date_filter'])) {
            switch ($this->filters['date_filter']) {
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

        $tickets = $query->get();

        return view('admin.reports.passengers', compact('tickets'));
    }
}