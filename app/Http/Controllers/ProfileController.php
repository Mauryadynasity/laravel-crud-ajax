<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Experience;
use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load('qualifications', 'experiences', 'addresses');
        return view('profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        // User update
        $user->update([
            'full_name' => $request->full_name,
            'dob' => $request->dob,
            'age' => $request->age,
        ]);

        // Image update
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->update(['profile_image' => $path]);
        }

        // Qualifications
        Qualification::where('user_id', $user->id)->delete();
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

        // Experiences
        Experience::where('user_id', $user->id)->delete();
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

        // Addresses (delete + insert)
        Address::where('user_id', $user->id)->delete();

        // Permanent
        Address::create([
            'user_id' => $user->id,
            'type' => 'permanent',
            'address_line1' => $request->permanent_line1,
            'address_line2' => $request->permanent_line2,
            'city' => $request->permanent_city,
            'state' => $request->permanent_state,
        ]);

        // Current
        Address::create([
            'user_id' => $user->id,
            'type' => 'current',
            'address_line1' => $request->current_line1,
            'address_line2' => $request->current_line2,
            'city' => $request->current_city,
            'state' => $request->current_state,
        ]);
        return response()->json([
            'status' => 'success',
            'image' => $user->profile_image ? asset('storage/'.$user->profile_image) : null
        ]);
    }
}
