<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Http\Response;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.export.index');
    }

    public function exportDestinationsCsv()
    {
        $destinations = Destination::all();
        $dateTime = now()->format('Y-m-d_H-i-s');
        $filename = "destinations_export_{$dateTime}.csv";
        
        $csvData = "UUID,Name,From station,To station,Distance km,Estimated duration minutes,Base price,Level 1,Level 2,Level 3,Is active\n";
        
        foreach ($destinations as $destination) {
            $uuid = substr($destination->destination_name, 0, 3) . substr($destination->start_from, 0, 3);
            $name = $destination->destination_name . ' ' . $destination->start_from;
            $fromStation = $destination->destination_name . ' busstation';
            $toStation = $destination->start_from . ' busstation';
            $distance = $destination->distance ?? 0;
            $duration = 1;
            $basePrice = $destination->level1_tariff ?? 0;
            $level1 = $destination->level1_tariff ?? 0;
            $level2 = $destination->level2_tariff ?? 0;
            $level3 = $destination->level3_tariff ?? 0;
            $isActive = 1;
            
            $csvData .= "\"$uuid\",\"$name\",\"$fromStation\",\"$toStation\",$distance,$duration,$basePrice,$level1,$level2,$level3,$isActive\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function exportBusesCsv()
    {
        $buses = Bus::all();
        $dateTime = now()->format('Y-m-d_H-i-s');
        $filename = "buses_export_{$dateTime}.csv";
        
        $csvData = "targa,capacity,level,is_active\n";
        
        foreach ($buses as $bus) {
            $targa = $bus->targa ?? '';
            $capacity = $bus->total_seats ?? 0;
            $level = $bus->level ?? 1;
            $isActive = 1;
            
            $csvData .= "\"$targa\",$capacity,$level,$isActive\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function exportSchedulesCsv()
    {
        $schedules = Schedule::with(['bus', 'destination'])->get();
        $dateTime = now()->format('Y-m-d_H-i-s');
        $firstSchedule = $schedules->first();
        $startFrom = $firstSchedule && $firstSchedule->destination ? $firstSchedule->destination->start_from : 'schedules';
        $filename = "{$startFrom}_schedules_export_{$dateTime}.csv";
        
        $csvData = "schedule_uuid,targa,route_uuid,ticket_office_uuid,scheduled_at,status,boarding\n";
        
        foreach ($schedules as $schedule) {
            $scheduleUuid = $schedule->uuid ?? '';
            $targa = $schedule->bus->targa ?? '';
            $routeUuid = $schedule->destination ? substr($schedule->destination->destination_name, 0, 3) . '/' .substr($schedule->destination->start_from, 0, 3) : '';
            $ticketOfficeUuid = $schedule->destination->start_from .' ' .'bus station 1' ?? '';
            $scheduledAt = $schedule->created_at ?? '';
            $status = $schedule->status ?? 'scheduled';
            $boarding = $schedule->boarding ?? 0;
            
            $csvData .= "\"$scheduleUuid\",\"$targa\",\"$routeUuid\",\"$ticketOfficeUuid\",\"$scheduledAt\",\"$status\",$boarding\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function exportTicketsCsv()
    {
        $tickets = Ticket::with(['schedule.destination'])->get();
        $dateTime = now()->format('Y-m-d_H-i-s');
        $firstTicket = $tickets->first();
        $startFrom = $firstTicket && $firstTicket->schedule && $firstTicket->schedule->destination ? $firstTicket->schedule->destination->start_from : 'tickets';
        $filename = "{$startFrom}_tickets_export_{$dateTime}.csv";
        
        $csvData = "ticket_uuid,schedule_uuid,passenger_name,gender\n";
        
        foreach ($tickets as $ticket) {
            $ticketUuid = $ticket->uuid ?? '';
            $scheduleUuid = $ticket->schedule->uuid ?? '';
            $passengerName = $ticket->passenger_name ?? '';
            $gender = $ticket->gender ?? '';
            
            $csvData .= "\"$ticketUuid\",\"$scheduleUuid\",\"$passengerName\",\"$gender\"\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function downloadAllSeparate()
    {
        return view('admin.export.download-all-auto');
    }

    public function exportAllCsv()
    {
        $dateTime = now()->format('Y-m-d_H-i-s');
        $filename = "all_data_export_{$dateTime}.csv";
        
        $csvData = "Type,Data\n";
        
        // Destinations
        $csvData .= "\n=== DESTINATIONS ===\n";
        $csvData .= "UUID,Name,From station,To station,Distance km,Estimated duration minutes,Base price,Level 1,Level 2,Level 3,Is active\n";
        $destinations = Destination::all();
        foreach ($destinations as $destination) {
            $uuid = substr($destination->destination_name, 0, 3) . substr($destination->start_from, 0, 3);
            $name = $destination->destination_name . ' ' . $destination->start_from;
            $fromStation = $destination->destination_name . ' busstation';
            $toStation = $destination->start_from . ' busstation';
            $distance = $destination->distance ?? 0;
            $duration = 1;
            $basePrice = $destination->level1_tariff ?? 0;
            $level1 = $destination->level1_tariff ?? 0;
            $level2 = $destination->level2_tariff ?? 0;
            $level3 = $destination->level3_tariff ?? 0;
            $isActive = 1;
            $csvData .= "\"$uuid\",\"$name\",\"$fromStation\",\"$toStation\",$distance,$duration,$basePrice,$level1,$level2,$level3,$isActive\n";
        }
        
        // Buses
        $csvData .= "\n=== BUSES ===\n";
        $csvData .= "targa,capacity,level,is_active\n";
        $buses = Bus::all();
        foreach ($buses as $bus) {
            $targa = $bus->targa ?? '';
            $capacity = $bus->total_seats ?? 0;
            $level = $bus->level ?? 1;
            $isActive = 1;
            $csvData .= "\"$targa\",$capacity,$level,$isActive\n";
        }
        
        // Schedules
        $csvData .= "\n=== SCHEDULES ===\n";
        $csvData .= "schedule_uuid,targa,route_uuid,ticket_office_uuid,scheduled_at,status,boarding\n";
        $schedules = Schedule::with(['bus', 'destination'])->get();
        foreach ($schedules as $schedule) {
            $scheduleUuid = $schedule->uuid ?? '';
            $targa = $schedule->bus->targa ?? '';
            $routeUuid = $schedule->destination ? substr($schedule->destination->destination_name, 0, 3) . '/' .substr($schedule->destination->start_from, 0, 3) : '';
            $ticketOfficeUuid = $schedule->destination->start_from .' ' .'bus station 1' ?? '';
            $scheduledAt = $schedule->created_at ?? '';
            $status = $schedule->status ?? 'scheduled';
            $boarding = $schedule->boarding ?? 0;
            $csvData .= "\"$scheduleUuid\",\"$targa\",\"$routeUuid\",\"$ticketOfficeUuid\",\"$scheduledAt\",\"$status\",$boarding\n";
        }
        
        // Tickets
        $csvData .= "\n=== TICKETS ===\n";
        $csvData .= "ticket_uuid,schedule_uuid,passenger_name,gender\n";
        $tickets = Ticket::with(['schedule.destination'])->get();
        foreach ($tickets as $ticket) {
            $ticketUuid = $ticket->uuid ?? '';
            $scheduleUuid = $ticket->schedule->uuid ?? '';
            $passengerName = $ticket->passenger_name ?? '';
            $gender = $ticket->gender ?? '';
            $csvData .= "\"$ticketUuid\",\"$scheduleUuid\",\"$passengerName\",\"$gender\"\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }
}