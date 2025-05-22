<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class PublicDisplayController extends Controller
{
    public function showAllSchedules()
    {
        // Load destinations with their schedules and buses
        $destinations = Destination::with([
            'schedules' => function ($query) {
                $query->whereIn('status', ['queued', 'on loading'])->with('bus');
            }
        ])->get();

        return view('public.bus-display', compact('destinations'));
    }
}
