<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;


class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {

        if(auth::id())
        {
         $usertype = Auth::user()->usertype;
         if($usertype == 'admin')
         {
            return view('admin.destinations.create');
         }
         else 
            {
                return view('errors.403');
            }
        }
    }

    public function store(Request $request)
    {
        // Validate input
        // Validate input
       $request->validate([
                'destination_name' => 'required|string|max:100',
                'start_from' => 'required|string|max:100',
                'distance' => 'required|numeric|min:0|max:10000',
                'tariff' => 'required|numeric|min:0|max:10000',
                'tax' => 'required|numeric|min:0|max:10000',
                'service_fee' => 'required|numeric|min:0|max:10000',
            ]);
    
        // Save destination
        Destination::create([
            'destination_name' => $request->destination_name,
            'start_from' => $request->start_from,
            'distance' => $request->distance,
            'tariff' => $request->tariff,
            'tax' => $request->tax,  // Save tax as a decimal
            'service_fee' => $request->service_fee,  // Save service fee as a decimal
        ]);
    
        // Redirect back or to list
        return redirect()->route('admin.destinations.index')->with('success', 'Destination added successfully.');
    }
    
}

