<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EventTypeController extends Controller
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

        return view('event-types.add');
    }

    // insert data into database
    public function create(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $request->validate([
            'eventTypeName' => 'required|unique:event_types,event_type_name'
        ]);

        DB::table('event_types')
            ->insert([
                'id' => Str::random(30),
                'event_type_name' => $request->eventTypeName,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);

        return redirect('/evbs/event-types')->with('success', 'Event type created successfully!');
    }

    // get all rows of data from database
    public function viewAll()
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventTypes = DB::table('event_types')
            ->select('event_types.*')
            ->orderBy('event_types.created_at', 'desc')
            ->get();

        return view('event-types.view-all', compact('eventTypes'));
    }

    // display edit form
    public function edit(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventTypeID = $request->segment(3);

        $eventType = DB::table('event_types')
            ->select('event_types.*')
            ->where('event_types.id', $eventTypeID)
            ->first();

        return view('event-types.edit', compact('eventType'));
    }

    // update new data to database
    public function update(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $request->validate([
            'eventTypeName' => 'required'
        ]);

        $eventTypeID = $request->segment(3);

        DB::table('event_types')
            ->where('event_types.id', $eventTypeID)
            ->update([
                'event_type_name' => $request->eventTypeName,
                'updated_at' => now()
            ]);

        return redirect('/evbs/event-types')->with('success', 'Event type updated successfully!');
    }

    // activate a data
    public function activate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventTypeID = $request->segment(3);

        DB::table('event_types')
            ->where('event_types.id', $eventTypeID)
            ->update([
                'status' => 1,
                'updated_at' => now()
            ]);

        return redirect('/evbs/event-types')->with('success', 'Event type activated successfully!');
    }

    // deactivate a data
    public function deactivate(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventTypeID = $request->segment(3);

        DB::table('event_types')
            ->where('event_types.id', $eventTypeID)
            ->update([
                'status' => 0,
                'updated_at' => now()
            ]);

        return redirect('/evbs/event-types')->with('success', 'Event type deactivated successfully!');
    }

    // delete data from database
    public function delete(Request $request)
    {
        if (session('user_role') != "Super Admin") {
            return redirect('/evbs/login');
        }

        $eventTypeID = $request->segment(3);

        DB::table('event_types')
            ->where('event_types.id', $eventTypeID)
            ->delete();

        return redirect('/evbs/event-types')->with('success', 'Event type deleted successfully!');
    }
}
