<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class TicketsExport implements WithMultipleSheets
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function sheets(): array
    {
        return [
            new PassengerDataSheet($this->filters),
            new SummarySheet($this->filters),
            new ChartsDataSheet($this->filters),
        ];
    }
}

class PassengerDataSheet implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Passenger Data';
    }

    public function query()
    {
        $query = Ticket::query()->with(['destination', 'bus', 'schedule']);

        if (!empty($this->filters['search'])) {
            $query->where(function($q) {
                $q->where('id', $this->filters['search'])
                  ->orWhere('passenger_name', 'like', '%' . $this->filters['search'] . '%');
            });
        }

        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }

        if (!empty($this->filters['destination_id'])) {
            $query->where('destination_id', $this->filters['destination_id']);
        }

        if (!empty($this->filters['age_status'])) {
            $query->where('age_status', $this->filters['age_status']);
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
                case 'this_month':
                    $query->whereMonth('created_at', $now->month);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', $now->year);
                    break;
            }
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'Ticket ID',
            'Passenger Name',
            'Phone Number',
            'Gender',
            'Age Status',
            'Destination',
            'Bus Number',
            'Seat Number',
            'Ticket Price (ETB)',
            'Booking Date',
            'Travel Date',
            'Status',
            'Payment Method'
        ];
    }

    public function map($ticket): array
    {
        return [
            $ticket->id,
            $ticket->passenger_name,
            $ticket->phone_number ?? 'N/A',
            ucfirst($ticket->gender),
            ucfirst(str_replace('_', ' ', $ticket->age_status)),
            $ticket->destination->destination_name ?? 'N/A',
            $ticket->bus->bus_number ?? 'N/A',
            $ticket->seat_number ?? 'N/A',
            number_format($ticket->ticket_price ?? 0, 2),
            $ticket->created_at->format('Y-m-d H:i'),
            $ticket->schedule->departure_time ?? 'N/A',
            ucfirst($ticket->ticket_status ?? 'Active'),
            $ticket->payment_method ?? 'Cash'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header styling
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3B82F6']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ]);

        // Auto-size columns
        foreach (range('A', 'M') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Set row height for header
        $sheet->getRowDimension(1)->setRowHeight(25);

        // Apply alternating row colors
        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:M{$row}")->applyFromArray([
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F8FAFC']
                    ]
                ]);
            }
        }

        return [];
    }
}

class SummarySheet implements WithTitle, WithStyles
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Summary Report';
    }

    public function styles(Worksheet $sheet)
    {
        // Get summary data
        $query = Ticket::query()->with('destination');
        $this->applyFilters($query);
        $tickets = $query->get();

        // Create summary data
        $totalPassengers = $tickets->count();
        $maleCount = $tickets->where('gender', 'male')->count();
        $femaleCount = $tickets->where('gender', 'female')->count();
        $totalRevenue = $tickets->sum('ticket_price');
        $avgTicketPrice = $tickets->avg('ticket_price');
        $topDestination = $tickets->groupBy('destination.destination_name')->sortByDesc(function($group) {
            return $group->count();
        })->keys()->first();

        // Add summary data to sheet
        $sheet->setCellValue('A1', 'PASSENGER REPORT SUMMARY');
        $sheet->mergeCells('A1:D1');
        
        $sheet->setCellValue('A3', 'Report Overview');
        $sheet->setCellValue('A4', 'Total Passengers:');
        $sheet->setCellValue('B4', $totalPassengers);
        $sheet->setCellValue('A5', 'Male Passengers:');
        $sheet->setCellValue('B5', $maleCount . ' (' . ($totalPassengers > 0 ? round(($maleCount/$totalPassengers)*100, 1) : 0) . '%)');
        $sheet->setCellValue('A6', 'Female Passengers:');
        $sheet->setCellValue('B6', $femaleCount . ' (' . ($totalPassengers > 0 ? round(($femaleCount/$totalPassengers)*100, 1) : 0) . '%)');
        $sheet->setCellValue('A7', 'Total Revenue:');
        $sheet->setCellValue('B7', number_format($totalRevenue, 2) . ' ETB');
        $sheet->setCellValue('A8', 'Average Ticket Price:');
        $sheet->setCellValue('B8', number_format($avgTicketPrice, 2) . ' ETB');
        $sheet->setCellValue('A9', 'Top Destination:');
        $sheet->setCellValue('B9', $topDestination ?? 'N/A');
        $sheet->setCellValue('A10', 'Report Generated:');
        $sheet->setCellValue('B10', now()->format('Y-m-d H:i:s'));

        // Age distribution
        $ageData = $tickets->groupBy('age_status')->map->count();
        $row = 12;
        $sheet->setCellValue('A' . $row, 'Age Distribution');
        $row++;
        foreach ($ageData as $age => $count) {
            $sheet->setCellValue('A' . $row, ucfirst(str_replace('_', ' ', $age)) . ':');
            $sheet->setCellValue('B' . $row, $count . ' (' . ($totalPassengers > 0 ? round(($count/$totalPassengers)*100, 1) : 0) . '%)');
            $row++;
        }

        // Style the summary
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 18, 'color' => ['rgb' => '1F2937']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ]
        ]);

        $sheet->getStyle('A3')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '3B82F6']]
        ]);

        $sheet->getStyle('A12')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '3B82F6']]
        ]);

        $sheet->getStyle('A4:A' . ($row-1))->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '374151']]
        ]);

        $sheet->getStyle('B4:B' . ($row-1))->applyFromArray([
            'font' => ['color' => ['rgb' => '059669']]
        ]);

        // Auto-size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);

        return [];
    }

    private function applyFilters($query)
    {
        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }
        if (!empty($this->filters['destination_id'])) {
            $query->where('destination_id', $this->filters['destination_id']);
        }
        if (!empty($this->filters['age_status'])) {
            $query->where('age_status', $this->filters['age_status']);
        }
        if (!empty($this->filters['date_filter'])) {
            $now = now();
            switch ($this->filters['date_filter']) {
                case 'today':
                    $query->whereDate('created_at', $now);
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', $now->month);
                    break;
            }
        }
    }
}

class ChartsDataSheet implements WithTitle, WithStyles
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function title(): string
    {
        return 'Charts Data';
    }

    public function styles(Worksheet $sheet)
    {
        // Get data for charts
        $query = Ticket::query()->with('destination');
        $this->applyFilters($query);
        $tickets = $query->get();

        // Gender Distribution Data
        $genderData = $tickets->groupBy('gender')->map->count();
        $sheet->setCellValue('A1', 'Gender Distribution');
        $sheet->setCellValue('A2', 'Gender');
        $sheet->setCellValue('B2', 'Count');
        $row = 3;
        foreach ($genderData as $gender => $count) {
            $sheet->setCellValue('A' . $row, ucfirst($gender));
            $sheet->setCellValue('B' . $row, $count);
            $row++;
        }

        // Destination Distribution Data
        $destinationData = $tickets->groupBy('destination.destination_name')->map->count();
        $sheet->setCellValue('D1', 'Destination Distribution');
        $sheet->setCellValue('D2', 'Destination');
        $sheet->setCellValue('E2', 'Count');
        $row = 3;
        foreach ($destinationData as $destination => $count) {
            $sheet->setCellValue('D' . $row, $destination ?? 'Unknown');
            $sheet->setCellValue('E' . $row, $count);
            $row++;
        }

        // Age Distribution Data
        $ageData = $tickets->groupBy('age_status')->map->count();
        $sheet->setCellValue('G1', 'Age Distribution');
        $sheet->setCellValue('G2', 'Age Group');
        $sheet->setCellValue('H2', 'Count');
        $row = 3;
        foreach ($ageData as $age => $count) {
            $sheet->setCellValue('G' . $row, ucfirst(str_replace('_', ' ', $age)));
            $sheet->setCellValue('H' . $row, $count);
            $row++;
        }

        // Style headers
        $sheet->getStyle('A1:H2')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '1F2937']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E5E7EB']
            ]
        ]);

        // Auto-size columns
        foreach (range('A', 'H') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        return [];
    }

    private function applyFilters($query)
    {
        if (!empty($this->filters['gender'])) {
            $query->where('gender', $this->filters['gender']);
        }
        if (!empty($this->filters['destination_id'])) {
            $query->where('destination_id', $this->filters['destination_id']);
        }
        if (!empty($this->filters['age_status'])) {
            $query->where('age_status', $this->filters['age_status']);
        }
        if (!empty($this->filters['date_filter'])) {
            $now = now();
            switch ($this->filters['date_filter']) {
                case 'today':
                    $query->whereDate('created_at', $now);
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', $now->month);
                    break;
            }
        }
    }
}