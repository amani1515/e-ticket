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
        // Allow both admin and headoffice to view
        $mahberats = Mahberat::with('destinations')->get();
        return view('admin.mahberats.index', compact('mahberats'));
    }

    public function create()
    {
        // Only admin can create
        if (auth()->check() && auth()->user()->usertype === 'admin') {
            $destinations = Destination::all();
            return view('admin.mahberats.create', compact('destinations'));
        }
        return view('errors.403');
    }

    public function store(Request $request)
    {
        // Only admin can store
        if (auth()->check() && auth()->user()->usertype === 'admin') {
            $request->validate([
                'name' => 'required|string|max:255',
                'destinations' => 'array',
            ]);

            $mahberat = Mahberat::create(['name' => $request->name]);
            $mahberat->destinations()->sync($request->destinations);

            return redirect()->route('admin.mahberats.index')->with('success', 'Mahberat created successfully.');
        }
        return view('errors.403');
    }
}
