<?php
namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class PassengerReportExport implements FromView
{
    protected $tickets;
    protected $summaries;

    public function __construct($tickets, $summaries)
    {
        $this->tickets = $tickets;
        $this->summaries = $summaries;
    }

    public function view(): View
    {
        return view('exports.passenger_report', [
            'tickets' => $this->tickets,
            'summaries' => $this->summaries,
        ]);
    }
}
