<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;


class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        // Validate input
        $request->validate([
            'destination_name' => 'required|string|max:255',
            'start_from' => 'required|string|max:255',
            'tariff' => 'required|string|max:255',
            'tax' => 'required|numeric', // Validate as numeric
            'service_fee' => 'required|numeric', // Validate as numeric
        ]);
    
        // Save destination
        Destination::create([
            'destination_name' => $request->destination_name,
            'start_from' => $request->start_from,
            'tariff' => $request->tariff,
            'tax' => $request->tax,  // Save tax as a decimal
            'service_fee' => $request->service_fee,  // Save service fee as a decimal
        ]);
    
        // Redirect back or to list
        return redirect()->route('admin.destinations.index')->with('success', 'Destination added successfully.');
    }
    
}

