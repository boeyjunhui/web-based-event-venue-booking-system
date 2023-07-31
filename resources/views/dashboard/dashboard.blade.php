@extends('layouts.management-system')

@section('content')
    <div class="grid justify-items-start">
        <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Dashboard</h1>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="grid grid-cols-2 p-6 bg-white rounded-lg mt-4">
            <div class="grid content-center">
                <label for="totalBookings" class="p-2 text-4xl text-gray-800">
                    <i class="bx bx-notepad p-5 rounded-full bg-violet-200"></i>
                </label>
            </div>

            <div class="grid grid-rows-2 text-right">
                <div class="grid content-end">
                    <label for="totalBookings" class="p-2 text-md font-medium text-gray-600">Total Guest Bookings</label>
                </div>

                <div class="grid content-start">
                    <label for="totalBookings" class="p-2 text-2xl font-bold text-gray-800">{{ $totalGuestBookings }}</label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 p-6 bg-white rounded-lg mt-4">
            <div class="grid content-center">
                <label for="totalEventVenues" class="p-2 text-4xl text-gray-800">
                    <i class="bx bx-building-house p-5 rounded-full bg-teal-200"></i>
                </label>
            </div>

            <div class="grid grid-rows-2 text-right">
                <div class="grid content-end">
                    <label for="totalEventVenues" class="p-2 text-md font-medium text-gray-600">Total Event Venues</label>
                </div>

                <div class="grid content-start">
                    <label for="totalEventVenues" class="p-2 text-2xl font-bold text-gray-800">{{ $totalEventVenues }}</label>
                </div>
            </div>
        </div>

        @if (session('user_role') == "Super Admin")
            <div class="grid grid-cols-2 p-6 bg-white rounded-lg mt-4">
                <div class="grid content-center">
                    <label for="totalEventTypes" class="p-2 text-4xl text-gray-800">
                        <i class="bx bx-list-ul p-5 rounded-full bg-blue-200"></i>
                    </label>
                </div>

                <div class="grid grid-rows-2 text-right">
                    <div class="grid content-end">
                        <label for="totalEventTypes" class="p-2 text-md font-medium text-gray-600">Total Event Types</label>
                    </div>

                    <div class="grid content-start">
                        <label for="totalEventTypes" class="p-2 text-2xl font-bold text-gray-800">{{ $totalEventTypes }}</label>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (session('user_role') == "Super Admin")
        <div class="grid grid-cols-3 gap-6">
            <div class="grid grid-cols-2 p-6 bg-white rounded-lg mt-4">
                <div class="grid content-center">
                    <label for="totalGuests" class="p-2 text-4xl text-gray-800">
                        <i class="bx bx-user p-5 rounded-full bg-orange-200"></i>
                    </label>
                </div>

                <div class="grid grid-rows-2 text-right">
                    <div class="grid content-end">
                        <label for="totalGuests" class="p-2 text-md font-medium text-gray-600">Total Guests</label>
                    </div>

                    <div class="grid content-start">
                        <label for="totalGuests" class="p-2 text-2xl font-bold text-gray-800">{{ $totalGuests }}</label>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 p-6 bg-white rounded-lg mt-6">
                <div class="grid content-center">
                    <label for="totalEventVenueOwners" class="p-2 text-4xl text-gray-800">
                        <i class="bx bx-user p-5 rounded-full bg-cyan-200"></i>
                    </label>
                </div>

                <div class="grid grid-rows-2 text-right">
                    <div class="grid content-end">
                        <label for="totalEventVenueOwners" class="p-2 text-md font-medium text-gray-600">Total Event Venue Owners</label>
                    </div>

                    <div class="grid content-start">
                        <label for="totalEventVenueOwners" class="p-2 text-2xl font-bold text-gray-800">{{ $totalEventVenueOwners }}</label>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
