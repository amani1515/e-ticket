<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Bus;
use App\Models\Schedule;
use App\Models\Ticket;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ExportController extends Controller
{
    private function getRouteUuid($destination)
    {
        if (!$destination) return '';
        
        $routeMap = [
            'አዘና->ኮሶበር' => 'AZE/KOS',
            'አዘና->ግምጃ ቤት' => 'AZE/GMJ',
            'ዚገም->ቻግኒ' => 'ZIG/CHG',
            'ሽንዲ->ወገዳድ' => 'SHD/WOG',
            'ሽንዲ->ኮኪ' => 'SHD/KOK',
            'ሽንዲ->ዋዝንግዝ' => 'SHD/WZG',
            'ሽንዲ->ጎመር' => 'SHD/GOM',
            'ሽንዲ->ኽረጥ' => 'SHD/HRT',
            'ሽንዲ->ቡሬ' => 'SHD/BUR',
            'ሽንዲ->ቲሊሊ' => 'SHD/TIL',
            'ሽንዲ->በሊማ' => 'SHD/BEL'
        ];
        
        $key = $destination->start_from . '->' . $destination->destination_name;
        return $routeMap[$key] ?? substr($destination->destination_name, 0, 3) . '/' . substr($destination->start_from, 0, 3);
    }

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

    public function exportSchedulesCsv(Request $request)
    {
        $query = Schedule::with(['bus', 'destination', 'user']);
        
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'daily':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'weekly':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'range':
                    if ($request->start_date && $request->end_date) {
                        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
            }
        }
        
        $schedules = $query->get();
        $dateTime = now()->format('Y-m-d_H-i-s');
        $firstSchedule = $schedules->first();
        $startFrom = $firstSchedule && $firstSchedule->destination ? $firstSchedule->destination->start_from : 'schedules';
        $filename = "{$startFrom}_schedules_export_{$dateTime}.csv";
        
        $csvData = "schedule_uuid,targa,route_uuid,ticket_office_uuid,scheduled_at,status,boarding,scheduled_by\n";
        
        foreach ($schedules as $schedule) {
            $scheduleUuid = $schedule->uuid ?? '';
            $targa = $schedule->bus->targa ?? '';
            $routeUuid = $this->getRouteUuid($schedule->destination);
            $ticketOfficeUuid = 'Azena1';
            $scheduledAt = $schedule->created_at ?? '';
            $status = $schedule->status ?? 'scheduled';
            $boarding = $schedule->boarding ?? 0;
            $scheduledBy = $schedule->user->name ?? '';
            
            $csvData .= "\"$scheduleUuid\",\"$targa\",\"$routeUuid\",\"$ticketOfficeUuid\",\"$scheduledAt\",\"$status\",$boarding,\"$scheduledBy\"\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function exportTicketsCsv(Request $request)
    {
        $query = Ticket::with(['schedule.destination', 'user']);
        
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'daily':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'weekly':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'range':
                    if ($request->start_date && $request->end_date) {
                        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
            }
        }
        
        $tickets = $query->get();
        $dateTime = now()->format('Y-m-d_H-i-s');
        $firstTicket = $tickets->first();
        $startFrom = $firstTicket && $firstTicket->schedule && $firstTicket->schedule->destination ? $firstTicket->schedule->destination->start_from : 'tickets';
        $filename = "{$startFrom}_tickets_export_{$dateTime}.csv";
        
        $csvData = "ticket_uuid,schedule_uuid,passenger_name,gender,created_by\n";
        
        foreach ($tickets as $ticket) {
            $ticketUuid = $ticket->uuid ?? '';
            $scheduleUuid = $ticket->schedule->uuid ?? '';
            $passengerName = $ticket->passenger_name ?? '';
            $gender = $ticket->gender ?? '';
            $createdBy = $ticket->user->name ?? '';
            
            $csvData .= "\"$ticketUuid\",\"$scheduleUuid\",\"$passengerName\",\"$gender\",\"$createdBy\"\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function downloadAllSeparate(Request $request)
    {
        return view('admin.export.download-all-auto', compact('request'));
    }

    public function exportAllCsv(Request $request)
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
        $csvData .= "schedule_uuid,targa,route_uuid,ticket_office_uuid,scheduled_at,status,boarding,scheduled_by\n";
        $scheduleQuery = Schedule::with(['bus', 'destination', 'user']);
        
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'daily':
                    $scheduleQuery->whereDate('created_at', Carbon::today());
                    break;
                case 'weekly':
                    $scheduleQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'range':
                    if ($request->start_date && $request->end_date) {
                        $scheduleQuery->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
            }
        }
        
        $schedules = $scheduleQuery->get();
        foreach ($schedules as $schedule) {
            $scheduleUuid = $schedule->uuid ?? '';
            $targa = $schedule->bus->targa ?? '';
            $routeUuid = $schedule->destination ? substr($schedule->destination->destination_name, 0, 3) . '/' .substr($schedule->destination->start_from, 0, 3) : '';
            $ticketOfficeUuid = $schedule->destination->start_from .' ' .'bus station 1' ?? '';
            $scheduledAt = $schedule->created_at ?? '';
            $status = $schedule->status ?? 'scheduled';
            $boarding = $schedule->boarding ?? 0;
            $scheduledBy = $schedule->user->name ?? '';
            $csvData .= "\"$scheduleUuid\",\"$targa\",\"$routeUuid\",\"$ticketOfficeUuid\",\"$scheduledAt\",\"$status\",$boarding,\"$scheduledBy\"\n";
        }
        
        // Tickets
        $csvData .= "\n=== TICKETS ===\n";
        $csvData .= "ticket_uuid,schedule_uuid,passenger_name,gender,created_by\n";
        $ticketQuery = Ticket::with(['schedule.destination', 'user']);
        
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'daily':
                    $ticketQuery->whereDate('created_at', Carbon::today());
                    break;
                case 'weekly':
                    $ticketQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'range':
                    if ($request->start_date && $request->end_date) {
                        $ticketQuery->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
            }
        }
        
        $tickets = $ticketQuery->get();
        foreach ($tickets as $ticket) {
            $ticketUuid = $ticket->uuid ?? '';
            $scheduleUuid = $ticket->schedule->uuid ?? '';
            $passengerName = $ticket->passenger_name ?? '';
            $gender = $ticket->gender ?? '';
            $createdBy = $ticket->user->name ?? '';
            $csvData .= "\"$ticketUuid\",\"$scheduleUuid\",\"$passengerName\",\"$gender\",\"$createdBy\"\n";
        }
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function getExportCounts(Request $request)
    {
        $destinations = Destination::count();
        $buses = Bus::count();
        
        $scheduleQuery = Schedule::query();
        $ticketQuery = Ticket::query();
        
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'daily':
                    $scheduleQuery->whereDate('created_at', Carbon::today());
                    $ticketQuery->whereDate('created_at', Carbon::today());
                    break;
                case 'weekly':
                    $scheduleQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    $ticketQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'range':
                    if ($request->start_date && $request->end_date) {
                        $scheduleQuery->whereBetween('created_at', [$request->start_date, $request->end_date]);
                        $ticketQuery->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                    break;
            }
        }
        
        $schedules = $scheduleQuery->count();
        $tickets = $ticketQuery->count();
        
        return response()->json([
            'destinations' => $destinations,
            'buses' => $buses,
            'schedules' => $schedules,
            'tickets' => $tickets
        ]);
    }
}