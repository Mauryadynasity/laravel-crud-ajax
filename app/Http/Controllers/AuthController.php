<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmployeeMailJob;
use App\Models\User;
use App\Models\Qualification;
use App\Models\Experience;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showForm()
    {
        return view('signup');
    }
    public function store(Request $request)
    {
        // Validation
        $request->validate([
        'full_name' => 'required|string|min:3|max:100',
        'dob' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|max:20|confirmed',
        'password_confirmation' => 'required',
        'age' => 'required|integer',
        'profile_image' => 'required|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ],[
            'full_name.required' => 'Full Name is required',
            'full_name.required' => 'Date of birth is required',
            'email.unique' => 'Email already exists',
            'age.required' => 'Age is Required',
            "profile_image.required" => 'Profile Image is required'
        ]);

        // Profile Image Upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
        }

        // User Save
        $user = User::create([
            'full_name' => $request->full_name,
            'dob' => $request->dob,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'age' => $request->age,
            'profile_image' => $imagePath,
        ]);
        SendEmployeeMailJob::dispatch($user);
        // Qualifications Save
        if ($request->qualifications) {
            foreach ($request->qualifications as $q) {
                if ($q) {
                    Qualification::create([
                        'user_id' => $user->id,
                        'qualification_name' => $q
                    ]);
                }
            }
        }

        // Experiences Save
        if ($request->experiences) {
            foreach ($request->experiences as $exp) {
                if ($exp) {
                    Experience::create([
                        'user_id' => $user->id,
                        'company_name' => $exp
                    ]);
                }
            }
        }

        // Permanent Address
        Address::create([
            'user_id' => $user->id,
            'type' => 'permanent',
            'address_line1' => $request->permanent['address_line1'],
            'address_line2' => $request->permanent['address_line2'] ?? null,
            'city' => $request->permanent['city'],
            'state' => $request->permanent['state'],
        ]);

        // Current Address
        Address::create([
            'user_id' => $user->id,
            'type' => 'current',
            'address_line1' => $request->current['address_line1'],
            'address_line2' => $request->current['address_line2'] ?? null,
            'city' => $request->current['city'],
            'state' => $request->current['state'],
        ]);
        return redirect('/signup')->with('success', 'User Registered Successfully');
    }

    // ShowLoginForm
    public function showLogin()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        // Validation
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'is_admin' => 0
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect('/profile');
        }
        return back()->with('error', 'Invalid Credentials');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
