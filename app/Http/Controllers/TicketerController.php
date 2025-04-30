<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketerController extends Controller
{
    public function index()
    {
        return view('ticketer.index');
    }

    public function create()
    {
        return view('ticketer.tickets.create');
    }

    public function report()
    {
        return view('ticketer.tickets.report');
    }

    public function scan()
    {
        return view('ticketer.tickets.scan');
    }
}
