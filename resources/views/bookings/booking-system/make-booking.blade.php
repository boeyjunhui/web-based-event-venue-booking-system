@extends('layouts.booking-system')

@section('content')
    <div class="flex min-h-screen bg-gray-100 px-6 py-6">
        <div class="flex-1 h-full max-w-7xl mx-auto bg-white rounded-xl shadow-xl mt-10 mb-10">
            <button onclick="history.back()" class="text-sm font-bold text-gray-800 bg-white border-2 border-gray-800 hover:bg-brown-100 tracking-wider rounded-md transition px-3 py-2 mt-8 ml-6 lg:ml-10 md:ml-10"><i class="bx bx-arrow-back"></i> Back</button>

            <div class="flex flex-col md:flex-row">
                <div class="flex p-6 sm:p-10 md:w-1/2">
                    <div class="w-full">
                        <div class="mb-4">
                            <p class="block mb-2 text-2xl font-bold text-gray-800">{{ $eventVenue->event_venue_name }}</p>
                        </div>

                        <div class="mb-4">
                            <p class="block mb-6 text-sm text-gray-800"><i class="bx bx-map mr-2"></i>{{ $eventVenue->address }}, {{ $eventVenue->postal_code }} {{ $eventVenue->city }}, {{ $eventVenue->state }}, {{ $eventVenue->country }}.</p>
                        </div>

                        <hr>

                        <div class="mt-6 mb-6">
                            <p class="block mb-2 text-lg font-bold text-gray-800">About {{ $eventVenue->event_venue_name }}</p>
                            <pre class="block font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->event_venue_description }}</pre>
                        </div>

                        <hr>

                        <div class="mt-6 mb-6">
                            <p class="block mb-2 text-lg font-bold text-gray-800">Size</p>
                            <pre class="block mb-6 font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ number_format($eventVenue->size_measurement) }} {{ $eventVenue->size_measurement_unit }}</pre>

                            <p class="block mb-2 text-lg font-bold text-gray-800">Maximum Guests</p>
                            <pre class="block font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ number_format($eventVenue->maximum_guests) }} guests</pre>
                        </div>

                        <hr>

                        <div class="mt-6 mb-6">
                            <p class="block mb-2 text-lg font-bold text-gray-800">Availability</p>
                            <pre class="block font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->availability }}</pre>
                        </div>

                        <hr>

                        <div class="mt-6 mb-6">
                            <p class="block mb-2 text-lg font-bold text-gray-800">Packages & Pricing</p>
                            <pre class="block font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->packages_pricing }}</pre>
                        </div>

                        <hr>

                        <div class="mt-6">
                            <p class="block mb-2 text-lg font-bold text-gray-800">Amenities</p>
                            <pre class="block mb-6 font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->amenities }}</pre>

                            <p class="block mb-2 text-lg font-bold text-gray-800">Accessibility</p>
                            <pre class="block mb-6 font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->accessibility }}</pre>

                            <p class="block mb-2 text-lg font-bold text-gray-800">Add-On Services</p>
                            <pre class="block font-sans text-sm text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->add_on_services }}</pre>
                        </div>
                    </div>
                </div>
                
                <div class="border-b"></div>

                <div class="flex justify-center p-6 sm:p-10 md:w-1/2">
                    <div class="w-full">
                        @if (session('success'))
                            <div class="p-3 mb-6 text-sm text-green-800 border border-green-200 rounded-lg bg-green-100">
                                {{ session('success') }}
                            </div>
                        @elseif (session('error'))
                            <div class="p-3 mb-6 text-sm text-red-800 border border-red-200 rounded-lg bg-red-100">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="/place-booking" method="POST" class="p-6 bg-white border rounded-xl shadow-xl">
                            @csrf

                            <input type="hidden" id="eventVenueID" name="eventVenueID" value="{{ $eventVenueID }}">

                            @if (session('user_role') == "Guest")
                                <div class="mb-4">
                                    <div class="grid grid-cols-2 gap-8">
                                        <div class="grid">
                                            <label for="startDate" class="block mb-2 text-sm font-medium text-gray-800">Start Date <span class="text-red-500">*</span></label>
                                            <input type="date" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" id="startDate" name="startDate">
                                            @error('startDate')
                                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid">
                                            <label for="endDate" class="block mb-2 text-sm font-medium text-gray-800">End Date <span class="text-red-500">*</span></label>
                                            <input type="date" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" id="endDate" name="endDate">
                                            @error('endDate')
                                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="grid grid-cols-2 gap-8">
                                        <div class="grid">
                                            <label for="startTime" class="block mb-2 text-sm font-medium text-gray-800">Start Time <span class="text-red-500">*</span></label>
                                            <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="startTime" name="startTime">
                                                <option value="">-- Select Start Time --</option>
                                                <option value="12:00 AM">12:00 AM</option>
                                                <option value="12:30 AM">12:30 AM</option>
                                                <option value="01:00 AM">01:00 AM</option>
                                                <option value="01:30 AM">01:30 AM</option>
                                                <option value="02:00 AM">02:00 AM</option>
                                                <option value="02:30 AM">02:30 AM</option>
                                                <option value="03:00 AM">03:00 AM</option>
                                                <option value="03:30 AM">03:30 AM</option>
                                                <option value="04:00 AM">04:00 AM</option>
                                                <option value="04:30 AM">04:30 AM</option>
                                                <option value="05:00 AM">05:00 AM</option>
                                                <option value="05:30 AM">05:30 AM</option>
                                                <option value="06:00 AM">06:00 AM</option>
                                                <option value="06:30 AM">06:30 AM</option>
                                                <option value="07:00 AM">07:00 AM</option>
                                                <option value="07:30 AM">07:30 AM</option>
                                                <option value="08:00 AM">08:00 AM</option>
                                                <option value="08:30 AM">08:30 AM</option>
                                                <option value="09:00 AM">09:00 AM</option>
                                                <option value="09:30 AM">09:30 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="10:30 AM">10:30 AM</option>
                                                <option value="11:00 AM">11:00 AM</option>
                                                <option value="11:30 AM">11:30 AM</option>
                                                <option value="12:00 PM">12:00 PM</option>
                                                <option value="12:30 PM">12:30 PM</option>
                                                <option value="01:00 PM">01:00 PM</option>
                                                <option value="01:30 PM">01:30 PM</option>
                                                <option value="02:00 PM">02:00 PM</option>
                                                <option value="02:30 PM">02:30 PM</option>
                                                <option value="03:00 PM">03:00 PM</option>
                                                <option value="03:30 PM">03:30 PM</option>
                                                <option value="04:00 PM">04:00 PM</option>
                                                <option value="04:30 PM">04:30 PM</option>
                                                <option value="05:00 PM">05:00 PM</option>
                                                <option value="05:30 PM">05:30 PM</option>
                                                <option value="06:00 PM">06:00 PM</option>
                                                <option value="06:30 PM">06:30 PM</option>
                                                <option value="07:00 PM">07:00 PM</option>
                                                <option value="07:30 PM">07:30 PM</option>
                                                <option value="08:00 PM">08:00 PM</option>
                                                <option value="08:30 PM">08:30 PM</option>
                                                <option value="09:00 PM">09:00 PM</option>
                                                <option value="09:30 PM">09:30 PM</option>
                                                <option value="10:00 PM">10:00 PM</option>
                                                <option value="10:30 PM">10:30 PM</option>
                                                <option value="11:00 PM">11:00 PM</option>
                                                <option value="11:30 PM">11:30 PM</option>
                                            </select>
                                            @error('startTime')
                                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid">
                                            <label for="endTime" class="block mb-2 text-sm font-medium text-gray-800">End Time <span class="text-red-500">*</span></label>
                                            <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="endTime" name="endTime">
                                                <option value="">-- Select End Time --</option>
                                                <option value="12:00 AM">12:00 AM</option>
                                                <option value="12:30 AM">12:30 AM</option>
                                                <option value="01:00 AM">01:00 AM</option>
                                                <option value="01:30 AM">01:30 AM</option>
                                                <option value="02:00 AM">02:00 AM</option>
                                                <option value="02:30 AM">02:30 AM</option>
                                                <option value="03:00 AM">03:00 AM</option>
                                                <option value="03:30 AM">03:30 AM</option>
                                                <option value="04:00 AM">04:00 AM</option>
                                                <option value="04:30 AM">04:30 AM</option>
                                                <option value="05:00 AM">05:00 AM</option>
                                                <option value="05:30 AM">05:30 AM</option>
                                                <option value="06:00 AM">06:00 AM</option>
                                                <option value="06:30 AM">06:30 AM</option>
                                                <option value="07:00 AM">07:00 AM</option>
                                                <option value="07:30 AM">07:30 AM</option>
                                                <option value="08:00 AM">08:00 AM</option>
                                                <option value="08:30 AM">08:30 AM</option>
                                                <option value="09:00 AM">09:00 AM</option>
                                                <option value="09:30 AM">09:30 AM</option>
                                                <option value="10:00 AM">10:00 AM</option>
                                                <option value="10:30 AM">10:30 AM</option>
                                                <option value="11:00 AM">11:00 AM</option>
                                                <option value="11:30 AM">11:30 AM</option>
                                                <option value="12:00 PM">12:00 PM</option>
                                                <option value="12:30 PM">12:30 PM</option>
                                                <option value="01:00 PM">01:00 PM</option>
                                                <option value="01:30 PM">01:30 PM</option>
                                                <option value="02:00 PM">02:00 PM</option>
                                                <option value="02:30 PM">02:30 PM</option>
                                                <option value="03:00 PM">03:00 PM</option>
                                                <option value="03:30 PM">03:30 PM</option>
                                                <option value="04:00 PM">04:00 PM</option>
                                                <option value="04:30 PM">04:30 PM</option>
                                                <option value="05:00 PM">05:00 PM</option>
                                                <option value="05:30 PM">05:30 PM</option>
                                                <option value="06:00 PM">06:00 PM</option>
                                                <option value="06:30 PM">06:30 PM</option>
                                                <option value="07:00 PM">07:00 PM</option>
                                                <option value="07:30 PM">07:30 PM</option>
                                                <option value="08:00 PM">08:00 PM</option>
                                                <option value="08:30 PM">08:30 PM</option>
                                                <option value="09:00 PM">09:00 PM</option>
                                                <option value="09:30 PM">09:30 PM</option>
                                                <option value="10:00 PM">10:00 PM</option>
                                                <option value="10:30 PM">10:30 PM</option>
                                                <option value="11:00 PM">11:00 PM</option>
                                                <option value="11:30 PM">11:30 PM</option>
                                            </select>
                                            @error('endTime')
                                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <div class="grid grid-cols-2 gap-8">
                                        <div class="grid">
                                            <label for="numberOfGuests" class="block mb-2 text-sm font-medium text-gray-800">Number of Guests <span class="text-red-500">*</span></label>
                                            <input type="number" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" id="numberOfGuests" name="numberOfGuests" value="{{ old('numberOfGuests') }}">
                                            @error('numberOfGuests')
                                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="remarks" class="block mb-2 text-sm font-medium text-gray-800">Remarks</label>
                                    <textarea class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="eventVenueAvailability"></div>

                                <button type="submit" class="p-2.5 w-full text-sm font-bold text-white rounded-md bg-brown-500 hover:bg-brown-700 transition mt-6 mb-2">Get a Quote</button>
                            @else
                                <button class="p-2.5 w-full text-sm font-bold text-white rounded-md bg-brown-500 hover:bg-brown-700 transition mt-2 mb-2"><a href="/login">Sign In to Get Quoted</a></button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-b"></div>

            <div class="flex flex-col md:flex-row">
                <div class="flex p-6 sm:p-10">
                    @php
                        $eventVenueImages = explode(',', $eventVenue->event_venue_images);
                    @endphp

                    <div class="grid lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-4">
                        @foreach ($eventVenueImages as $eventVenueImage)
                            @if ($eventVenueImages != "")
                                <a href="{{ env('CLOUD_FRONT_URL') .'/uploads/event-venues/' .$eventVenueImage }}" target="_blank">
                                    <img class="w-full border rounded-xl cursor-pointer" src="{{ env('CLOUD_FRONT_URL') .'/uploads/event-venues/' .$eventVenueImage }}" alt="" style="height: 200px;">
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

     {{-- date validation --}}
     <script>
        $(document).ready(function() {
            var d = new Date();
            var year = d.getFullYear();
            var month = d.getMonth() + 1;
            var date = d.getDate();
            var yesterdaysDate =  year + '-' + (month < 10 ? '0' : '') + month + '-' + (date < 10 ? '0' : '') + (date - 1);
            var startDate;
            var endDate;

            $('#startTime').prop('disabled', true);
            $('#endTime').prop('disabled', true);
            $('#numberOfGuests').prop('disabled', true);

            $('#startDate').change(function() {
                startDate = $('#startDate').val();

                if ((Date.parse(endDate) > Date.parse(startDate)) && (startDate > yesterdaysDate)) {
                    $('#startTime').prop('disabled', false);
                    $('#endTime').prop('disabled', false);
                    $('#numberOfGuests').prop('disabled', false);
                } else {
                    $('#startTime').prop('disabled', true);
                    $('#endTime').prop('disabled', true);
                    $('#numberOfGuests').prop('disabled', true);
                }
            });

            $('#endDate').change(function() {
                endDate = $('#endDate').val();

                if ((Date.parse(endDate) > Date.parse(startDate)) && (startDate > yesterdaysDate)) {
                    $('#startTime').prop('disabled', false);
                    $('#endTime').prop('disabled', false);
                    $('#numberOfGuests').prop('disabled', false);
                } else {
                    $('#startTime').prop('disabled', true);
                    $('#endTime').prop('disabled', true);
                    $('#numberOfGuests').prop('disabled', true);
                }
            });
        });
    </script>

    {{-- check event venue availability --}}
    <script>
        $(document).ready(function() {
            // get event venue id
            var eventVenueID = $('#eventVenueID').val();

            // change on start date
            $('#startDate').on('change', function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                // ajax request
                if (eventVenueID) {
                    $.ajax({
                        url: '/evbs/checkEventVenueAvailability/' + eventVenueID + '/' + startDate + '/' + endDate,
                        type: 'get',
                        success: function(data) {
                            var result = $.parseJSON(data);

                            // disable fields if booking data exist, else enable the fields
                            if (result == "") {
                                if (startDate > endDate) {
                                    $('#startTime').prop('disabled', true);
                                    $('#endTime').prop('disabled', true);
                                    $('#numberOfGuests').prop('disabled', true);
                                } else {
                                    $('#startTime').prop('disabled', false);
                                    $('#endTime').prop('disabled', false);
                                    $('#numberOfGuests').prop('disabled', false);
                                    $('#eventVenueAvailability').html('<label for="eventVenueAvailability" class="p-2 text-sm font-medium text-teal-800" id="eventVenueAvailability">Event venue is available.</label>');
                                }
                            } else {
                                $('#startTime').prop('disabled', true);
                                $('#endTime').prop('disabled', true);
                                $('#numberOfGuests').prop('disabled', true);
                                $('#eventVenueAvailability').html('<label for="eventVenueAvailability" class="p-2 text-sm font-medium text-red-800" id="eventVenueAvailability">Event venue is not available.</label>');
                            }
                        }
                    });
                } else {
                    $('#startTime').prop('disabled', true);
                    $('#endTime').prop('disabled', true);
                    $('#numberOfGuests').prop('disabled', true);
                    $('#eventVenueAvailability').html('<label for="eventVenueAvailability" class="p-2 text-sm font-medium text-red-800" id="eventVenueAvailability">Event venue is not available.</label>');
                }
            });

            // change on end date
            $('#endDate').on('change', function() {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                // ajax request
                if (eventVenueID) {
                    $.ajax({
                        url: '/evbs/checkEventVenueAvailability/' + eventVenueID + '/' + startDate + '/' + endDate,
                        type: 'get',
                        success: function(data) {
                            var result = $.parseJSON(data);

                            // disable fields if booking data exist, else enable the fields
                            if (result == "") {
                                if (startDate > endDate) {
                                    $('#startTime').prop('disabled', true);
                                    $('#endTime').prop('disabled', true);
                                    $('#numberOfGuests').prop('disabled', true);
                                } else {
                                    $('#startTime').prop('disabled', false);
                                    $('#endTime').prop('disabled', false);
                                    $('#numberOfGuests').prop('disabled', false);
                                    $('#eventVenueAvailability').html('<label for="eventVenueAvailability" class="p-2 text-sm font-medium text-teal-800" id="eventVenueAvailability">Event venue is available.</label>');
                                }
                            } else {
                                $('#startTime').prop('disabled', true);
                                $('#endTime').prop('disabled', true);
                                $('#numberOfGuests').prop('disabled', true);
                                $('#eventVenueAvailability').html('<label for="eventVenueAvailability" class="p-2 text-sm font-medium text-red-800" id="eventVenueAvailability">Event venue is not available.</label>');
                            }
                        }
                    });
                } else {
                    $('#startTime').prop('disabled', true);
                    $('#endTime').prop('disabled', true);
                    $('#numberOfGuests').prop('disabled', true);
                    $('#eventVenueAvailability').html('<label for="eventVenueAvailability" class="p-2 text-sm font-medium text-red-800" id="eventVenueAvailability">Event venue is not available.</label>');
                }
            });
        });
    </script>
@endsection
