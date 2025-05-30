<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahberat;
use App\Models\Destination;
use Illuminate\Http\Request;

class MahberatController extends Controller
{
    public function index()
    {
        $mahberats = Mahberat::with('destinations')->get();
        return view('admin.mahberats.index', compact('mahberats'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.mahberats.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'destinations' => 'array',
        ]);

        $mahberat = Mahberat::create(['name' => $request->name]);
        $mahberat->destinations()->sync($request->destinations);

        return redirect()->route('admin.mahberats.index')->with('success', 'Mahberat created successfully.');
    }
}
