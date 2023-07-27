<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /* ========================================
    Super Admin
    ======================================== */
    // display add form
    public function add()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        //
    }

    // insert data into database
    public function create()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        //
    }

    // get all rows of data from database
    public function viewAll()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        //
    }

    // get one row of data from database
    public function view()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        //
    }

    // display edit form
    public function edit()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        //
    }

    // update new data to database
    public function update()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        //
    }

    // delete data from database
    public function delete()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        //
    }

    /* ========================================
    Guest
    ======================================== */
    // display make booking page
    public function makeBooking()
    {
        //
    }

    // insert booking data into database
    public function placeBooking()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        }

        //
    }

    // display booking successful page
    public function bookingSuccessful()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        }

        //
    }

    // view booking
    public function viewBooking()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        }

        //
    }

    // cancel booking
    public function cancelBooking()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        }

        //
    }
}
