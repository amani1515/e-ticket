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
}
