<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations = \App\Models\Destination::all();
        $schedules = \App\Models\Schedule::whereIn('status', ['queued', 'on loading'])->with('bus')->get(); // Ensure it's an Eloquent Collection
    
        return view('shop.index', compact('destinations', 'schedules'));
    }
    public function success()
    {
        // Handle successful payment
        return view('shop.success');
    }
    
    public function cancel()
    {
        // Handle cancelled payment
        return view('shop.cancel');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
