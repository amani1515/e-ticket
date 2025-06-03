<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TicketsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Ticket::query()->with('destination');

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
            $now = now();
            switch ($this->filters['date_filter']) {
                case 'today':
                    $query->whereDate('created_at', $now);
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', $now->subDay());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'two_days_before':
                    $query->whereDate('created_at', $now->subDays(2));
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', $now->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', $now->year);
                    break;
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Gender',
            'Destination',
            'Age Status',
            'Bus ID',
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->id,
            $ticket->passenger_name,
            $ticket->gender,
            $ticket->destination->destination_name ?? '-',
            $ticket->age_status,
            $ticket->bus_id,
        ];
    }
}