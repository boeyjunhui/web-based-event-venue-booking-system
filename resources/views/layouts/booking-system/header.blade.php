<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Urban Space Event Venue Booking</title>
    <link rel="icon" href="{{ asset('/assets/urban-space-logo-black.png') }}">

    {{-- tailwind css --}}
    @vite('resources/css/app.css')

    {{-- boxicons --}}
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css">

    {{-- jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    {{-- sweetalert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- jquery datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
</head>

<style>
    input {
        outline-color: #cabda5;
    }

    select {
        outline-color: #cabda5;
    }

    textarea {
        outline-color: #cabda5;
    }

        /* custom css for jquery datatable */
    /* form label */
    .dataTables_wrapper label {
        color: #1f2937;
        font-size: 0.875rem;
        font-weight: 450;
    }

    /* form input */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        color: #1f2937;
        font-size: 0.875rem;
        font-weight: 450;
        line-height: 1.25rem;
        padding: .5rem;
        margin-bottom: 1rem;
        padding-bottom: .5rem;
        border-width: 1px;
        border-radius: .375rem;
        border-color: #d1d5db;
        background-color: #fff;
    }

    /* form input - select */
    .dataTables_wrapper .dataTables_length select {
        margin-left: .2rem;
        margin-right: .2rem;
    }

    /* form input - input */
    .dataTables_wrapper .dataTables_filter input {
        margin-left: .5rem;
        width: 15rem;
    }

    /* form input - input - focus */
    .dataTables_wrapper .dataTables_filter input:focus {
        outline-offset: 0px;
    }

    /* no data available in table */
    .dataTables_wrapper .dataTables_empty {
        color: #1f2937;
        font-size: 0.875rem;
        font-weight: 450;
    }

    /* table border & margin */
    table.dataTable.no-footer {
        border-bottom: .2px solid #d1d5db;
        margin-top: 1em;
        margin-bottom: 1em;
    }

    /* table showing data entries info */
    .dataTables_wrapper .dataTables_info {
        color: #1f2937;
        font-size: 0.875rem;
        font-weight: 450;
    }

    /* pagination buttons */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        color: #666 !important;
        font-size: 0.875rem;
        font-weight: 450;
        border: 0px;
        border-radius: .375rem;
        padding: 8px;
        margin-left: .2rem;
        margin-right: .2rem;
        margin-bottom: .7rem;
    }

    /* pagination buttons - hover */
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        color: #666 !important;
        font-size: 0.875rem;
        font-weight: 450;
        border: 0px;
        border-radius: .375rem;
        padding: 8px;
        margin-left: .1.5rem;
        margin-right: .1.5rem;
        margin-bottom: .7rem;
        background: #e5e7eb !important;
        transition-duration: 150ms;
    }

    /* pagination buttons - selected */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        color: #fff !important;
        background: #b8a585 !important;
        border: 0px;
        width: 2.4rem;
    }

    /* pagination buttons - selected - hover */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #fff !important;
        background: #a9936d !important;
        border: 0px;
        width: 2.4rem;
    }
</style>

@php
    if (session('user_role') != "") {
        $loggedInGuestID = session('user')->id;

        if (session('user_role') == "Guest") {
            $loggedInGuest = DB::table('guests')
                ->select('guests.first_name', 'guests.last_name')
                ->where('guests.id', $loggedInGuestID)
                ->first();
        }
    }
@endphp

<body>
    <header>
        <nav class="bg-brown-300 border-b border-gray-200 px-4 lg:px-6 py-2">
            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                <a href="/" class="flex items-center">
                    <img class="mr-3 h-6 sm:h-9" src="{{env('CLOUD_FRONT_URL')}}/assets/urban-space-logo-black.png" alt="" style="width: 260px; height: 48px;">
                </a>

                <div class="flex items-center lg:order-2">
                    @if (session('user_role') != "Guest")
                        <a href="/login" class="text-xs font-bold text-gray-800 border-2 border-gray-800 hover:bg-brown-100 tracking-wider rounded-md transition px-3 py-2 mr-4">LOG IN</a>
                        <a href="/register" class="text-xs font-bold text-gray-800 border-2 border-gray-800 hover:bg-brown-100 tracking-wider rounded-md transition px-3 py-2 mr-4">REGISTER</a>
                        <a href="/event-venue-owner/register" class="text-xs font-bold text-gray-800 border-2 border-gray-800 hover:bg-brown-100 tracking-wider rounded-md transition px-3 py-2 mr-2">REGISTER AS OWNER</a>
                    @elseif (session('user_role') == "Guest")
                        {{-- profile dropdown --}}
                        <button id="dropdownNavbarLink" data-dropdown-toggle="dropdownNavbar">
                            <img src="{{env('CLOUD_FRONT_URL')}}/assets/user.jpg" alt="" class="h-10 w-10 bg-gray-200 border-2 border-brown-100 rounded-full">
                        </button>

                        <div id="dropdownNavbar" class="hidden bg-white text-base z-10 list-none divide-y divide-gray-100 rounded shadow my-4 w-44">
                            <ul class="py-1">
                                <li>
                                    <a href="/profile" class="text-sm text-gray-800 hover:bg-brown-100 transition block px-4 py-2">My Profile</a>
                                </li>
                            </ul>

                            <div class="py-1">
                                <form action="/logout" method="GET">
                                    @csrf

                                    <a href="/logout" class="text-sm text-gray-800 hover:bg-brown-100 transition block px-4 py-2" id="sign-out-confirmation">Sign Out</a>
                                </form>
                            </div>
                        </div>
                    @endif

                    <button data-collapse-toggle="mobile-menu" type="button" class="inline-flex items-center p-2 ml-4 text-sm text-gray-800 lg:hidden hover:bg-brown-100 rounded-md transition" aria-controls="mobile-menu-2" aria-expanded="false">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>

                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu">
                    <ul class="flex flex-col mt-4 font-bold lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="/" class="text-gray-800 tracking-wider lg:p-0">EVENT VENUES</a>
                        </li>

                        @if (session('user_role') == "Guest")
                            <li>
                                <a href="/bookings" class="text-gray-800 tracking-wider lg:p-0">BOOKINGS</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <script src="https://unpkg.com/@themesberg/flowbite@1.1.1/dist/flowbite.bundle.js"></script>