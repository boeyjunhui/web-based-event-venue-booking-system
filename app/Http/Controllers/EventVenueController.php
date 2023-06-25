<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EventVenueController extends Controller
{
    // display add form
    public function add()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // insert data into database
    public function create()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // get all rows of data from database
    public function viewAll()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // get one row of data from database
    public function view()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // display edit form
    public function edit()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // update new data to database
    public function update()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // activate a data
    public function activate()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // deactivate a data
    public function deactivate()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }

    // delete data from database
    public function delete()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        //
    }
}
