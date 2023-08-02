@extends('layouts.management-system')

@section('content')
    <p class="text-gray-400"><a href="/evbs/bookings/guest-bookings" class="hover:underline hover:text-teal-500 transition">Guest Bookings</a> / <span class="text-teal-500">{{ $guestBooking->id }}</span></p>

    @if (session('success'))
        <div class="p-3 mt-4 text-sm text-teal-800 border border-teal-200 rounded-lg bg-teal-100">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="p-3 mt-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="p-4 bg-white rounded-lg mt-6">
        <div class="grid grid-cols-1 mt-2">
            <label for="guestBooking" class="p-2 text-xl font-bold text-gray-800">
                Guest Booking

                <span class="ml-2">
                    @if ($guestBooking->status == 0)
                        <span class="p-1.5 text-sm font-medium text-white bg-red-500 rounded-lg">Cancelled</span>
                    @elseif ($guestBooking->status == 1)
                        <span class="p-1.5 text-sm font-medium text-white bg-gray-500 rounded-lg">Pending</span>
                    @elseif ($guestBooking->status == 2)
                        <span class="p-1.5 text-sm font-medium text-white bg-teal-500 rounded-lg">Confirmed</span>
                    @endif
                </span>
            </label>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mt-4 mb-2">
            <div class="grid grid-cols-2 gap-2">
                <label for="guest" class="p-2 font-bold text-gray-800">Guest</label>
                <label for="guest" class="p-2 font-medium text-justify text-gray-800">
                    @if (session('user_role') == "Super Admin")
                        <a href="/evbs/guests/{{ $guestBooking->guest_id }}" class="hover:underline hover:text-teal-500 transition" target="_blank">{{ $guestBooking->first_name }} {{ $guestBooking->last_name }}</a>
                    @elseif (session('user_role') == "Event Venue Owner")
                        {{ $guestBooking->first_name }} {{ $guestBooking->last_name }}
                    @endif
                </label>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-2">
            <div class="grid grid-cols-2 gap-2">
                <label for="eventVenue" class="p-2 font-bold text-gray-800">Event Venue</label>
                <label for="eventVenue" class="p-2 font-medium text-gray-800">
                    <a href="/evbs/event-venues/{{ $guestBooking->event_venue_id }}" class="hover:underline hover:text-teal-500 transition" target="_blank">{{ $guestBooking->event_venue_name }}</a>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-2">
            <div class="grid grid-cols-2 gap-2">
                <label for="startDate" class="p-2 font-bold text-gray-800">Start Date</label>
                <label for="startDate" class="p-2 font-medium text-gray-800">{{ $guestBooking->start_date }}</label>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <label for="endDate" class="p-2 font-bold text-gray-800">End Date</label>
                <label for="endDate" class="p-2 font-medium text-gray-800">{{ $guestBooking->end_date }}</label>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-2">
            <div class="grid grid-cols-2 gap-2">
                <label for="startTime" class="p-2 font-bold text-gray-800">Start Time</label>
                <label for="startTime" class="p-2 font-medium text-gray-800">{{ $guestBooking->start_time }}</label>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <label for="endTime" class="p-2 font-bold text-gray-800">End Time</label>
                <label for="endTime" class="p-2 font-medium text-gray-800">{{ $guestBooking->end_time }}</label>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-2">
            <div class="grid grid-cols-2 gap-2">
                <label for="numberOfGuests" class="p-2 font-bold text-gray-800">Number of Guests</label>
                <label for="numberOfGuests" class="p-2 font-medium text-gray-800">{{ number_format($guestBooking->number_of_guests) }}</label>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-2">
            <div class="grid grid-cols-2 gap-2">
                <label for="remarks" class="p-2 font-bold text-gray-800">Remarks</label>
                <label for="remarks" class="p-2 font-medium text-gray-800">{{ $guestBooking->remarks }}</label>
            </div>
        </div>

        @if ($guestBooking->status == 1)
            <div class="grid grid-cols-1 justify-center gap-8 mt-20 mb-6" style="display: flex;">
                <a href="/evbs/bookings/{{ $guestBooking->id }}/edit-guest-booking"><button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Edit</button></a>

                <form action="/evbs/bookings/{{ $guestBooking->id }}/confirm-guest-booking" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-green-500 hover:bg-green-700 transition" id="confirm-guest-booking-confirmation">Confirm Booking</button>
                </form>

                <form action="/evbs/bookings/{{ $guestBooking->id }}/cancel-guest-booking" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="cancel-guest-booking-confirmation">Cancel Booking</button>
                </form>

                <form action="/evbs/bookings/{{ $guestBooking->id }}/delete-guest-booking" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="delete-confirmation">Delete</button>
                </form>
            </div>
        @endif
    </div>
@endsection
