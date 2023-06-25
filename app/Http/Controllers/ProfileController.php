<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // get one row of data from database
    public function view(Request $request)
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $user = DB::table('super_admins')
                ->select('super_admins.*')
                ->where('super_admins.id', $userID)
                ->first();

            return view('profile.view', compact('user'));
        } else if (session('user_role') == "Event Venue Owner") {
            $user = DB::table('event_venue_owners')
                ->select('event_venue_owners.*')
                ->where('event_venue_owners.id', $userID)
                ->first();

            return view('profile.view', compact('user'));
        }
    }

    // display edit form
    public function edit(Request $request)
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $user = DB::table('super_admins')
                ->select('super_admins.*')
                ->where('super_admins.id', $userID)
                ->first();

            return view('profile.edit', compact('user'));
        } else if (session('user_role') == "Event Venue Owner") {
            $user = DB::table('event_venue_owners')
                ->select('event_venue_owners.*')
                ->where('event_venue_owners.id', $userID)
                ->first();

            return view('profile.edit', compact('user'));
        }
    }

    // update new data to database
    public function update(Request $request)
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'address' => 'required',
            'postalCode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required'
        ]);

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            DB::table('super_admins')
                ->where('super_admins.id', $userID)
                ->update([
                    'first_name' => $request->firstName,
                    'last_name' => $request->lastName,
                    'email' => $request->email,
                    'phone_number' => $request->phoneNumber,
                    'address' => $request->address,
                    'postal_code' => $request->postalCode,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'updated_at' => now()
                ]);
        } else if (session('user_role') == "Event Venue Owner") {
            DB::table('event_venue_owners')
                ->where('event_venue_owners.id', $userID)
                ->update([
                    'first_name' => $request->firstName,
                    'last_name' => $request->lastName,
                    'email' => $request->email,
                    'phone_number' => $request->phoneNumber,
                    'address' => $request->address,
                    'postal_code' => $request->postalCode,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country' => $request->country,
                    'updated_at' => now()
                ]);
        }

        return redirect('/evbs/profile')->with('success', 'Profile updated successfully!');
    }

    // display edit password form
    public function editPassword(Request $request)
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $user = DB::table('super_admins')
                ->select('super_admins.*')
                ->where('super_admins.id', $userID)
                ->first();

            return view('profile.edit-password', compact('user'));
        } else if (session('user_role') == "Event Venue Owner") {
            $user = DB::table('event_venue_owners')
                ->select('event_venue_owners.*')
                ->where('event_venue_owners.id', $userID)
                ->first();

            return view('profile.edit-password', compact('user'));
        }
    }

    // update new password to database
    public function updatePassword(Request $request)
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        $request->validate(
            [
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'password.required' => 'The new password field is required.',
                'password.min' => 'The new password field must be at least 8 characters.',
                'password.confirmed' => 'The new password does not match.',
                'password_confirmation.required' => 'The new confirm password field is required.'
            ]
        );

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            DB::table('super_admins')
                ->where('super_admins.id', $userID)
                ->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now()
                ]);
        } else if (session('user_role') == "Event Venue Owner") {
            DB::table('event_venue_owners')
                ->where('event_venue_owners.id', $userID)
                ->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now()
                ]);
        }

        return redirect('/evbs/profile')->with('success', 'Password changed successfully!');
    }
}
