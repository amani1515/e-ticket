<?php

namespace App\Exports;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Destination;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class DashboardExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            new DashboardStatsSheet($this->startDate, $this->endDate),
            new ChartsSheet($this->startDate, $this->endDate),
        ];
    }
}

class DashboardStatsSheet implements WithTitle, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function title(): string
    {
        return 'Dashboard Statistics';
    }

    public function styles(Worksheet $sheet)
    {
        // Get filtered tickets
        $query = Ticket::with('destination');
        if ($this->startDate && $this->endDate) {
            $query->whereDate('created_at', '>=', $this->startDate)
                  ->whereDate('created_at', '<=', $this->endDate);
        } else {
            $query->whereDate('created_at', \Carbon\Carbon::today());
        }
        $tickets = $query->get();

        // Calculate statistics
        $passengersToday = $tickets->count();
        $totalUsers = User::count();
        $totalDestinations = Destination::count();
        $taxTotal = $tickets->sum(function($t) {
            return $t->tax ?? $t->destination->tax ?? 0;
        });
        $serviceFeeTotal = $tickets->sum(function($t) {
            return $t->service_fee ?? $t->destination->service_fee ?? 0;
        });
        $tariffTotal = $tickets->sum(function($t) {
            return $t->destination->tariff ?? 0;
        });
        $totalRevenue = $taxTotal + $serviceFeeTotal + $tariffTotal;

        // Header
        $sheet->setCellValue('A1', 'E-TICKET DASHBOARD REPORT');
        $sheet->mergeCells('A1:F1');
        $sheet->setCellValue('A2', 'Generated on: ' . now()->format('F j, Y g:i A'));
        $sheet->mergeCells('A2:F2');
        
        if ($this->startDate && $this->endDate) {
            $sheet->setCellValue('A3', 'Period: ' . $this->startDate . ' to ' . $this->endDate);
        } else {
            $sheet->setCellValue('A3', 'Period: Today (' . \Carbon\Carbon::today()->format('F j, Y') . ')');
        }
        $sheet->mergeCells('A3:F3');

        // Main Statistics Cards
        $row = 5;
        $sheet->setCellValue('A' . $row, '📊 KEY STATISTICS');
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $row += 2;

        // Passengers Today
        $sheet->setCellValue('A' . $row, '👥 Passengers Today');
        $sheet->setCellValue('C' . $row, $passengersToday);
        $sheet->setCellValue('D' . $row, 'Active travelers');
        $row++;

        // Total Users
        $sheet->setCellValue('A' . $row, '👤 Total Users');
        $sheet->setCellValue('C' . $row, $totalUsers);
        $sheet->setCellValue('D' . $row, 'System accounts');
        $row++;

        // Total Destinations
        $sheet->setCellValue('A' . $row, '📍 Total Destinations');
        $sheet->setCellValue('C' . $row, $totalDestinations);
        $sheet->setCellValue('D' . $row, 'Available routes');
        $row++;

        // Today's Tax
        $sheet->setCellValue('A' . $row, '🏛️ Today\'s Tax');
        $sheet->setCellValue('C' . $row, number_format($taxTotal, 2) . ' ETB');
        $sheet->setCellValue('D' . $row, 'Government tax');
        $row++;

        // Service Fee
        $sheet->setCellValue('A' . $row, '⚙️ Service Fee');
        $sheet->setCellValue('C' . $row, number_format($serviceFeeTotal, 2) . ' ETB');
        $sheet->setCellValue('D' . $row, 'Platform fee');
        $row++;

        // Total Revenue
        $sheet->setCellValue('A' . $row, '💰 Total Revenue');
        $sheet->setCellValue('C' . $row, number_format($totalRevenue, 2) . ' ETB');
        $sheet->setCellValue('D' . $row, 'Today\'s earnings');
        $row += 3;

        // Detailed Breakdown
        $sheet->setCellValue('A' . $row, '📈 DETAILED BREAKDOWN');
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $row += 2;

        // Gender Distribution
        $maleCount = $tickets->where('gender', 'male')->count();
        $femaleCount = $tickets->where('gender', 'female')->count();
        
        $sheet->setCellValue('A' . $row, 'Gender Distribution:');
        $row++;
        $sheet->setCellValue('B' . $row, '♂️ Male');
        $sheet->setCellValue('C' . $row, $maleCount);
        $sheet->setCellValue('D' . $row, $passengersToday > 0 ? round(($maleCount/$passengersToday)*100, 1) . '%' : '0%');
        $row++;
        $sheet->setCellValue('B' . $row, '♀️ Female');
        $sheet->setCellValue('C' . $row, $femaleCount);
        $sheet->setCellValue('D' . $row, $passengersToday > 0 ? round(($femaleCount/$passengersToday)*100, 1) . '%' : '0%');
        $row += 2;

        // Age Distribution
        $ageData = $tickets->groupBy('age_status')->map->count();
        $sheet->setCellValue('A' . $row, 'Age Distribution:');
        $row++;
        foreach ($ageData as $age => $count) {
            $sheet->setCellValue('B' . $row, '👶 ' . ucfirst(str_replace('_', ' ', $age)));
            $sheet->setCellValue('C' . $row, $count);
            $sheet->setCellValue('D' . $row, $passengersToday > 0 ? round(($count/$passengersToday)*100, 1) . '%' : '0%');
            $row++;
        }
        $row++;

        // Accessibility Status
        $disabilityData = $tickets->groupBy('disability_status')->map->count();
        $sheet->setCellValue('A' . $row, 'Accessibility Status:');
        $row++;
        foreach ($disabilityData as $disability => $count) {
            $icon = $disability === 'None' ? '✅' : '♿';
            $sheet->setCellValue('B' . $row, $icon . ' ' . ($disability ?: 'None'));
            $sheet->setCellValue('C' . $row, $count);
            $sheet->setCellValue('D' . $row, $passengersToday > 0 ? round(($count/$passengersToday)*100, 1) . '%' : '0%');
            $row++;
        }
        $row++;

        // Top Destinations
        $destinationData = $tickets->groupBy('destination.destination_name')->map->count()->sortDesc()->take(5);
        $sheet->setCellValue('A' . $row, 'Top 5 Destinations:');
        $row++;
        $rank = 1;
        foreach ($destinationData as $destination => $count) {
            $sheet->setCellValue('B' . $row, "#{$rank} {$destination}");
            $sheet->setCellValue('C' . $row, $count);
            $sheet->setCellValue('D' . $row, $passengersToday > 0 ? round(($count/$passengersToday)*100, 1) . '%' : '0%');
            $row++;
            $rank++;
        }

        // Apply styles
        $this->applyStyles($sheet, $row);
        
        return [];
    }

    private function applyStyles(Worksheet $sheet, $lastRow)
    {
        // Main header
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 20, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F2937']]
        ]);

        // Sub headers
        $sheet->getStyle('A2:A3')->applyFromArray([
            'font' => ['italic' => true, 'size' => 12, 'color' => ['rgb' => '6B7280']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Section headers
        $sheet->getStyle('A5')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']]
        ]);

        // Find all section headers and style them
        for ($row = 1; $row <= $lastRow; $row++) {
            $cellValue = $sheet->getCell('A' . $row)->getValue();
            if (strpos($cellValue, '📈') !== false) {
                $sheet->getStyle('A' . $row)->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => 'FFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']]
                ]);
            }
        }

        // Stats values (column C)
        $sheet->getStyle('C7:C12')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '059669']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);

        // Auto-size columns
        foreach (range('A', 'F') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        // Add borders to stats section
        $sheet->getStyle('A7:D12')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB']
                ]
            ]
        ]);
    }
}

class ChartsSheet implements WithTitle, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function title(): string
    {
        return 'Charts & Analytics';
    }

    public function styles(Worksheet $sheet)
    {
        // Get filtered tickets
        $query = Ticket::with('destination');
        if ($this->startDate && $this->endDate) {
            $query->whereDate('created_at', '>=', $this->startDate)
                  ->whereDate('created_at', '<=', $this->endDate);
        } else {
            $query->whereDate('created_at', \Carbon\Carbon::today());
        }
        $tickets = $query->get();

        // Header
        $sheet->setCellValue('A1', '📊 CHARTS & ANALYTICS DATA');
        $sheet->mergeCells('A1:H1');

        // Passengers by Destination Chart Data
        $row = 3;
        $sheet->setCellValue('A' . $row, '🗺️ PASSENGERS BY DESTINATION');
        $sheet->mergeCells('A' . $row . ':C' . $row);
        $row++;
        $sheet->setCellValue('A' . $row, 'Destination');
        $sheet->setCellValue('B' . $row, 'Passengers');
        $sheet->setCellValue('C' . $row, 'Percentage');
        $row++;

        $destinationData = $tickets->groupBy('destination.destination_name')->map->count()->sortDesc();
        $totalPassengers = $tickets->count();
        
        foreach ($destinationData as $destination => $count) {
            $sheet->setCellValue('A' . $row, $destination ?: 'Unknown');
            $sheet->setCellValue('B' . $row, $count);
            $sheet->setCellValue('C' . $row, $totalPassengers > 0 ? round(($count/$totalPassengers)*100, 1) . '%' : '0%');
            $row++;
        }

        // Gender Distribution Chart Data
        $row += 2;
        $sheet->setCellValue('E' . ($row-1), '👥 GENDER DISTRIBUTION');
        $sheet->mergeCells('E' . ($row-1) . ':G' . ($row-1));
        $sheet->setCellValue('E' . $row, 'Gender');
        $sheet->setCellValue('F' . $row, 'Count');
        $sheet->setCellValue('G' . $row, 'Percentage');
        $row++;

        $genderData = $tickets->groupBy('gender')->map->count();
        foreach ($genderData as $gender => $count) {
            $icon = $gender === 'male' ? '♂️' : '♀️';
            $sheet->setCellValue('E' . $row, $icon . ' ' . ucfirst($gender));
            $sheet->setCellValue('F' . $row, $count);
            $sheet->setCellValue('G' . $row, $totalPassengers > 0 ? round(($count/$totalPassengers)*100, 1) . '%' : '0%');
            $row++;
        }

        // Age Distribution Chart Data
        $startRow = 3;
        $sheet->setCellValue('I' . $startRow, '👶 AGE DISTRIBUTION');
        $sheet->mergeCells('I' . $startRow . ':K' . $startRow);
        $startRow++;
        $sheet->setCellValue('I' . $startRow, 'Age Group');
        $sheet->setCellValue('J' . $startRow, 'Count');
        $sheet->setCellValue('K' . $startRow, 'Percentage');
        $startRow++;

        $ageData = $tickets->groupBy('age_status')->map->count();
        foreach ($ageData as $age => $count) {
            $sheet->setCellValue('I' . $startRow, ucfirst(str_replace('_', ' ', $age)));
            $sheet->setCellValue('J' . $startRow, $count);
            $sheet->setCellValue('K' . $startRow, $totalPassengers > 0 ? round(($count/$totalPassengers)*100, 1) . '%' : '0%');
            $startRow++;
        }

        // Accessibility Status Chart Data
        $accessRow = max($row, $startRow) + 2;
        $sheet->setCellValue('A' . $accessRow, '♿ ACCESSIBILITY STATUS');
        $sheet->mergeCells('A' . $accessRow . ':C' . $accessRow);
        $accessRow++;
        $sheet->setCellValue('A' . $accessRow, 'Status');
        $sheet->setCellValue('B' . $accessRow, 'Count');
        $sheet->setCellValue('C' . $accessRow, 'Percentage');
        $accessRow++;

        $disabilityData = $tickets->groupBy('disability_status')->map->count();
        foreach ($disabilityData as $disability => $count) {
            $icon = $disability === 'None' ? '✅' : '♿';
            $sheet->setCellValue('A' . $accessRow, $icon . ' ' . ($disability ?: 'None'));
            $sheet->setCellValue('B' . $accessRow, $count);
            $sheet->setCellValue('C' . $accessRow, $totalPassengers > 0 ? round(($count/$totalPassengers)*100, 1) . '%' : '0%');
            $accessRow++;
        }

        // Apply styles
        $this->applyChartStyles($sheet);
        
        return [];
    }

    private function applyChartStyles(Worksheet $sheet)
    {
        // Main header
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 18, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C3AED']]
        ]);

        // Section headers
        $sectionHeaders = ['A3', 'E3', 'I3'];
        foreach ($sectionHeaders as $cell) {
            $sheet->getStyle($cell)->applyFromArray([
                'font' => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']]
            ]);
        }

        // Column headers
        $sheet->getStyle('A4:K4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => '374151']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F3F4F6']],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D1D5DB']
                ]
            ]
        ]);

        // Auto-size all columns
        foreach (range('A', 'K') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }
}