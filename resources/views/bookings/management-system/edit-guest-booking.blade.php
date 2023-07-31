@extends('layouts.management-system')

@section('content')
    <p class="text-gray-400"><a href="/evbs/bookings/guest-bookings" class="hover:underline hover:text-teal-500 transition">Guest Bookings</a> / <a href="/evbs/bookings/guest-booking/{{ $guestBooking->id }}" class="hover:underline hover:text-teal-500 transition">{{ $guestBooking->id }}</a> / <span class="text-teal-500">Edit Guest Booking</span></p>

    <div class="p-4 bg-white rounded-lg mt-6">
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Edit Guest Booking</h1>
        </div>

        <form action="/evbs/bookings/{{ $guestBooking->id }}/update-guest-booking" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4 mt-4 mb-2">
                <div class="grid grid-cols-2 gap-2">
                    <label for="guest" class="p-2 text-sm font-medium text-gray-800">Guest</label>
                    <label for="guest" class="p-2 text-sm font-bold text-gray-800">{{ $guestBooking->first_name }} {{ $guestBooking->last_name }}</label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-2">
                <div class="grid grid-cols-2 gap-2">
                    <label for="eventVenue" class="p-2 text-sm font-medium text-gray-800">Event Venue</label>
                    <label for="eventVenue" class="p-2 text-sm font-bold text-gray-800">{{ $guestBooking->event_venue_name }}</label>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="startDate" class="p-2 text-sm font-medium text-gray-800">Start Date</label>
                    <label for="startDate" class="p-2 text-sm font-bold text-gray-800">{{ $guestBooking->start_date }}</label>
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="endDate" class="p-2 text-sm font-medium text-gray-800">End Date</label>
                    <label for="endDate" class="p-2 text-sm font-bold text-gray-800">{{ $guestBooking->end_date }}</label>
                </div>
            </div>

            <hr>

            <div class="grid gap-4 mt-6 mb-6">
                <label for="optionalFields" class="p-2 text-sm font-medium italic text-gray-800">Optional: Fill up this when change of event venue, start date, and end date are required.</label>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="eventVenue" class="p-2 text-sm font-medium text-gray-800">New Event Venue</label>
                    <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="eventVenue" name="eventVenue">
                        <option value="">-- Select Event Venue --</option>
                        
                        @foreach ($eventVenues as $eventVenue)
                            <option value="{{ $eventVenue->id }}">{{ $eventVenue->event_venue_name }}</option>
                        @endforeach
                    </select>
                    @error('eventVenue')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-1" id="eventVenueAvailability"></div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="startDate" class="p-2 text-sm font-medium text-gray-800">New Start Date</label>
                    <input type="date" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="startDate" name="startDate">
                    @error('startDate')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="endDate" class="p-2 text-sm font-medium text-gray-800">New End Date</label>
                    <input type="date" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="endDate" name="endDate">
                    @error('endDate')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <hr>

            <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="startTime" class="p-2 text-sm font-medium text-gray-800">Start Time <span class="text-red-500">*</span></label>
                    <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="startTime" name="startTime">
                        <option value="">-- Select Start Time --</option>
                        <option value="12:00 AM" {{ $guestBooking->start_time == "12:00 AM" ? 'selected' : '' }}>12:00 AM</option>
                        <option value="12:30 AM" {{ $guestBooking->start_time == "12:30 AM" ? 'selected' : '' }}>12:30 AM</option>
                        <option value="01:00 AM" {{ $guestBooking->start_time == "01:00 AM" ? 'selected' : '' }}>01:00 AM</option>
                        <option value="01:30 AM" {{ $guestBooking->start_time == "01:30 AM" ? 'selected' : '' }}>01:30 AM</option>
                        <option value="02:00 AM" {{ $guestBooking->start_time == "02:00 AM" ? 'selected' : '' }}>02:00 AM</option>
                        <option value="02:30 AM" {{ $guestBooking->start_time == "02:30 AM" ? 'selected' : '' }}>02:30 AM</option>
                        <option value="03:00 AM" {{ $guestBooking->start_time == "03:00 AM" ? 'selected' : '' }}>03:00 AM</option>
                        <option value="03:30 AM" {{ $guestBooking->start_time == "03:30 AM" ? 'selected' : '' }}>03:30 AM</option>
                        <option value="04:00 AM" {{ $guestBooking->start_time == "04:00 AM" ? 'selected' : '' }}>04:00 AM</option>
                        <option value="04:30 AM" {{ $guestBooking->start_time == "04:30 AM" ? 'selected' : '' }}>04:30 AM</option>
                        <option value="05:00 AM" {{ $guestBooking->start_time == "05:00 AM" ? 'selected' : '' }}>05:00 AM</option>
                        <option value="05:30 AM" {{ $guestBooking->start_time == "05:30 AM" ? 'selected' : '' }}>05:30 AM</option>
                        <option value="06:00 AM" {{ $guestBooking->start_time == "06:00 AM" ? 'selected' : '' }}>06:00 AM</option>
                        <option value="06:30 AM" {{ $guestBooking->start_time == "06:30 AM" ? 'selected' : '' }}>06:30 AM</option>
                        <option value="07:00 AM" {{ $guestBooking->start_time == "07:00 AM" ? 'selected' : '' }}>07:00 AM</option>
                        <option value="07:30 AM" {{ $guestBooking->start_time == "07:30 AM" ? 'selected' : '' }}>07:30 AM</option>
                        <option value="08:00 AM" {{ $guestBooking->start_time == "08:00 AM" ? 'selected' : '' }}>08:00 AM</option>
                        <option value="08:30 AM" {{ $guestBooking->start_time == "08:30 AM" ? 'selected' : '' }}>08:30 AM</option>
                        <option value="09:00 AM" {{ $guestBooking->start_time == "09:00 AM" ? 'selected' : '' }}>09:00 AM</option>
                        <option value="09:30 AM" {{ $guestBooking->start_time == "09:30 AM" ? 'selected' : '' }}>09:30 AM</option>
                        <option value="10:00 AM" {{ $guestBooking->start_time == "10:00 AM" ? 'selected' : '' }}>10:00 AM</option>
                        <option value="10:30 AM" {{ $guestBooking->start_time == "10:30 AM" ? 'selected' : '' }}>10:30 AM</option>
                        <option value="11:00 AM" {{ $guestBooking->start_time == "11:00 AM" ? 'selected' : '' }}>11:00 AM</option>
                        <option value="11:30 AM" {{ $guestBooking->start_time == "11:30 AM" ? 'selected' : '' }}>11:30 AM</option>
                        <option value="12:00 PM" {{ $guestBooking->start_time == "12:00 PM" ? 'selected' : '' }}>12:00 PM</option>
                        <option value="12:30 PM" {{ $guestBooking->start_time == "12:30 PM" ? 'selected' : '' }}>12:30 PM</option>
                        <option value="01:00 PM" {{ $guestBooking->start_time == "01:00 PM" ? 'selected' : '' }}>01:00 PM</option>
                        <option value="01:30 PM" {{ $guestBooking->start_time == "01:30 PM" ? 'selected' : '' }}>01:30 PM</option>
                        <option value="02:00 PM" {{ $guestBooking->start_time == "02:00 PM" ? 'selected' : '' }}>02:00 PM</option>
                        <option value="02:30 PM" {{ $guestBooking->start_time == "02:30 PM" ? 'selected' : '' }}>02:30 PM</option>
                        <option value="03:00 PM" {{ $guestBooking->start_time == "03:00 PM" ? 'selected' : '' }}>03:00 PM</option>
                        <option value="03:30 PM" {{ $guestBooking->start_time == "03:30 PM" ? 'selected' : '' }}>03:30 PM</option>
                        <option value="04:00 PM" {{ $guestBooking->start_time == "04:00 PM" ? 'selected' : '' }}>04:00 PM</option>
                        <option value="04:30 PM" {{ $guestBooking->start_time == "04:30 PM" ? 'selected' : '' }}>04:30 PM</option>
                        <option value="05:00 PM" {{ $guestBooking->start_time == "05:00 PM" ? 'selected' : '' }}>05:00 PM</option>
                        <option value="05:30 PM" {{ $guestBooking->start_time == "05:30 PM" ? 'selected' : '' }}>05:30 PM</option>
                        <option value="06:00 PM" {{ $guestBooking->start_time == "06:00 PM" ? 'selected' : '' }}>06:00 PM</option>
                        <option value="06:30 PM" {{ $guestBooking->start_time == "06:30 PM" ? 'selected' : '' }}>06:30 PM</option>
                        <option value="07:00 PM" {{ $guestBooking->start_time == "07:00 PM" ? 'selected' : '' }}>07:00 PM</option>
                        <option value="07:30 PM" {{ $guestBooking->start_time == "07:30 PM" ? 'selected' : '' }}>07:30 PM</option>
                        <option value="08:00 PM" {{ $guestBooking->start_time == "08:00 PM" ? 'selected' : '' }}>08:00 PM</option>
                        <option value="08:30 PM" {{ $guestBooking->start_time == "08:30 PM" ? 'selected' : '' }}>08:30 PM</option>
                        <option value="09:00 PM" {{ $guestBooking->start_time == "09:00 PM" ? 'selected' : '' }}>09:00 PM</option>
                        <option value="09:30 PM" {{ $guestBooking->start_time == "09:30 PM" ? 'selected' : '' }}>09:30 PM</option>
                        <option value="10:00 PM" {{ $guestBooking->start_time == "10:00 PM" ? 'selected' : '' }}>10:00 PM</option>
                        <option value="10:30 PM" {{ $guestBooking->start_time == "10:30 PM" ? 'selected' : '' }}>10:30 PM</option>
                        <option value="11:00 PM" {{ $guestBooking->start_time == "11:00 PM" ? 'selected' : '' }}>11:00 PM</option>
                        <option value="11:30 PM" {{ $guestBooking->start_time == "11:30 PM" ? 'selected' : '' }}>11:30 PM</option>
                    </select>
                    @error('startTime')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="endTime" class="p-2 text-sm font-medium text-gray-800">End Time <span class="text-red-500">*</span></label>
                    <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="endTime" name="endTime">
                        <option value="">-- Select End Time --</option>
                        <option value="12:00 AM" {{ $guestBooking->end_time == "12:00 AM" ? 'selected' : '' }}>12:00 AM</option>
                        <option value="12:30 AM" {{ $guestBooking->end_time == "12:30 AM" ? 'selected' : '' }}>12:30 AM</option>
                        <option value="01:00 AM" {{ $guestBooking->end_time == "01:00 AM" ? 'selected' : '' }}>01:00 AM</option>
                        <option value="01:30 AM" {{ $guestBooking->end_time == "01:30 AM" ? 'selected' : '' }}>01:30 AM</option>
                        <option value="02:00 AM" {{ $guestBooking->end_time == "02:00 AM" ? 'selected' : '' }}>02:00 AM</option>
                        <option value="02:30 AM" {{ $guestBooking->end_time == "02:30 AM" ? 'selected' : '' }}>02:30 AM</option>
                        <option value="03:00 AM" {{ $guestBooking->end_time == "03:00 AM" ? 'selected' : '' }}>03:00 AM</option>
                        <option value="03:30 AM" {{ $guestBooking->end_time == "03:30 AM" ? 'selected' : '' }}>03:30 AM</option>
                        <option value="04:00 AM" {{ $guestBooking->end_time == "04:00 AM" ? 'selected' : '' }}>04:00 AM</option>
                        <option value="04:30 AM" {{ $guestBooking->end_time == "04:30 AM" ? 'selected' : '' }}>04:30 AM</option>
                        <option value="05:00 AM" {{ $guestBooking->end_time == "05:00 AM" ? 'selected' : '' }}>05:00 AM</option>
                        <option value="05:30 AM" {{ $guestBooking->end_time == "05:30 AM" ? 'selected' : '' }}>05:30 AM</option>
                        <option value="06:00 AM" {{ $guestBooking->end_time == "06:00 AM" ? 'selected' : '' }}>06:00 AM</option>
                        <option value="06:30 AM" {{ $guestBooking->end_time == "06:30 AM" ? 'selected' : '' }}>06:30 AM</option>
                        <option value="07:00 AM" {{ $guestBooking->end_time == "07:00 AM" ? 'selected' : '' }}>07:00 AM</option>
                        <option value="07:30 AM" {{ $guestBooking->end_time == "07:30 AM" ? 'selected' : '' }}>07:30 AM</option>
                        <option value="08:00 AM" {{ $guestBooking->end_time == "08:00 AM" ? 'selected' : '' }}>08:00 AM</option>
                        <option value="08:30 AM" {{ $guestBooking->end_time == "08:30 AM" ? 'selected' : '' }}>08:30 AM</option>
                        <option value="09:00 AM" {{ $guestBooking->end_time == "09:00 AM" ? 'selected' : '' }}>09:00 AM</option>
                        <option value="09:30 AM" {{ $guestBooking->end_time == "09:30 AM" ? 'selected' : '' }}>09:30 AM</option>
                        <option value="10:00 AM" {{ $guestBooking->end_time == "10:00 AM" ? 'selected' : '' }}>10:00 AM</option>
                        <option value="10:30 AM" {{ $guestBooking->end_time == "10:30 AM" ? 'selected' : '' }}>10:30 AM</option>
                        <option value="11:00 AM" {{ $guestBooking->end_time == "11:00 AM" ? 'selected' : '' }}>11:00 AM</option>
                        <option value="11:30 AM" {{ $guestBooking->end_time == "11:30 AM" ? 'selected' : '' }}>11:30 AM</option>
                        <option value="12:00 PM" {{ $guestBooking->end_time == "12:00 PM" ? 'selected' : '' }}>12:00 PM</option>
                        <option value="12:30 PM" {{ $guestBooking->end_time == "12:30 PM" ? 'selected' : '' }}>12:30 PM</option>
                        <option value="01:00 PM" {{ $guestBooking->end_time == "01:00 PM" ? 'selected' : '' }}>01:00 PM</option>
                        <option value="01:30 PM" {{ $guestBooking->end_time == "01:30 PM" ? 'selected' : '' }}>01:30 PM</option>
                        <option value="02:00 PM" {{ $guestBooking->end_time == "02:00 PM" ? 'selected' : '' }}>02:00 PM</option>
                        <option value="02:30 PM" {{ $guestBooking->end_time == "02:30 PM" ? 'selected' : '' }}>02:30 PM</option>
                        <option value="03:00 PM" {{ $guestBooking->end_time == "03:00 PM" ? 'selected' : '' }}>03:00 PM</option>
                        <option value="03:30 PM" {{ $guestBooking->end_time == "03:30 PM" ? 'selected' : '' }}>03:30 PM</option>
                        <option value="04:00 PM" {{ $guestBooking->end_time == "04:00 PM" ? 'selected' : '' }}>04:00 PM</option>
                        <option value="04:30 PM" {{ $guestBooking->end_time == "04:30 PM" ? 'selected' : '' }}>04:30 PM</option>
                        <option value="05:00 PM" {{ $guestBooking->end_time == "05:00 PM" ? 'selected' : '' }}>05:00 PM</option>
                        <option value="05:30 PM" {{ $guestBooking->end_time == "05:30 PM" ? 'selected' : '' }}>05:30 PM</option>
                        <option value="06:00 PM" {{ $guestBooking->end_time == "06:00 PM" ? 'selected' : '' }}>06:00 PM</option>
                        <option value="06:30 PM" {{ $guestBooking->end_time == "06:30 PM" ? 'selected' : '' }}>06:30 PM</option>
                        <option value="07:00 PM" {{ $guestBooking->end_time == "07:00 PM" ? 'selected' : '' }}>07:00 PM</option>
                        <option value="07:30 PM" {{ $guestBooking->end_time == "07:30 PM" ? 'selected' : '' }}>07:30 PM</option>
                        <option value="08:00 PM" {{ $guestBooking->end_time == "08:00 PM" ? 'selected' : '' }}>08:00 PM</option>
                        <option value="08:30 PM" {{ $guestBooking->end_time == "08:30 PM" ? 'selected' : '' }}>08:30 PM</option>
                        <option value="09:00 PM" {{ $guestBooking->end_time == "09:00 PM" ? 'selected' : '' }}>09:00 PM</option>
                        <option value="09:30 PM" {{ $guestBooking->end_time == "09:30 PM" ? 'selected' : '' }}>09:30 PM</option>
                        <option value="10:00 PM" {{ $guestBooking->end_time == "10:00 PM" ? 'selected' : '' }}>10:00 PM</option>
                        <option value="10:30 PM" {{ $guestBooking->end_time == "10:30 PM" ? 'selected' : '' }}>10:30 PM</option>
                        <option value="11:00 PM" {{ $guestBooking->end_time == "11:00 PM" ? 'selected' : '' }}>11:00 PM</option>
                        <option value="11:30 PM" {{ $guestBooking->end_time == "11:30 PM" ? 'selected' : '' }}>11:30 PM</option>
                    </select>
                    @error('endTime')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="numberOfGuests" class="p-2 text-sm font-medium text-gray-800">Number of Guests <span class="text-red-500">*</span></label>
                    <input type="number" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="numberOfGuests" name="numberOfGuests" value="{{ $guestBooking->number_of_guests }}">
                    @error('numberOfGuests')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="remarks" class="p-2 text-sm font-medium text-gray-800">Remarks</label>
                    <textarea class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="remarks" rows="3">{{ $guestBooking->remarks }}</textarea>
                    @error('remarks')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mt-20 mb-6">
                <div class="grid justify-items-end">
                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Update</button>
                </div>

                <div class="grid justify-items-start">
                    <a href="/evbs/bookings/guest-booking/{{ $guestBooking->id }}" class="p-2 w-40 text-center text-sm text-white rounded-md bg-red-500 hover:bg-red-700 transition">Cancel</a>
                </div>
            </div>
        </form>
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
        var eventVenueID;

        // get event venue id
        $('#eventVenue').on('change', function() {
            eventVenueID = $(this).val();
        });

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
    </script>
@endsection
