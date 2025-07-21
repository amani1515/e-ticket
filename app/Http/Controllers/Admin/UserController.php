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
                'phone' => ['required', 'regex:/^(09|07)\d{8}$/', 'digits:10', 'unique:users,phone,' . $id],
                'usertype' => 'required|string',
                'password' => 'required|string|confirmed',
                'mahberat_id' => 'nullable|exists:mahberats,id',
                'assigned_destinations' => 'nullable|array',
                'assigned_destinations.*' => 'exists:destinations,id',
                'birth_date' => 'nullable|date',
                'national_id' => 'nullable|digits:16',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'pdf_file' => 'nullable|file|mimes:pdf|max:4096',
            ]);

            // Sanitize input values to protect against XSS
            $sanitized = [
                'name' => strip_tags($validatedData['name']),
                'email' => strip_tags($validatedData['email']),
                'phone' => strip_tags($validatedData['phone']),
                'usertype' => strip_tags($validatedData['usertype']),
                'mahberat_id' => $validatedData['mahberat_id'] ?? null,
                'birth_date' => $validatedData['birth_date'] ?? null,
                'national_id' => strip_tags($validatedData['national_id'] ?? ''),
            ];

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
                $sanitized['profile_photo_path'] = $profilePhotoPath;
            }

            // Handle PDF file upload
            if ($request->hasFile('pdf_file')) {
                $pdfFilePath = $request->file('pdf_file')->store('user-pdfs', 'public');
                $sanitized['pdf_file'] = $pdfFilePath;
            }

            // Hash password
            $sanitized['password'] = \Illuminate\Support\Facades\Hash::make($validatedData['password']);

            // Create user with sanitized values
            $user = User::create($sanitized);

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

public function checkPhone(Request $request)
{
    $exists = User::where('phone', $request->phone)->exists();
    return response()->json(['exists' => $exists]);
}
public function checkPhoneUpdate(Request $request)
{
    $phone = $request->input('phone');
    $userId = $request->input('user_id');

    $exists = User::where('phone', $phone)
                  ->where('id', '!=', $userId) // Exclude the current user
                  ->exists();

    return response()->json(['exists' => $exists]);
}
public function checkNationalIdUpdate(Request $request)
{
    $nationalId = $request->input('national_id');
    $userId = $request->input('user_id');

    $exists = User::where('national_id', $nationalId)
                  ->where('id', '!=', $userId)
                  ->exists();

    return response()->json(['exists' => $exists]);
}
public function destroy(User $user)
{
    if (auth()->check() && Auth::user()->usertype === 'admin') {
        $user->delete(); // or $user->forceDelete() if you want permanent deletion
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
    return abort(403);
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
    if(auth::id()) {
        $usertype = Auth::user()->usertype;
        if($usertype == 'admin') {
            $user = User::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => ['required', 'regex:/^(09|07)\d{8}$/', 'digits:10', 'unique:users,phone'],
                'usertype' => 'required|string',
                'birth_date' => 'nullable|date',
                'national_id' => 'nullable|digits:16',
                'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
                'pdf_file' => 'nullable|file|mimes:pdf|max:4096',
            ]);

            $user->fill($validatedData);

            // Handle profile photo upload
            if ($request->hasFile('profile_photo')) {
                $path = $request->file('profile_photo')->store('profile-photos', 'public');
                $user->profile_photo_path = $path;
            }

            // Handle PDF file upload
            if ($request->hasFile('pdf_file')) {
                $pdfPath = $request->file('pdf_file')->store('user-pdfs', 'public');
                $user->pdf_file = $pdfPath;
            }

            $user->save();

            return redirect()->route('admin.users.index')->with('success', 'User updated!');
        } else {
            return view('errors.403');
        }
    }
}
}
