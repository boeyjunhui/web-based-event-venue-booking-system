<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\XRayController;

class SuperAdminController extends Controller
{
    /* ========================================
    Super Admin
    ======================================== */
    // display add form
    public function __construct(XRayController $xRayController)
    {
        $this->xRayController = $xRayController;
    }


    public function add()
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        return view('super-admins.add');
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
        $query = DB::table('super_admins')
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

        $this->xRayController->addRdsQuery('insert into super_admins');
        $this->xRayController->end();

        $this->xRayController->submit();

        return redirect('/evbs/super-admins')->with('success', 'Super admin created successfully!');
    }

    // get all rows of data from database
    public function viewAll()
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }
        $this->xRayController->begin();
        $this->xRayController->startRds();

        $superAdminsQuery = DB::table('super_admins')
            ->select('super_admins.*')
            ->orderBy('super_admins.created_at', 'desc');

        $superAdmins = $superAdminsQuery->get();

        $this->xRayController->addRdsQuery($superAdminsQuery->toSql());

        $this->xRayController->end();

        $this->xRayController->submit();
        return view('super-admins.view-all', compact('superAdmins'));
    }

    // get one row of data from database
    public function view(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $superAdminQuery = DB::table('super_admins')
            ->select('super_admins.*')
            ->where('super_admins.id', $superAdminID);
        $superAdmin = $superAdminQuery->first();

        $this->xRayController->addRdsQuery($superAdminQuery->toSql());

        $this->xRayController->end();

        $this->xRayController->submit();
        return view('super-admins.view', compact('superAdmin'));
    }

    // display edit form
    public function edit(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $superAdminQuery = DB::table('super_admins')
            ->select('super_admins.*')
            ->where('super_admins.id', $superAdminID);
        $superAdmin = $superAdminQuery->first();

        $this->xRayController->addRdsQuery($superAdminQuery->toSql());

        $this->xRayController->end();

        $this->xRayController->submit();
        return view('super-admins.edit', compact('superAdmin'));
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

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        DB::table('super_admins')
            ->where('super_admins.id', $superAdminID)
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

        $this->xRayController->addRdsQuery('super_admins update');
        $this->xRayController->end();

        $this->xRayController->submit();

        return redirect('/evbs/super-admins')->with('success', 'Super admin updated successfully!');
    }

    // display edit password form
    public function editPassword(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $superAdminQuery = DB::table('super_admins')
            ->select('super_admins.*')
            ->where('super_admins.id', $superAdminID);
        $superAdmin = $superAdminQuery->first();

        $this->xRayController->addRdsQuery($superAdminQuery->toSql());

        $this->xRayController->end();

        $this->xRayController->submit();
        return view('super-admins.edit-password', compact('superAdmin'));
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

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
         DB::table('super_admins')
            ->where('super_admins.id', $superAdminID)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);


        $this->xRayController->addRdsQuery('super_admins update password');

        $this->xRayController->end();

        $this->xRayController->submit();

        return redirect('/evbs/super-admins/' . $superAdminID)->with('success', 'Password changed successfully!');
    }

    // activate a data
    public function activate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
         DB::table('super_admins')
            ->where('super_admins.id', $superAdminID)
            ->update([
                'status' => 1,
                'updated_at' => now()
            ]);
        $this->xRayController->addRdsQuery('super_admins status = 1');

        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/super-admins')->with('success', 'Super admin activated successfully!');
    }

    // deactivate a data
    public function deactivate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
         DB::table('super_admins')
            ->where('super_admins.id', $superAdminID)
            ->update([
                'status' => 0,
                'updated_at' => now()
            ]);
        $this->xRayController->addRdsQuery('super_admins status = 0');

        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/super-admins')->with('success', 'Super admin deactivated successfully!');
    }

    // delete data from database
    public function delete(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $superAdminID = $request->segment(3);
        $this->xRayController->begin();
        $this->xRayController->startRds();
         DB::table('super_admins')
            ->where('super_admins.id', $superAdminID)
            ->delete();
        $this->xRayController->addRdsQuery('super_admins delete');

        $this->xRayController->end();

        $this->xRayController->submit();
        return redirect('/evbs/super-admins')->with('success', 'Super admin deleted successfully!');
    }
}