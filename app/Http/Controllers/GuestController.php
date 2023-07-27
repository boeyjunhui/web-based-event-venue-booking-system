<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuestController extends Controller
{
    /* ========================================
    Super Admin
    ======================================== */
    // display add form
    public function add()
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        return view('guests.add');
    }

    // insert data into database
    public function create(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $request->validate(
            [
                'firstName' => 'required',
                'lastName' => 'required',
                'email' => 'required|email|unique:super_admins,email|unique:event_venue_owners,email|unique:guests,email',
                'phoneNumber' => 'required',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required'
            ],
            [
                'password.confirmed' => 'The password does not match.',
                'password_confirmation.required' => 'The confirm password field is required.'
            ]
        );

        DB::table('guests')
            ->insert([
                'id' => Str::random(30),
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'phone_number' => $request->phoneNumber,
                'password' => Hash::make($request->password),
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        return redirect('/evbs/guests')->with('success', 'Guest created successfully!');
    }

    // get all rows of data from database
    public function viewAll()
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $guests = DB::table('guests')
            ->select('guests.*')
            ->orderBy('guests.created_at', 'desc')
            ->get();

        return view('guests.view-all', compact('guests'));
    }

    // get one row of data from database
    public function view(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $guestID = $request->segment(3);

        $guest = DB::table('guests')
            ->select('guests.*')
            ->where('guests.id', $guestID)
            ->first();

        return view('guests.view', compact('guest'));
    }

    // display edit form
    public function edit(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $guestID = $request->segment(3);

        $guest = DB::table('guests')
            ->select('guests.*')
            ->where('guests.id', $guestID)
            ->first();

        return view('guests.edit', compact('guest'));
    }

    // update new data to database
    public function update(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required'
        ]);

        $guestID = $request->segment(3);

        DB::table('guests')
            ->where('guests.id', $guestID)
            ->update([
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'phone_number' => $request->phoneNumber,
                'updated_at' => now()
            ]);

        return redirect('/evbs/guests')->with('success', 'Guest updated successfully!');
    }

    // display edit password form
    public function editPassword(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $guestID = $request->segment(3);

        $guest = DB::table('guests')
            ->select('guests.*')
            ->where('guests.id', $guestID)
            ->first();

        return view('guests.edit-password', compact('guest'));
    }

    // update new password to database
    public function updatePassword(Request $request)
    {
        if (session('user_role') != "Super Admin") {
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

        $guestID = $request->segment(3);

        DB::table('guests')
            ->where('guests.id', $guestID)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);

        return redirect('/evbs/guests/' . $guestID)->with('success', 'Password changed successfully!');
    }

    // activate a data
    public function activate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $guestID = $request->segment(3);

        DB::table('guests')
            ->where('guests.id', $guestID)
            ->update([
                'status' => 1,
                'updated_at' => now()
            ]);

        return redirect('/evbs/guests')->with('success', 'Guest activated successfully!');
    }

    // deactivate a data
    public function deactivate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $guestID = $request->segment(3);

        DB::table('guests')
            ->where('guests.id', $guestID)
            ->update([
                'status' => 0,
                'updated_at' => now()
            ]);

        return redirect('/evbs/guests')->with('success', 'Guest deactivated successfully!');
    }

    // delete data from database
    public function delete(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $guestID = $request->segment(3);

        DB::table('guests')
            ->where('guests.id', $guestID)
            ->delete();

        return redirect('/evbs/guests')->with('success', 'Guest deleted successfully!');
    }
}
