<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;
use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Destination;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ExportDailyData extends Command
{
    protected $signature = 'export:daily-data {--date=}';
    protected $description = 'Export daily data to transport authority CSV store';

    public function handle()
    {
        $date = $this->option('date') ? Carbon::parse($this->option('date')) : Carbon::yesterday();
        $dateStr = $date->format('Y-m-d');
        
        $this->info("Exporting data for: {$dateStr}");

        try {
            // Export tickets
            $this->exportTickets($date);
            
            // Export buses
            $this->exportBuses($date);
            
            // Export schedules
            $this->exportSchedules($date);
            
            $this->info('Daily export completed successfully');
        } catch (\Exception $e) {
            $this->error('Export failed: ' . $e->getMessage());
        }
    }

    private function exportTickets($date)
    {
        $tickets = Ticket::whereDate('created_at', $date)
            ->with(['destination', 'bus.mahberat', 'creator'])
            ->get();

        $csvData = [];
        $csvData[] = ['ID', 'Passenger Name', 'Phone', 'Gender', 'Age Status', 'Fayda ID', 'From', 'To', 'Tariff', 'Service Fee', 'Total Amount', 'Bus Targa', 'Mahberat', 'Departure DateTime', 'Created At'];

        foreach ($tickets as $ticket) {
            $csvData[] = [
                $ticket->id,
                $ticket->passenger_name,
                $ticket->phone_no,
                $ticket->gender,
                $ticket->age_status,
                $ticket->fayda_id,
                $ticket->destination->start_from,
                $ticket->destination->destination_name,
                $ticket->tariff ?? $ticket->destination->tariff,
                $ticket->destination->service_fee,
                ($ticket->tariff ?? $ticket->destination->tariff) + $ticket->destination->service_fee,
                $ticket->bus->targa ?? $ticket->bus_id,
                $ticket->bus->mahberat->name ?? 'N/A',
                $ticket->departure_datetime,
                $ticket->created_at
            ];
        }

        $this->sendCsvData('tickets', $date->format('Y-m-d'), $csvData);
        $this->info("Exported {$tickets->count()} tickets");
    }

    private function exportBuses($date)
    {
        $buses = Bus::with('mahberat')->get();

        $csvData = [];
        $csvData[] = ['ID', 'Targa', 'Level', 'Capacity', 'Mahberat', 'Status', 'Created At'];

        foreach ($buses as $bus) {
            $csvData[] = [
                $bus->id,
                $bus->targa,
                $bus->level,
                $bus->capacity,
                $bus->mahberat->name ?? 'N/A',
                $bus->status ?? 'active',
                $bus->created_at
            ];
        }

        $this->sendCsvData('buses', $date->format('Y-m-d'), $csvData);
        $this->info("Exported {$buses->count()} buses");
    }

    private function exportSchedules($date)
    {
        $schedules = Schedule::whereDate('created_at', $date)
            ->with(['destination', 'bus.mahberat'])
            ->get();

        $csvData = [];
        $csvData[] = ['ID', 'From', 'To', 'Bus Targa', 'Mahberat', 'Departure DateTime', 'Available Seats', 'Created At'];

        foreach ($schedules as $schedule) {
            $csvData[] = [
                $schedule->id,
                $schedule->destination->start_from,
                $schedule->destination->destination_name,
                $schedule->bus->targa ?? $schedule->bus_id,
                $schedule->bus->mahberat->name ?? 'N/A',
                $schedule->departure_datetime,
                $schedule->available_seats,
                $schedule->created_at
            ];
        }

        $this->sendCsvData('schedules', $date->format('Y-m-d'), $csvData);
        $this->info("Exported {$schedules->count()} schedules");
    }

    private function sendCsvData($type, $date, $csvData)
    {
        $csvContent = '';
        foreach ($csvData as $row) {
            $csvContent .= implode(',', array_map(function($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row)) . "\n";
        }

        $response = Http::timeout(30)->asForm()->post(env('TRANSPORT_API_URL') . '/api/upload-csv', [
            'type' => $type,
            'date' => $date,
            'csv_data' => $csvContent,
            'api_key' => env('TRANSPORT_API_KEY')
        ]);

        if (!$response->successful()) {
            throw new \Exception("Failed to send {$type} data: " . $response->body());
        }
    }
}