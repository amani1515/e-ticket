<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahberat;
use App\Models\Destination;
use Illuminate\Http\Request;

class MahberatController extends Controller
{
    public function index(Request $request)
    {
        // Allow both admin and headoffice to view
        $query = Mahberat::with(['destinations', 'users']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        // Filter by destination
        if ($request->filled('destination_filter')) {
            $query->whereHas('destinations', function($q) use ($request) {
                $q->where('destinations.id', $request->destination_filter);
            });
        }
        
        $mahberats = $query->paginate(10)->withQueryString();
        $destinations = Destination::all();
        
        return view('admin.mahberats.index', compact('mahberats', 'destinations'));
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

    public function show($id)
    {
        // Allow both admin and headoffice to view details
        if (auth()->check() && in_array(auth()->user()->usertype, ['admin', 'headoffice'])) {
            $mahberat = Mahberat::with(['destinations', 'users'])->findOrFail($id);
            return view('admin.mahberats.show', compact('mahberat'));
        }
        return view('errors.403');
    }
}
