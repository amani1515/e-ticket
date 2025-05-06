<?php
// filepath: app/Exports/PassengerReportExport.php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

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
        return view('admin.reports.passengers', [
            'tickets' => $this->tickets,
            'summaries' => $this->summaries,
        ]);
    }
}