<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Urban Space Event Venue Booking System</title>
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

    {{-- select2 css & js --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
</head>

<style>
    input {
        outline-color: #14b8a6;
    }

    select {
        outline-color: #14b8a6;
    }

    textarea {
        outline-color: #14b8a6;
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
        background: #14b8a6 !important;
        border: 0px;
        width: 2.4rem;
    }

    /* pagination buttons - selected - hover */
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #fff !important;
        background: #0f766e !important;
        border: 0px;
        width: 2.4rem;
    }
</style>

<body>
    <div class="min-h-screen bg-neutral-100"> {{-- full screen --}}
        <nav class="fixed top-0 z-50 w-full bg-white border"> {{-- header --}}
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <button onclick="showHideSidebar()" data-drawer-target="sidebar" data-drawer-toggle="sidebar"
                            aria-controls="sidebar" type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-200">
                            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                                </path>
                            </svg>
                        </button>

                        <a href="/evbs/dashboard">
                            <img class="cursor-pointer"
                                src="{{ env('CLOUD_FRONT_URL') }}/assets/urban-space-logo-black.jpg" alt=""
                                style="width: 200px; height: 38px;">
                        </a>
                    </div>

                    @php
                        $authUserID = session('user')->id;
                        
                        if (session('user_role') == 'Super Admin') {
                            $authUser = DB::table('super_admins')
                                ->select('super_admins.first_name', 'super_admins.last_name')
                                ->where('super_admins.id', $authUserID)
                                ->first();
                        } elseif (session('user_role') == 'Event Venue Owner') {
                            $authUser = DB::table('event_venue_owners')
                                ->select('event_venue_owners.first_name', 'event_venue_owners.last_name')
                                ->where('event_venue_owners.id', $authUserID)
                                ->first();
                        }
                    @endphp

                    <div class="flex items-center">
                        <a href="/evbs/profile"
                            class="flex flex-row p-1.5 items-center rounded-lg hover:bg-gray-200 transition mr-4">
                            <span class="flex flex-col">
                                <span
                                    class="text-right font-semibold tracking-wide leading-none">{{ $authUser->first_name }}
                                    {{ $authUser->last_name }}</span>
                                <span
                                    class="text-right text-gray-500 text-xs leading-none mt-1">{{ session('user_role') }}</span>
                            </span>
                        </a>

                        <form action="/evbs/logout" method="GET">
                            @csrf

                            <a href="/evbs/logout" class="p-2.5 rounded-lg hover:bg-red-100 transition"
                                id="sign-out-confirmation">
                                <span class="text-xl text-red-500"><i class="bx bx-log-out"></i></span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </nav> {{-- end header --}}

        <aside id="sidebar"
            class="fixed w-64 h-screen bg-white border pt-16 transition lg:translate-x-0 md:translate-x-0 sm:-translate-x-full translate-x-0 lg:block md:hidden sm:hidden hidden">
            {{-- sidebar --}}
            <div class="h-full px-3 pt-5 pb-4 overflow-y-auto bg-white">
                <ul class="font-medium">
                    <li class="px-3">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-xs font-semibold tracking-wide text-gray-600">DASHBOARD</div>
                        </div>
                    </li>

                    <li>
                        <a href="/evbs/dashboard"
                            class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                            <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                    class="bx bx-chart"></i></span>
                            <span class="text-sm font-medium ml-3">Dashboard</span>
                        </a>
                    </li>

                    <div class="mt-5"></div>

                    <li class="px-3">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-xs font-semibold tracking-wide text-gray-600">BOOKING MANAGEMENT</div>
                        </div>
                    </li>

                    <li>
                        <a href="/evbs/bookings/guest-bookings"
                            class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                            <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                    class="bx bx-notepad"></i></span>
                            <span class="text-sm font-medium ml-3">Guest Booking</span>
                        </a>
                    </li>

                    <li>
                        <a href="/evbs/bookings/venue-blockings"
                            class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                            <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                    class="bx bx-calendar-x"></i></span>
                            <span class="text-sm font-medium ml-3">Venue Blocking</span>
                        </a>
                    </li>

                    <div class="mt-5"></div>

                    <li class="px-3">
                        <div class="flex flex-row items-center h-8">
                            <div class="text-xs font-semibold tracking-wide text-gray-600">EVENT MANAGEMENT</div>
                        </div>
                    </li>

                    @if (session('user_role') == 'Super Admin')
                        <li>
                            <a href="/evbs/event-types"
                                class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                        class="bx bx-list-ul"></i></span>
                                <span class="text-sm font-medium ml-3">Event Type</span>
                            </a>
                        </li>
                    @endif

                    <li>
                        <a href="/evbs/event-venues"
                            class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                            <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                    class="bx bx-building-house"></i></span>
                            <span class="text-sm font-medium ml-3">Event Venue</span>
                        </a>
                    </li>

                    @if (session('user_role') == 'Super Admin')
                        <div class="mt-5"></div>

                        <li class="px-3">
                            <div class="flex flex-row items-center h-8">
                                <div class="text-xs font-semibold tracking-wide text-gray-600">USER MANAGEMENT</div>
                            </div>
                        </li>

                        <li>
                            <a href="/evbs/super-admins"
                                class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                        class="bx bx-user"></i></span>
                                <span class="text-sm font-medium ml-3">Super Admin</span>
                            </a>
                        </li>

                        <li>
                            <a href="/evbs/event-venue-owners"
                                class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                        class="bx bx-user"></i></span>
                                <span class="text-sm font-medium ml-3">Event Venue Owner</span>
                            </a>
                        </li>

                        <li>
                            <a href="/evbs/guests"
                                class="flex items-center p-2 rounded-lg text-gray-700 hover:bg-teal-100 transition">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-lg text-gray-700"><i
                                        class="bx bx-user"></i></span>
                                <span class="text-sm font-medium ml-3">Guest</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </aside> {{-- end sidebar --}}

        <div class="min-h-screen py-16 lg:ml-64"> {{-- content container --}}
            <div class="flex flex-col p-6"> {{-- content --}}
