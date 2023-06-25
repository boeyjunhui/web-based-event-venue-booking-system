<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        if (!session('user_role')) {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $totalBookings = DB::table('bookings')
                ->where('bookings.booking_type', 1)
                ->count();

            $totalEventVenues = DB::table('event_venues')
                ->count();

            $totalEventTypes = DB::table('event_types')
                ->count();

            $totalGuests = DB::table('guests')
                ->count();

            $totalEventVenueOwners = DB::table('event_venue_owners')
                ->count();

            return view('dashboard.dashboard', compact('totalBookings', 'totalEventVenues', 'totalEventTypes', 'totalGuests', 'totalEventVenueOwners'));
        } else if (session('user_role') == "Event Venue Owner") {
            $totalBookings = DB::table('bookings')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->join('event_venue_owners', 'event_venue_owners.id', '=', 'event_venues.event_venue_owner_id')
                ->where('bookings.booking_type', 1)
                ->count();

            $totalEventVenues = DB::table('event_venues')
                ->where('event_venues.event_venue_owner_id', $userID)
                ->count();

            return view('dashboard.dashboard', compact('totalBookings', 'totalEventVenues'));
        }
    }
}
