<?php
namespace App\Http\Controllers\CargoMan;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('cargoMan.index');
    }
}