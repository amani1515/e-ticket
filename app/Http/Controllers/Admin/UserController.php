<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        return view('admin.users.create');
    }

    // Store the newly created user in the database
    public function store(Request $request)
    {
        // Validate the user data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:15',
            'usertype' => 'required|string|in:admin,ticketer,traffic,mahberat,balehabt',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'usertype' => $validatedData['usertype'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Redirect to users list with success message
        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }


public function destroy(User $user)
{
    $user->delete();
    return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
}


public function show($id) {
    $user = User::findOrFail($id);
    return view('admin.users.show', compact('user'));
}

public function edit($id) {
    $user = User::findOrFail($id);
    return view('admin.users.edit', compact('user'));
}

public function update(Request $request, $id) {
    $user = User::findOrFail($id);
    $user->update($request->all());
    return redirect()->route('admin.users.index')->with('success', 'User updated!');
}

}
