@extends('layouts.management-system')

@section('content')
    <p class="text-gray-400"><a href="/evbs/event-venues" class="hover:underline hover:text-teal-500 transition">Event Venues</a> / <span class="text-teal-500">{{ $eventVenue->event_venue_name }}</span></p>

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
        <div class="grid grid-cols-1 mt-4">
            <div class="grid justify-items-center content-center">
                <label for="eventVenueName" class="p-2 text-2xl font-bold text-gray-800">{{ $eventVenue->event_venue_name }}</label>
            </div>

            <div class="grid justify-items-center content-center mt-1 mb-6">
                @if ($eventVenue->status == 0)
                    <span class="p-1.5 text-sm font-medium text-white bg-red-500 rounded-lg">Inactive</span>
                @elseif ($eventVenue->status == 1)
                    <span class="p-1.5 text-sm font-medium text-white bg-teal-500 rounded-lg">Active</span>
                @endif
            </div>
        </div>
        
        <hr>

        {{-- event venue information --}}
        <div class="grid grid-cols-1 mt-6">
            <label for="eventVenueInformation" class="p-2 text-xl font-bold text-gray-800">Event Venue Information</label>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-2">
            @if (session('user_role') == "Super Admin")
                <div class="grid grid-cols-2 gap-2">
                    <label for="eventVenueOwner" class="p-2 font-bold text-gray-800">Event Venue Owner</label>
                    <label for="eventVenueOwner" class="p-2 font-medium text-justify text-gray-800">
                        <a href="/evbs/event-venue-owners/{{ $eventVenue->event_venue_owner_id }}" class="hover:underline hover:text-teal-500 transition" target="_blank">{{ $eventVenue->first_name }} {{ $eventVenue->last_name }}</a>
                    </label>
                </div>
            @endif
            
            <div class="grid grid-cols-2 gap-2">
                <label for="eventType" class="p-2 font-bold text-gray-800">Event Type</label>
                <label for="eventType" class="p-2 font-medium text-justify text-gray-800">{{ $eventVenue->event_type_name }}</label>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-2">
            <div class="grid grid-cols-2 gap-2">
                <label for="eventVenueEmail" class="p-2 font-bold text-gray-800">Event Venue Email</label>
                <label for="eventVenueEmail" class="p-2 font-medium text-justify text-gray-800">
                    <a href="mailto:{{ $eventVenue->event_venue_email }}" class="hover:underline hover:text-teal-500 transition">{{ $eventVenue->event_venue_email }}</a>
                </label>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <label for="eventVenuePhoneNumber" class="p-2 font-bold text-gray-800">Event Venue Phone Number</label>
                <label for="eventVenuePhoneNumber" class="p-2 font-medium text-justify text-gray-800">
                    <a href="tel:{{ $eventVenue->event_venue_phone_number }}" class="hover:underline hover:text-teal-500 transition">{{ $eventVenue->event_venue_phone_number }}</a>
                </label>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="grid grid-cols-2 gap-2">
                <label for="eventVenueAddress" class="p-2 font-bold text-gray-800">Event Venue Address</label>
                <label for="eventVenueAddress" class="p-2 font-medium text-gray-800">{{ $eventVenue->address }}, {{ $eventVenue->postal_code }} {{ $eventVenue->city }}, {{ $eventVenue->state }}, {{ $eventVenue->country }}.</label>
            </div>
        </div>

        <hr>

        {{-- event venue description --}}
        <div class="grid grid-cols-1 mt-6">
            <label for="eventVenueDescription" class="p-2 text-xl font-bold text-gray-800">Event Venue Description</label>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="grid">
                <pre for="eventVenueDescription" class="p-2 font-medium font-sans text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->event_venue_description }}</pre>
            </div>
        </div>

        <hr>

        {{-- space & size --}}
        <div class="grid grid-cols-1 mt-6">
            <label for="spaceAndSize" class="p-2 text-xl font-bold text-gray-800">Space & Size</label>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="grid grid-cols-2 gap-2">
                <label for="sizeMeasurement" class="p-2 font-bold text-gray-800">Size Measurement</label>
                <label for="sizeMeasurement" class="p-2 font-medium text-justify text-gray-800">{{ number_format($eventVenue->size_measurement, 0) }} {{ $eventVenue->size_measurement_unit }}</label>
            </div>

            <div class="grid grid-cols-2 gap-2">
                <label for="maximumGuests" class="p-2 font-bold text-gray-800">Maximum Guests</label>
                <label for="maximumGuests" class="p-2 font-medium text-justify text-gray-800">{{ number_format($eventVenue->maximum_guests, 0) }} guests</label>
            </div>
        </div>

        <hr>

        {{-- availability --}}
        <div class="grid grid-cols-1 mt-6">
            <label for="availability" class="p-2 text-xl font-bold text-gray-800">Availability</label>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="grid">
                <pre for="availability" class="p-2 font-medium font-sans text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->availability }}</pre>
            </div>
        </div>

        <hr>
        
        {{-- packages & pricing --}}
        <div class="grid grid-cols-1 mt-6">
            <label for="packagesAndPricing" class="p-2 text-xl font-bold text-gray-800">Packages & Pricing</label>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="grid">
                <pre for="packagesAndPricing" class="p-2 font-medium font-sans text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->packages_pricing }}</pre>
            </div>
        </div>

        <hr>
        
        {{-- amenities, accessibility & add-on services --}}
        <div class="grid grid-cols-2 gap-4 mt-6 mb-2">
            <div>
                <div class="grid grid-cols-1">
                    <label for="amenities" class="p-2 text-xl font-bold text-gray-800">Amenities</label>
                </div>
    
                <div class="grid grid-cols-1 gap-4">
                    <div class="grid">
                        <pre for="amenities" class="p-2 font-medium font-sans text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->amenities }}</pre>
                    </div>
                </div>
            </div>

            <div>
                <div class="grid grid-cols-1">
                    <label for="accessibility" class="p-2 text-xl font-bold text-gray-800">Accessibility</label>
                </div>
    
                <div class="grid grid-cols-1 gap-4">
                    <div class="grid">
                        <pre for="accessibility" class="p-2 font-medium font-sans text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->accessibility }}</pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 mt-6">
            <label for="addOnServices" class="p-2 text-xl font-bold text-gray-800">Add On Services</label>
        </div>

        <div class="grid grid-cols-1 gap-4 mb-6">
            <div class="grid">
                <pre for="addOnServices" class="p-2 font-medium font-sans text-gray-800" style="white-space: pre-wrap;">{{ $eventVenue->add_on_services }}</pre>
            </div>
        </div>

        <hr>

        {{-- event venue images --}}
        <div class="grid grid-cols-2 mt-6 mb-4">
            <div class="grid justify-items-start">
                 <label for="eventVenueImages" class="p-2 text-xl font-bold text-gray-800">Event Venue Images</label>
            </div>
            
            @if ($eventVenue->event_venue_images != "")
                <div class="grid justify-items-end">
                    <form action="/evbs/event-venues/{{ $eventVenue->id }}/delete-all-event-venue-images" method="POST">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="allEventVenueImages" value="{{ $eventVenue->event_venue_images }}">
                        <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="delete-all-images-confirmation">Delete All Images</button>
                    </form>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-4 gap-10 mb-10">
            @php
                $eventVenueImages = explode(',', $eventVenue->event_venue_images);
                $eventVenueImageNo = 1;
            @endphp
            
            @foreach ($eventVenueImages as $eventVenueImage)
                @if ($eventVenueImage != "")
                    <div class="group relative">
                        <img class="w-full border rounded-xl cursor-pointer" src="{{ env('CLOUD_FRONT_URL') .'/uploads/event-venues/' .$eventVenueImage }}" alt="" style="height: 200px;">

                        <div class="absolute top-0 left-0 w-full h-0 flex flex-col justify-center items-center rounded-xl backdrop-blur-sm bg-black/70 opacity-0 group-hover:h-full group-hover:opacity-100 duration-500">
                            <div class="grid grid-cols-2 gap-4">
                                <a href="{{ asset('/uploads/event-venues/' . $eventVenueImage) }}" class="p-2 w-20 items-left text-center text-sm text-white rounded-lg bg-teal-500 hover:bg-teal-700 transition" target="_blank">View</a>

                                <form action="/evbs/event-venues/{{ $eventVenue->id }}/delete-single-event-venue-image" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <input type="hidden" name="singleEventVenueImage" value="{{ $eventVenueImage }}">
                                    <input type="hidden" name="eventVenueImages" value="{{ $eventVenue->event_venue_images }}">
                                    <button type="submit" class="p-2 w-20 items-right text-center text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="delete-event-venue-image-confirmation-{{ $eventVenueImageNo }}">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- delete event venue image confirmation --}}
                    <script>
                        document.getElementById('delete-event-venue-image-confirmation-{{ $eventVenueImageNo }}').addEventListener('click', function () {
                            var form = $(this).closest("form");
                            event.preventDefault();

                            Swal.fire({
                                titleText: 'Delete',
                                text: "Are you sure you want to delete this image?",
                                icon: 'warning',
                                showConfirmButton: true,
                                showCancelButton: true,
                                color: '#1f2937',
                                confirmButtonColor: '#ef4444',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: 'Yes',
                                cancelButtonText: 'No'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            })
                        })
                    </script>

                    @php $eventVenueImageNo++; @endphp
                @else
                    <img class="w-full border rounded-xl cursor-pointer" src="{{env('CLOUD_FRONT_URL')}}/assets/image-placeholder.jpg" alt="" style="height: 200px;">
                @endif
            @endforeach
        </div>

        <hr>

        <div class="grid grid-cols-1 justify-center gap-8 mt-20 mb-6" style="display: flex;">
            <a href="/evbs/event-venues/{{ $eventVenue->id }}/edit"><button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Edit</button></a>

            @if ($eventVenue->status == 0)
                <form action="/evbs/event-venues/{{ $eventVenue->id }}/activate" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-green-500 hover:bg-green-700 transition" id="activate-confirmation">Activate</button>
                </form>
            @elseif ($eventVenue->status == 1)
                <form action="/evbs/event-venues/{{ $eventVenue->id }}/deactivate" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="deactivate-confirmation">Deactivate</button>
                </form>
            @endif

            <form action="/evbs/event-venues/{{ $eventVenue->id }}/delete" method="POST">
                @csrf
                @method('DELETE')

                <input type="hidden" name="eventVenueImages" value="{{ $eventVenue->event_venue_images }}">
                <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="delete-confirmation">Delete</button>
            </form>
        </div>
    </div>
@endsection
