<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\XRayController;

class EventVenueOwnerController extends Controller
{
    public function __construct(XRayController $xRayController)
    {
        $this->xRayController = $xRayController;
    }

    /* ========================================
    Super Admin
    ======================================== */
    // display add form
    public function add()
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        return view('event-venue-owners.add');
    }

    // insert data into database
    public function create(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $request->validate(
            [
                'firstName' => 'required|regex:/^[\pL\s\-]+$/u',
                'lastName' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email|unique:super_admins,email|unique:event_venue_owners,email|unique:guests,email',
                'phoneNumber' => 'required',
                'password' => 'required|min:8|confirmed',
                'password_confirmation' => 'required',
                'address' => 'required',
                'postalCode' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required'
            ],
            [
                'password.confirmed' => 'The password does not match.',
                'password_confirmation.required' => 'The confirm password field is required.'
            ]
        );
        $this->xRayController->begin();
        $this->xRayController->startRds();
        DB::table('event_venue_owners')
            ->insert([
                'id' => Str::random(30),
                'first_name' => $request->firstName,
                'last_name' => $request->lastName,
                'email' => $request->email,
                'phone_number' => $request->phoneNumber,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'postal_code' => $request->postalCode,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        $this->xRayController->addRdsQuery('insert into event_venue_owners');
        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/event-venue-owners')->with('success', 'Event venue owner created successfully!');
    }

    // get all rows of data from database
    public function viewAll()
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $eventVenueOwnersQuery = DB::table('event_venue_owners')
            ->select('event_venue_owners.*')
            ->orderBy('event_venue_owners.created_at', 'desc');
        $eventVenueOwners = $eventVenueOwnersQuery->get();

        $this->xRayController->addRdsQuery($eventVenueOwnersQuery->toSql());
        $this->xRayController->end();

        $this->xRayController->submit();
        return view('event-venue-owners.view-all', compact('eventVenueOwners'));
    }

    // get one row of data from database
    public function view(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $eventVenueOwnerQuery = DB::table('event_venue_owners')
            ->select('event_venue_owners.*')
            ->where('event_venue_owners.id', $eventVenueOwnerID);
        $eventVenueOwner = $eventVenueOwnerQuery->first();

        $this->xRayController->addRdsQuery($eventVenueOwnerQuery->toSql());
        $this->xRayController->end();

        $this->xRayController->submit();
        return view('event-venue-owners.view', compact('eventVenueOwner'));
    }

    // display edit form
    public function edit(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $eventVenueOwnerQuery = DB::table('event_venue_owners')
            ->select('event_venue_owners.*')
            ->where('event_venue_owners.id', $eventVenueOwnerID);
        $eventVenueOwner = $eventVenueOwnerQuery->first();

        $this->xRayController->addRdsQuery($eventVenueOwnerQuery->toSql());
        $this->xRayController->end();

        $this->xRayController->submit();
        return view('event-venue-owners.edit', compact('eventVenueOwner'));
    }

    // update new data to database
    public function update(Request $request)
    {
        if (session('user_role') != "Super Admin") {
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

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $query = DB::table('event_venue_owners')
            ->where('event_venue_owners.id', $eventVenueOwnerID)
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
        return redirect('/evbs/event-venue-owners')->with('success', 'Event venue owner updated successfully!');
    }

    // display edit password form
    public function editPassword(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $query = DB::table('event_venue_owners')
            ->select('event_venue_owners.*')
            ->where('event_venue_owners.id', $eventVenueOwnerID);
        $eventVenueOwner = $query->first();

        $this->xRayController->addRdsQuery($query->toSql());
        $this->xRayController->end();

        $this->xRayController->submit();
        return view('event-venue-owners.edit-password', compact('eventVenueOwner'));
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

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $query = DB::table('event_venue_owners')
            ->where('event_venue_owners.id', $eventVenueOwnerID)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);
        $this->xRayController->addRdsQuery('update event_venue_owners password');
        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/event-venue-owners/' . $eventVenueOwnerID)->with('success', 'Password changed successfully!');
    }

    // activate a data
    public function activate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        DB::table('event_venue_owners')
            ->where('event_venue_owners.id', $eventVenueOwnerID)
            ->update([
                'status' => 1,
                'updated_at' => now()
            ]);
        $this->xRayController->addRdsQuery('event_venue_owners status = 1');
        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/event-venue-owners')->with('success', 'Event venue owner activated successfully!');
    }

    // deactivate a data
    public function deactivate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        DB::table('event_venue_owners')
            ->where('event_venue_owners.id', $eventVenueOwnerID)
            ->update([
                'status' => 0,
                'updated_at' => now()
            ]);
        $this->xRayController->addRdsQuery('event_venue_owners status = 0');
        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/event-venue-owners')->with('success', 'Event venue owner deactivated successfully!');
    }

    // delete data from database
    public function delete(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventVenueOwnerID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        DB::table('event_venue_owners')
            ->where('event_venue_owners.id', $eventVenueOwnerID)
            ->delete();
        $this->xRayController->addRdsQuery('delete from event_venue_owners');
        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/event-venue-owners')->with('success', 'Event venue owner deleted successfully!');
    }
}