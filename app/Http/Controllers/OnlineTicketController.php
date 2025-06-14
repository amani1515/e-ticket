<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;    
use App\Models\OnlineTicket;
use App\Models\Bus;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;


class OnlineTicketController extends Controller
{
public function create()
{
    $schedules = Schedule::with(['bus', 'destination'])
        ->whereHas('bus', function ($query) {
            $query->where('distance', 'long');
        })
        ->whereIn('status', ['queued', 'on loading']) // filter by status
        ->get();

    return view('online-ticket.create', compact('schedules'));
}



        public function search(Request $request)
    {
        $keyword = $request->input('search');

        $schedules = BusSchedule::whereHas('bus', function ($q) {
                $q->where('distance', 'long'); // assuming enum or string type
            })
            ->where('destination', 'like', '%' . $keyword . '%')
            ->with('bus') // eager load bus info
            ->get();

        return view('online-ticket.create', compact('schedules', 'keyword'));
    }
}
