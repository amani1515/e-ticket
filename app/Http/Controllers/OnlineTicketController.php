<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\OnlineTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class OnlineTicketController extends Controller
{
    public function create()
    {
        return view('online-ticket.create'); // we'll create this view next
    }
        public function search(Request $request)
    {
        $keyword = $request->input('search');

        $schedules = BusSchedule::whereHas('bus', function ($q) {
                $q->where('type', 'long'); // assuming enum or string type
            })
            ->where('destination', 'like', '%' . $keyword . '%')
            ->with('bus') // eager load bus info
            ->get();

        return view('online-ticket.index', compact('schedules', 'keyword'));
    }
}
