<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahberat;



class UserController extends Controller
{
    public function index()
    {

        if(auth::id())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == 'admin' || $usertype == 'headoffice')
            {
                $users = User::all();
                return view('admin.users.index', compact('users'));
            }
            else 
            {
                return view('errors.403');
            }
        }
    }

    // Show the form for creating a new user
    public function create()
    {
        if (auth::id()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'admin') {
                $destinations = Destination::all();
                $mahberats = Mahberat::all(); // 👈 Add this line

                return view('admin.users.create', compact('destinations', 'mahberats')); // 👈 Pass to view
            } else {
                return view('errors.403');
            }
        }
    }


    // Store the newly created user in the database
    // Inside the store method of UserController



public function store(Request $request)
{
    if (Auth::id()) {
        $usertype = Auth::user()->usertype;

        if ($usertype === 'admin') {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:users,name',
                'email' => 'required|email|unique:users',
                'phone' => ['required', 'regex:/^09\d{8}$/'],
                'usertype' => 'required|string',
                'password' => 'required|string|confirmed',
                'mahberat_id' => 'nullable|exists:mahberats,id',
                'assigned_destinations' => 'nullable|array',
                'assigned_destinations.*' => 'exists:destinations,id',
            ]);

            // Sanitize input values to protect against XSS
            $sanitized = [
                'name' => strip_tags($validatedData['name']),
                'email' => strip_tags($validatedData['email']),
                'phone' => strip_tags($validatedData['phone']),
                'usertype' => strip_tags($validatedData['usertype']),
                'mahberat_id' => $validatedData['mahberat_id'] ?? null,
            ];

            // Create user with sanitized values
            $user = User::create([
                'name' => $sanitized['name'],
                'email' => $sanitized['email'],
                'phone' => $sanitized['phone'],
                'usertype' => $sanitized['usertype'],
                'password' => Hash::make($validatedData['password']),
                'mahberat_id' => $sanitized['mahberat_id'],
            ]);

            // Assign destinations (no need to sanitize — already validated)
            if (isset($validatedData['assigned_destinations'])) {
                $user->destinations()->sync($validatedData['assigned_destinations']);
            }

            return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
        } else {
            return view('errors.403');
        }
    }
}


    public function destroy(User $user)
    {

        if(auth::id())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == 'admin')
            {
                $user->delete();
                return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
            }
            else 
            {
                return view('errors.403');
            }
        }
    }

    public function show($id) {
        if(auth::id())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == 'admin' || $usertype == 'headoffice')
            {
                $user = User::findOrFail($id);
                return view('admin.users.show', compact('user'));
            }
            else 
            {
                return view('errors.403');
            }
        }
    }

    public function edit($id) {
        if(auth::id())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == 'admin')
            {
                $user = User::findOrFail($id);
                return view('admin.users.edit', compact('user'));
            }
            else 
            {
                return view('errors.403');
            }
        }
    }

    public function update(Request $request, $id) {
        if(auth::id())
        {
            $usertype = Auth::user()->usertype;
            if($usertype == 'admin')
            {
                $user = User::findOrFail($id);
                $user->update($request->all());
                return redirect()->route('admin.users.index')->with('success', 'User updated!');
            }
            else 
            {
                return view('errors.403');
            }
        }
    }
}
