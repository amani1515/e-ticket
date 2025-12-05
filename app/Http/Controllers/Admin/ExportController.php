<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Bus;
use App\Models\Schedule;
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
            ->header('Content-Disposition', 'attachment; filename="destinations_export.csv"');
    }

    public function exportBusesCsv()
    {
        $buses = Bus::all();
        
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
            ->header('Content-Disposition', 'attachment; filename="buses_export.csv"');
    }

    public function exportSchedulesCsv()
    {
        $schedules = Schedule::with(['bus', 'destination'])->get();
        
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
            ->header('Content-Disposition', 'attachment; filename="schedules_export.csv"');
    }
}