<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bus;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all(); // Fetch all buses
        return view('admin.reports.buses', compact('buses'));
    }
}