<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

namespace App\Exports;

use App\Models\Ticket;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PassengersExport implements FromView
{
    protected $filteredTickets;
    protected $summaries;

    public function __construct($filteredTickets, $summaries)
    {
        $this->filteredTickets = $filteredTickets;
        $this->summaries = $summaries;
    }

    public function view(): View
    {
        return view('admin.exports.passenger_report', [
            'tickets' => $this->filteredTickets,
            'summaries' => $this->summaries,
        ]);
    }
}
