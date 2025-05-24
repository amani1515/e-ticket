<?php
// filepath: d:\project\e-ticket\app\Http\Controllers\Balehabt\BusController.php

namespace App\Http\Controllers\Balehabt;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use Illuminate\Support\Facades\Auth;

class BusController extends Controller
{
    public function index()
    {
        // Eager load schedules and their destinations for each bus owned by the logged-in user
        $buses = Bus::with(['schedules.destination'])->where('owner_id', Auth::id())->get();
        return view('balehabt.index', compact('buses'));
    }
    
    public function overallBusReport()
    {
        $buses = \App\Models\Bus::with(['schedules.destination'])->get();
        return view('balehabt.overallBusReport', compact('buses'));
    }
}