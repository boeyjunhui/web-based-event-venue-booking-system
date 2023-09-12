<?php

namespace App\Http\Controllers;

use App\Http\Controllers\XRayController;

use Illuminate\Support\Facades\DB;

// todo xray
class DashboardController extends Controller
{
    public function __construct(XRayController $xRayController)
    {
        $this->xRayController = $xRayController;
    }
    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */
    // display dashboard
    public function dashboard()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        }

        $userID = session('user')->id;

        if (session('user_role') == "Super Admin") {
            $this->xRayController->begin();
            $this->xRayController->startRds();

            $totalGuestBookings = DB::table('bookings')
                ->where('bookings.booking_type', 1)
                ->count();
            $this->xRayController->addRdsQuery('select bookings count');
            $this->xRayController->startRds();

            $totalEventVenues = DB::table('event_venues')
                ->count();
            $this->xRayController->addRdsQuery('select event_venues count');
            $this->xRayController->startRds();
            $totalEventTypes = DB::table('event_types')
                ->count();
            $this->xRayController->addRdsQuery('select event_types count');
            $this->xRayController->startRds();
            $totalGuests = DB::table('guests')
                ->count();
            $this->xRayController->addRdsQuery('select guests count');
            $this->xRayController->startRds();
            $totalEventVenueOwners = DB::table('event_venue_owners')
                ->count();
            $this->xRayController->addRdsQuery('select event_venue_owners count');

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('dashboard.dashboard', compact('totalGuestBookings', 'totalEventVenues', 'totalEventTypes', 'totalGuests', 'totalEventVenueOwners'));
        } else if (session('user_role') == "Event Venue Owner") {
            $this->xRayController->begin();
            $this->xRayController->startRds();

            $totalGuestBookings = DB::table('bookings')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->join('event_venue_owners', 'event_venue_owners.id', '=', 'event_venues.event_venue_owner_id')
                ->where('bookings.booking_type', 1)
                ->where('event_venues.event_venue_owner_id', $userID)
                ->count();
                $this->xRayController->addRdsQuery('select bookings count');
                $this->xRayController->startRds();
            $totalEventVenues = DB::table('event_venues')
                ->where('event_venues.event_venue_owner_id', $userID)
                ->count();
                $this->xRayController->addRdsQuery('select event_venues count');

            $this->xRayController->end();

            $this->xRayController->submit();
            return view('dashboard.dashboard', compact('totalGuestBookings', 'totalEventVenues'));
        }
    }
}