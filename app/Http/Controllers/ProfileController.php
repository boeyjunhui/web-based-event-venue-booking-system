<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\XRayController;

class ProfileController extends Controller
{
    public function __construct(XRayController $xRayController)
    {
        $this->xRayController = $xRayController;
    }

    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */
    // get one row of data from database
    public function view(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('super_admins')
                ->select('super_admins.*')
                ->where('super_admins.id', $userID);
            $user = $query->first();
            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.management-system.view', compact('user'));
        } else if (session('user_role') == "Event Venue Owner") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('event_venue_owners')
                ->select('event_venue_owners.*')
                ->where('event_venue_owners.id', $userID);
            $user = $query->first();
            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.management-system.view', compact('user'));
        }
    }

    // display edit form
    public function edit(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('super_admins')
                ->select('super_admins.*')
                ->where('super_admins.id', $userID);
            $user = $query->first();
            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.management-system.edit', compact('user'));
        } else if (session('user_role') == "Event Venue Owner") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('event_venue_owners')
                ->select('event_venue_owners.*')
                ->where('event_venue_owners.id', $userID);
            $user = $query->first();
            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.management-system.edit', compact('user'));
        }
    }

    // update new data to database
    public function update(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        $request->validate([
            'firstName' => 'required|regex:/^[\pL\s\-]+$/u',
            'lastName' => 'required|regex:/^[\pL\s\-]+$/u',
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
            $this->xRayController->begin();
            $this->xRayController->startRds();

            $query = DB::table('super_admins')
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
            $this->xRayController->addRdsQuery('update super_admins where');

            $this->xRayController->end();

            $this->xRayController->submit();
        } else if (session('user_role') == "Event Venue Owner") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('event_venue_owners')
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
            $this->xRayController->addRdsQuery('update event_venue_owners where');

            $this->xRayController->end();

            $this->xRayController->submit();
        }

        return redirect('/evbs/profile')->with('success', 'Profile updated successfully!');
    }

    // display edit password form
    public function editPassword(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('super_admins')
                ->select('super_admins.*')
                ->where('super_admins.id', $userID);
            $user = $query->first();

            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.management-system.edit-password', compact('user'));
        } else if (session('user_role') == "Event Venue Owner") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('event_venue_owners')
                ->select('event_venue_owners.*')
                ->where('event_venue_owners.id', $userID);
            $user = $query->first();

            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.management-system.edit-password', compact('user'));
        }
    }

    // update new password to database
    public function updatePassword(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
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
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('super_admins')
                ->where('super_admins.id', $userID)
                ->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update super_admins password');

            $this->xRayController->end();

            $this->xRayController->submit();
        } else if (session('user_role') == "Event Venue Owner") {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('event_venue_owners')
                ->where('event_venue_owners.id', $userID)
                ->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update event_venue_owners password');

            $this->xRayController->end();
        }

        return redirect('/evbs/profile')->with('success', 'Password changed successfully!');
    }

    /* ========================================
    Guest
    ======================================== */
    // get one row of data from database
    public function viewGuestProfile(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $guestID = session('user')->id;
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('guests')
                ->select('guests.*')
                ->where('guests.id', $guestID);
            $guest = $query->first();

            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.booking-system.view', compact('guest'));
        }
    }

    // display edit form
    public function editGuestProfile(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $guestID = session('user')->id;
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('guests')
                ->select('guests.*')
                ->where('guests.id', $guestID);
            $guest = $query->first();

            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.booking-system.edit', compact('guest'));
        }
    }

    // update new data to database
    public function updateGuestProfile(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $request->validate([
                'firstName' => 'required|regex:/^[\pL\s\-]+$/u',
                'lastName' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email',
                'phoneNumber' => 'required'
            ]);

            $guestID = session('user')->id;
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('guests')
                ->where('guests.id', $guestID)
                ->update([
                    'first_name' => $request->firstName,
                    'last_name' => $request->lastName,
                    'email' => $request->email,
                    'phone_number' => $request->phoneNumber,
                    'updated_at' => now()
                ]);

            $this->xRayController->addRdsQuery('update guests where');

            $this->xRayController->end();

            $this->xRayController->submit();
            return redirect('/profile')->with('success', 'Profile updated successfully!');
        }
    }

    // display edit password form
    public function editGuestPassword(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $guestID = session('user')->id;
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $query = DB::table('guests')
                ->select('guests.*')
                ->where('guests.id', $guestID);
            $guest = $query->first();

            $this->xRayController->addRdsQuery($query->toSql());

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('profile.booking-system.edit-password', compact('guest'));
        }
    }

    // update new password to database
    public function updateGuestPassword(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
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

            $guestID = session('user')->id;
            $this->xRayController->begin();
            $this->xRayController->startRds();
             DB::table('guests')
                ->where('guests.id', $guestID)
                ->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update guests password');

            $this->xRayController->end();

            $this->xRayController->submit();
            return redirect('/profile')->with('success', 'Password changed successfully!');
        }
    }
}