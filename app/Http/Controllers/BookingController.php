<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // check event venue availability
    public function checkEventVenueAvailability(Request $request)
    {
        $eventVenueID = $request->segment(3);
        $startDate = $request->segment(4);
        $endDate = $request->segment(5);

        $bookings = DB::select(
            "SELECT * FROM bookings bookings WHERE bookings.event_venue_id = '$eventVenueID'
                AND (('$startDate' >= bookings.start_date AND '$startDate' <= bookings.end_date)
                OR ('$endDate' >= bookings.start_date AND '$endDate' <= bookings.end_date)
                OR ('$startDate' < bookings.start_date AND '$endDate' > bookings.end_date))
                AND (bookings.status != '0')"
        );

        return json_encode(array($bookings));
    }

    /* ========================================
    Super Admin & Event Venue Owner
    ======================================== */
    // display add form
    public function addGuestBooking()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $guests = DB::table('guests')
                ->select('guests.id', 'guests.first_name', 'guests.last_name', 'guests.email')
                ->where('guests.status', 1)
                ->orderBy('guests.created_at', 'asc')
                ->get();

            if (session('user_role') == "Super Admin") {
                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            }

            return view('bookings.management-system.add-guest-booking', compact('guests', 'eventVenues'));
        }
    }

    public function addVenueBlocking()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            if (session('user_role') == "Super Admin") {
                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            }

            return view('bookings.management-system.add-venue-blocking', compact('eventVenues'));
        }
    }

    // insert data into database
    public function createGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $request->validate([
                'guest' => 'required',
                'eventVenue' => 'required',
                'startDate' => 'required',
                'endDate' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
                'numberOfGuests' => 'required|integer|min:1',
                'remarks' => 'nullable'
            ]);

            DB::table('bookings')
                ->insert([
                    'id' => Str::random(30),
                    'booking_type' => 1,
                    'guest_id' => $request->guest,
                    'event_venue_id' => $request->eventVenue,
                    'start_date' => $request->startDate,
                    'end_date' => $request->endDate,
                    'start_time' => $request->startTime,
                    'end_time' => $request->endTime,
                    'number_of_guests' => $request->numberOfGuests,
                    'remarks' => $request->remarks,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            return redirect('/evbs/bookings/guest-bookings')->with('success', 'Guest booking created successfully!');
        }
    }

    public function createVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $request->validate([
                'eventVenue' => 'required',
                'startDate' => 'required',
                'endDate' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
                'remarks' => 'nullable'
            ]);

            DB::table('bookings')
                ->insert([
                    'id' => Str::random(30),
                    'booking_type' => 2,
                    'event_venue_id' => $request->eventVenue,
                    'start_date' => $request->startDate,
                    'end_date' => $request->endDate,
                    'start_time' => $request->startTime,
                    'end_time' => $request->endTime,
                    'remarks' => $request->remarks,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking created successfully!');
        }
    }

    // get all rows of data from database
    public function viewAllGuestBookings(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            if (session('user_role') == "Super Admin") {
                $guestBookings = DB::table('bookings')
                    ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                    ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 1)
                    ->orderBy('bookings.created_at', 'desc')
                    ->get();
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $guestBookings = DB::table('bookings')
                    ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                    ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 1)
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->orderBy('bookings.created_at', 'desc')
                    ->get();
            }

            return view('bookings.management-system.view-all-guest-bookings', compact('guestBookings'));
        }
    }

    public function viewAllVenueBlockings(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            if (session('user_role') == "Super Admin") {
                $venueBlockings = DB::table('bookings')
                    ->select('bookings.*', 'event_venues.event_venue_name')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 2)
                    ->orderBy('bookings.created_at', 'desc')
                    ->get();
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $venueBlockings = DB::table('bookings')
                    ->select('bookings.*', 'event_venues.event_venue_name')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 2)
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->orderBy('bookings.created_at', 'desc')
                    ->get();
            }

            return view('bookings.management-system.view-all-venue-blockings', compact('venueBlockings'));
        }
    }

    // get one row of data from database
    public function viewGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(4);

            $guestBooking = DB::table('bookings')
                ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID)
                ->where('bookings.booking_type', 1)
                ->first();

            return view('bookings.management-system.view-guest-booking', compact('guestBooking'));
        }
    }

    public function viewVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(4);

            $venueBlocking = DB::table('bookings')
                ->select('bookings.*', 'event_venues.event_venue_name')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID)
                ->where('bookings.booking_type', 2)
                ->first();

            return view('bookings.management-system.view-venue-blocking', compact('venueBlocking'));
        }
    }

    // display edit form
    public function editGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);

            if (session('user_role') == "Super Admin") {
                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            }

            $guestBooking = DB::table('bookings')
                ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID)
                ->first();

            return view('bookings.management-system.edit-guest-booking', compact('eventVenues', 'guestBooking'));
        }
    }

    public function editVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);

            if (session('user_role') == "Super Admin") {
                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $eventVenues = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc')
                    ->get();
            }

            $venueBlocking = DB::table('bookings')
                ->select('bookings.*', 'event_venues.event_venue_name')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID)
                ->first();

            return view('bookings.management-system.edit-venue-blocking', compact('eventVenues', 'venueBlocking'));
        }
    }

    // update new data to database
    public function updateGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $request->validate([
                'eventVenue' => 'nullable',
                'startDate' => 'nullable',
                'endDate' => 'nullable',
                'startTime' => 'required',
                'endTime' => 'required',
                'numberOfGuests' => 'required|integer|min:1',
                'remarks' => 'nullable'
            ]);

            $bookingID = $request->segment(3);

            // update event venue, start date & end date if these fields are not empty
            if ($request->eventVenue == "" || $request->startDate == "" || $request->endDate == "") {
                DB::table('bookings')
                    ->where('bookings.id', $bookingID)
                    ->update([
                        'start_time' => $request->startTime,
                        'end_time' => $request->endTime,
                        'number_of_guests' => $request->numberOfGuests,
                        'remarks' => $request->remarks,
                        'updated_at' => now()
                    ]);
            } else {
                DB::table('bookings')
                    ->where('bookings.id', $bookingID)
                    ->update([
                        'event_venue_id' => $request->eventVenue,
                        'start_date' => $request->startDate,
                        'end_date' => $request->endDate,
                        'start_time' => $request->startTime,
                        'end_time' => $request->endTime,
                        'number_of_guests' => $request->numberOfGuests,
                        'remarks' => $request->remarks,
                        'updated_at' => now()
                    ]);
            }

            return redirect('/evbs/bookings/guest-bookings')->with('success', 'Guest booking updated successfully!');
        }
    }

    public function updateVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $request->validate([
                'eventVenue' => 'nullable',
                'startDate' => 'nullable',
                'endDate' => 'nullable',
                'startTime' => 'required',
                'endTime' => 'required',
                'remarks' => 'nullable'
            ]);

            $bookingID = $request->segment(3);

            // update event venue, start date & end date if these fields are not empty
            if ($request->eventVenue == "" || $request->startDate == "" || $request->endDate == "") {
                DB::table('bookings')
                    ->where('bookings.id', $bookingID)
                    ->update([
                        'start_time' => $request->startTime,
                        'end_time' => $request->endTime,
                        'remarks' => $request->remarks,
                        'updated_at' => now()
                    ]);
            } else {
                DB::table('bookings')
                    ->where('bookings.id', $bookingID)
                    ->update([
                        'event_venue_id' => $request->eventVenue,
                        'start_date' => $request->startDate,
                        'end_date' => $request->endDate,
                        'start_time' => $request->startTime,
                        'end_time' => $request->endTime,
                        'remarks' => $request->remarks,
                        'updated_at' => now()
                    ]);
            }

            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking updated successfully!');
        }
    }

    // cancel booking
    public function cancelGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);

            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->update([
                    'status' => 0,
                    'updated_at' => now()
                ]);

            return redirect('/evbs/bookings/guest-bookings')->with('success', 'Guest booking cancelled successfully!');
        }
    }

    public function cancelVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);

            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->update([
                    'status' => 0,
                    'updated_at' => now()
                ]);

            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking cancelled successfully!');
        }
    }

    // delete data from database
    public function deleteGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);

            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->delete();

            return redirect('/evbs/bookings/guest-bookings')->with('success', 'Guest booking deleted successfully!');
        }
    }

    public function deleteVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);

            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->delete();

            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking deleted successfully!');
        }
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
        } else {
            //
        }
    }

    // display booking successful page
    public function bookingSuccessful()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            //
        }
    }

    // view booking
    public function viewBooking()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            //
        }
    }

    // cancel booking
    public function cancelBooking()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            //
        }
    }
}
