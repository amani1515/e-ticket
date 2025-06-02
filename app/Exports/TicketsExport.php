<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TicketsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Ticket::with('destination')->get()->map(function ($ticket) {
            return [
                'Ticket ID' => $ticket->id,
                'Passenger Name' => $ticket->passenger_name,
                'Age' => ucfirst($ticket->age_status),
                'Destination' => $ticket->destination->start_from . ' → ' . $ticket->destination->destination_name,
                'Bus' => $ticket->bus_id,
                'Departure' => $ticket->departure_datetime,
                'Status' => ucfirst($ticket->ticket_status),
                'Code' => $ticket->ticket_code,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Ticket ID',
            'Passenger Name',
            'Age',
            'Destination',
            'Bus',
            'Departure',
            'Status',
            'Code',
        ];
    }
}