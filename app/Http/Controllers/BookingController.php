<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\XRayController;

class BookingController extends Controller
{
    public function __construct(XRayController $xRayController)
    {
        $this->xRayController = $xRayController;
    }

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

            $this->xRayController->begin();
            $this->xRayController->startRds();

            $guestsQuery = DB::table('guests')
                ->select('guests.id', 'guests.first_name', 'guests.last_name', 'guests.email')
                ->where('guests.status', 1)
                ->orderBy('guests.created_at', 'asc');
            $guests = $guestsQuery->get();

            $this->xRayController->addRdsQuery($guestsQuery->toSql());


            if (session('user_role') == "Super Admin") {
                $this->xRayController->startRds();

                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();

                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());

            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;
                $this->xRayController->startRds();

                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();
                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());
            }
            $this->xRayController->end();

            $this->xRayController->submit();
            return view('bookings.management-system.add-guest-booking', compact('guests', 'eventVenues'));
        }
    }

    public function addVenueBlocking()
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            if (session('user_role') == "Super Admin") {
                $this->xRayController->startRds();

                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();
                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;
                $this->xRayController->startRds();

                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();
                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());
            }
            $this->xRayController->end();

            $this->xRayController->submit();
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
            $this->xRayController->begin();
            $this->xRayController->startRds();

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
            $this->xRayController->addRdsQuery('insert into bookings');
            $this->xRayController->startRds();

            // booking confirmation email
            $guestQuery = DB::table('guests')
                ->select('guests.first_name', 'guests.last_name', 'guests.email', 'guests.phone_number')
                ->where('guests.id', $request->guest);
            $guest = $guestQuery->first();
            $this->xRayController->addRdsQuery($guestQuery->toSql());
            $this->xRayController->startRds();
            $eventVenueQuery = DB::table('event_venues')
                ->select('event_venues.event_venue_name', 'event_venues.address', 'event_venues.postal_code', 'event_venues.city', 'event_venues.state', 'event_venues.country')
                ->where('event_venues.id', $request->eventVenue);
            $eventVenue = $eventVenueQuery->first();
            $this->xRayController->addRdsQuery($eventVenueQuery->toSql());

            Mail::send('emails.booking-system.quotation-request', ['name' => $guest->first_name . ' ' . $guest->last_name, 'eventVenueName' => $eventVenue->event_venue_name, 'address' => $eventVenue->address . ', ' . $eventVenue->postal_code . ', ' . $eventVenue->city . ', ' . $eventVenue->state . ', ' . $eventVenue->country . '.', 'startDate' => $request->startDate, 'endDate' => $request->endDate, 'startTime' => $request->startTime, 'endTime' => $request->endTime, 'numberOfGuests' => $request->numberOfGuests, 'remarks' => $request->remarks], function ($message) use ($guest) {
                $message->to($guest->email);
                $message->subject('Quotation Request');
            });

            // booking sms
            $params = [
                'Message' => 'We\'ve received your quotation request for ' . $eventVenue->event_venue_name . '. Please refer to your email for official quotation.',
                'PhoneNumber' => '+60132911366',
            ];
            $this->xRayController->startSNS();
            $sns = \Illuminate\Support\Facades\App::make('aws')->createClient('sns');
            $result = $sns->publish($params);
            $this->xRayController->end();
            $this->xRayController->submit();

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
            $this->xRayController->begin();
            $this->xRayController->startRds();
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
            $this->xRayController->addRdsQuery('insert into bookings');
            $this->xRayController->startRds();
            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking created successfully!');
        }
    }

    // get all rows of data from database
    public function viewAllGuestBookings(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            if (session('user_role') == "Super Admin") {
                $guestBookingsQuery = DB::table('bookings')
                    ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                    ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 1)
                    ->orderBy('bookings.created_at', 'desc');
                $guestBookings = $guestBookingsQuery->get();

                $this->xRayController->addRdsQuery($guestBookingsQuery->toSql());
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $guestBookingsQuery = DB::table('bookings')
                    ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                    ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 1)
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->orderBy('bookings.created_at', 'desc');
                $guestBookings = $guestBookingsQuery->get();

                $this->xRayController->addRdsQuery($guestBookingsQuery->toSql());
            }
            $this->xRayController->end();
            $this->xRayController->submit();

            return view('bookings.management-system.view-all-guest-bookings', compact('guestBookings'));
        }
    }

    public function viewAllVenueBlockings(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $this->xRayController->begin();
            $this->xRayController->startRds();
            if (session('user_role') == "Super Admin") {
                $venueBlockingsQuery = DB::table('bookings')
                    ->select('bookings.*', 'event_venues.event_venue_name')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 2)
                    ->orderBy('bookings.created_at', 'desc');
                $venueBlockings = $venueBlockingsQuery->get();
                $this->xRayController->addRdsQuery($venueBlockingsQuery->toSql());
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $venueBlockingsQuery = DB::table('bookings')
                    ->select('bookings.*', 'event_venues.event_venue_name')
                    ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                    ->where('bookings.booking_type', 2)
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->orderBy('bookings.created_at', 'desc');
                $venueBlockings = $venueBlockingsQuery->get();
                $this->xRayController->addRdsQuery($venueBlockingsQuery->toSql());
            }
            $this->xRayController->end();
            $this->xRayController->submit();
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
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $guestBookingQuery = DB::table('bookings')
                ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID)
                ->where('bookings.booking_type', 1);
            $guestBooking = $guestBookingQuery->first();
            $this->xRayController->addRdsQuery($guestBookingQuery->toSql());
            $this->xRayController->end();
            $this->xRayController->submit();
            return view('bookings.management-system.view-guest-booking', compact('guestBooking'));
        }
    }

    public function viewVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(4);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $venueBlockingQuery = DB::table('bookings')
                ->select('bookings.*', 'event_venues.event_venue_name')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID)
                ->where('bookings.booking_type', 2);
            $venueBlocking = $venueBlockingQuery->first();
            $this->xRayController->addRdsQuery($venueBlockingQuery->toSql());
            $this->xRayController->end();
            $this->xRayController->submit();
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
            $this->xRayController->begin();
            $this->xRayController->startRds();
            if (session('user_role') == "Super Admin") {
                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();
                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();
                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());
            }
            $this->xRayController->startRds();
            $guestBookingQuery = DB::table('bookings')
                ->select('bookings.*', 'guests.first_name', 'guests.last_name', 'event_venues.event_venue_name')
                ->join('guests', 'guests.id', '=', 'bookings.guest_id')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID);
            $guestBooking = $guestBookingQuery->first();
            $this->xRayController->addRdsQuery($guestBookingQuery->toSql());
            $this->xRayController->end();
            $this->xRayController->submit();
            return view('bookings.management-system.edit-guest-booking', compact('eventVenues', 'guestBooking'));
        }
    }

    public function editVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            if (session('user_role') == "Super Admin") {
                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();
                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());
            } else if (session('user_role') == "Event Venue Owner") {
                $eventVenueOwnerID = session('user')->id;

                $eventVenuesQuery = DB::table('event_venues')
                    ->select('event_venues.id', 'event_venues.event_venue_name')
                    ->where('event_venues.event_venue_owner_id', $eventVenueOwnerID)
                    ->where('event_venues.status', 1)
                    ->orderBy('event_venues.created_at', 'asc');
                $eventVenues = $eventVenuesQuery->get();
                $this->xRayController->addRdsQuery($eventVenuesQuery->toSql());
            }

            $venueBlockingQuery = DB::table('bookings')
                ->select('bookings.*', 'event_venues.event_venue_name')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID)
                ->first();
            $venueBlocking = $venueBlockingQuery->first();
            $this->xRayController->addRdsQuery($venueBlockingQuery->toSql());
            $this->xRayController->end();
            $this->xRayController->submit();
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

            $this->xRayController->begin();
            $this->xRayController->startRds();
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
                $this->xRayController->addRdsQuery('update bookings where');

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
                $this->xRayController->addRdsQuery('update bookings where');
            }
            $this->xRayController->end();
            $this->xRayController->submit();
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
            $this->xRayController->begin();
            $this->xRayController->startRds();
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
                $this->xRayController->addRdsQuery('update bookings where');
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
                $this->xRayController->addRdsQuery('update bookings where');
            }
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking updated successfully!');
        }
    }

    // confirm booking
    public function confirmGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->update([
                    'status' => 2,
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update bookings where');
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/evbs/bookings/guest-bookings')->with('success', 'Guest booking confirmed successfully!');
        }
    }

    public function confirmVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->update([
                    'status' => 2,
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update bookings where');
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking confirmed successfully!');
        }
    }

    // cancel booking
    public function cancelGuestBooking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->update([
                    'status' => 0,
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update bookings where');
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/evbs/bookings/guest-bookings')->with('success', 'Guest booking cancelled successfully!');
        }
    }

    public function cancelVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->update([
                    'status' => 0,
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update bookings where');
            $this->xRayController->end();
            $this->xRayController->submit();
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
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->delete();
            $this->xRayController->addRdsQuery('delete from bookings');
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/evbs/bookings/guest-bookings')->with('success', 'Guest booking deleted successfully!');
        }
    }

    public function deleteVenueBlocking(Request $request)
    {
        if (session('user_role') != "Super Admin" && session('user_role') != "Event Venue Owner") {
            return redirect('/evbs/login');
        } else {
            $bookingID = $request->segment(3);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->delete();
            $this->xRayController->addRdsQuery('delete from bookings');
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/evbs/bookings/venue-blockings')->with('success', 'Venue blocking deleted successfully!');
        }
    }

    /* ========================================
    Guest
    ======================================== */
    // display make booking page
    public function makeBooking(Request $request)
    {
        $eventVenueID = $request->segment(2);
        $this->xRayController->begin();
        $this->xRayController->startRds();
        $eventVenueQuery = DB::table('event_venues')
            ->select('event_venues.*', 'event_types.event_type_name')
            ->join('event_types', 'event_types.id', '=', 'event_venues.event_type_id')
            ->where('event_venues.id', $eventVenueID);
        $eventVenue = $eventVenueQuery->first();
        $this->xRayController->addRdsQuery($eventVenueQuery->toSql());
        $this->xRayController->end();
        $this->xRayController->submit();
        return view('bookings.booking-system.make-booking', compact('eventVenueID', 'eventVenue'));
    }

    // insert booking data into database
    public function placeBooking(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $request->validate([
                'startDate' => 'required',
                'endDate' => 'required',
                'startTime' => 'required',
                'endTime' => 'required',
                'numberOfGuests' => 'required|integer|min:1',
                'remarks' => 'nullable'
            ]);

            $guestID = session('user')->id;
            $eventVenueID = $request->eventVenueID;
            $startDate = $request->startDate;
            $endDate = $request->endDate;
            $startTime = $request->startTime;
            $endTime = $request->endTime;
            $numberOfGuests = $request->numberOfGuests;
            $remarks = $request->remarks;
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->insert([
                    'id' => Str::random(30),
                    'booking_type' => 1,
                    'guest_id' => $guestID,
                    'event_venue_id' => $eventVenueID,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                    'number_of_guests' => $numberOfGuests,
                    'remarks' => $remarks,
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('insert into bookings');
            $this->xRayController->startRds();

            // booking confirmation email
            $guestQuery = DB::table('guests')
                ->select('guests.first_name', 'guests.last_name', 'guests.email', 'guests.phone_number')
                ->where('guests.id', $guestID);
            $guest = $guestQuery->first();
            $this->xRayController->addRdsQuery($guestQuery->toSql());
            $this->xRayController->startRds();
            $eventVenueQuery = DB::table('event_venues')
                ->select('event_venues.event_venue_name', 'event_venues.address', 'event_venues.postal_code', 'event_venues.city', 'event_venues.state', 'event_venues.country')
                ->where('event_venues.id', $eventVenueID);
            $eventVenue = $eventVenueQuery->first();
            $this->xRayController->addRdsQuery($eventVenueQuery->toSql());

            Mail::send('emails.booking-system.quotation-request', ['name' => $guest->first_name . ' ' . $guest->last_name, 'eventVenueName' => $eventVenue->event_venue_name, 'address' => $eventVenue->address . ', ' . $eventVenue->postal_code . ', ' . $eventVenue->city . ', ' . $eventVenue->state . ', ' . $eventVenue->country . '.', 'startDate' => $startDate, 'endDate' => $endDate, 'startTime' => $startTime, 'endTime' => $endTime, 'numberOfGuests' => $numberOfGuests, 'remarks' => $remarks], function ($message) use ($guest) {
                $message->to($guest->email);
                $message->subject('Quotation Request');
            });

            // booking sms
            $params = [
                'Message' => 'We\'ve received your quotation request for ' . $eventVenue->event_venue_name . '. Please refer to your email for official quotation.',
                'PhoneNumber' => '+60132911366',
            ];
            $this->xRayController->startSNS();
            $sns = \Illuminate\Support\Facades\App::make('aws')->createClient('sns');
            $result = $sns->publish($params);
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/bookings')->with('success', 'Quotation requested successfully!');
        }
    }

    // view all bookings
    public function viewAllBookings()
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $guestID = session('user')->id;
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $bookingsQuery = DB::table('bookings')
                ->select('bookings.*', 'event_venues.event_venue_name')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.guest_id', $guestID)
                ->orderBy('bookings.created_at', 'desc');
            $bookings = $bookingsQuery->get();
            $this->xRayController->addRdsQuery($bookingsQuery->toSql());
            $this->xRayController->end();
            $this->xRayController->submit();
            return view('bookings.booking-system.view-all', compact('bookings'));
        }
    }

    // view one booking
    public function viewBooking(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $bookingID = $request->segment(2);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            $bookingQuery = DB::table('bookings')
                ->select('bookings.*', 'event_venues.event_venue_name', 'event_venues.address', 'event_venues.postal_code', 'event_venues.city', 'event_venues.state', 'event_venues.country')
                ->join('event_venues', 'event_venues.id', '=', 'bookings.event_venue_id')
                ->where('bookings.id', $bookingID);
            $booking = $bookingQuery->first();
            $this->xRayController->addRdsQuery($bookingQuery->toSql());
            $this->xRayController->end();
            $this->xRayController->submit();
            return view('bookings.booking-system.view', compact('booking'));
        }
    }

    // cancel booking
    public function cancelBooking(Request $request)
    {
        if (session('user_role') != "Guest") {
            return redirect('/login');
        } else {
            $bookingID = $request->segment(2);
            $this->xRayController->begin();
            $this->xRayController->startRds();
            DB::table('bookings')
                ->where('bookings.id', $bookingID)
                ->update([
                    'status' => 0,
                    'updated_at' => now()
                ]);
            $this->xRayController->addRdsQuery('update bookings where');
            $this->xRayController->end();
            $this->xRayController->submit();
            return redirect('/bookings')->with('success', 'Booking cancelled successfully!');
        }
    }
}