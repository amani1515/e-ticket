<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
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
}