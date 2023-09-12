@extends('layouts.management-system')

@section('content')
    <p class="text-gray-400"><a href="/evbs/event-venues" class="hover:underline hover:text-teal-500 transition">Event Venues</a> / <a href="/evbs/event-venues/{{ $eventVenue->id }}" class="hover:underline hover:text-teal-500 transition">{{ $eventVenue->event_venue_name }}</a> / <span class="text-teal-500">Edit Event Venue</span></p>

    <div class="p-4 bg-white rounded-lg mt-6">
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Edit Event Venue</h1>
        </div>

        <form action="/evbs/event-venues/{{ $eventVenue->id }}/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4 mt-4 mb-6">
                @if (session('user_role') == "Super Admin")
                    <div class="grid grid-cols-2 gap-2">
                        <label for="eventVenueOwner" class="p-2 text-sm font-medium text-gray-800">Event Venue Owner <span class="text-red-500">*</span></label>
                        <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" id="select-event-venue-owner" name="eventVenueOwner">
                            <option value="">-- Select Event Venue Owner --</option>
                            
                            @foreach ($eventVenueOwners as $eventVenueOwner)
                                <option value="{{ $eventVenueOwner->id }}" {{ $eventVenue->event_venue_owner_id == $eventVenueOwner->id ? 'selected' : '' }}>{{ $eventVenueOwner->first_name }} {{ $eventVenueOwner->last_name }} ({{ $eventVenueOwner->email }})</option>
                            @endforeach
                        </select>
                        @error('eventVenueOwner')
                            <div></div>
                            <div>
                                <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-2">
                    <label for="eventType" class="p-2 text-sm font-medium text-gray-800">Event Type <span class="text-red-500">*</span></label>
                    <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="eventType">
                        <option value="">-- Select Event Type --</option>
                        
                        @foreach ($eventTypes as $eventType)
                            <option value="{{ $eventType->id }}" {{ $eventVenue->event_type_id == $eventType->id ? 'selected' : '' }}>{{ $eventType->event_type_name }}</option>
                        @endforeach
                    </select>
                    @error('eventType')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="eventVenueName" class="p-2 text-sm font-medium text-gray-800">Event Venue Name <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="eventVenueName" value="{{ $eventVenue->event_venue_name }}">
                    @error('eventVenueName')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="eventVenueEmail" class="p-2 text-sm font-medium text-gray-800">Event Venue Email <span class="text-red-500">*</span></label>
                    <input type="email" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="eventVenueEmail" value="{{ $eventVenue->event_venue_email }}">
                    @error('eventVenueEmail')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="eventVenuePhoneNumber" class="p-2 text-sm font-medium text-gray-800">Event Venue Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="eventVenuePhoneNumber" value="{{ $eventVenue->event_venue_phone_number }}">
                    @error('eventVenuePhoneNumber')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-12 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="address" class="p-2 text-sm font-medium text-gray-800">Address <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="address" value="{{ $eventVenue->address }}">
                    @error('address')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="postalCode" class="p-2 text-sm font-medium text-gray-800">Postal Code <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="postalCode" value="{{ $eventVenue->postal_code }}">
                    @error('postalCode')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="city" class="p-2 text-sm font-medium text-gray-800">City <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="city" value="{{ $eventVenue->city }}">
                    @error('city')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="state" class="p-2 text-sm font-medium text-gray-800">State <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="state" value="{{ $eventVenue->state }}">
                    @error('state')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="country" class="p-2 text-sm font-medium text-gray-800">Country <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="country" value="{{ $eventVenue->country }}">
                    @error('country')
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
                    <label for="eventVenueDescription" class="p-2 text-sm font-medium text-gray-800">Event Venue Description <span class="text-red-500">*</span></label>
                    <textarea class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="eventVenueDescription" rows="5">{{ $eventVenue->event_venue_description }}</textarea>
                    @error('eventVenueDescription')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="sizeMeasurement" class="p-2 text-sm font-medium text-gray-800">Size Measurement <span class="text-red-500">*</span></label>
                    <input type="number" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="sizeMeasurement" value="{{ $eventVenue->size_measurement }}">
                    @error('sizeMeasurement')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="sizeMeasurementUnit" class="p-2 text-sm font-medium text-gray-800">Size Measurement Unit <span class="text-red-500">*</span></label>
                    <select class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="sizeMeasurementUnit">
                        <option value="">-- Select Size Measurement Unit --</option>
                        <option value="sqft" {{ $eventVenue->size_measurement_unit == "sqft" ? 'selected' : '' }}>Square Feet (sqft)</option>
                        <option value="sqm" {{ $eventVenue->size_measurement_unit == "sqm" ? 'selected' : '' }}>Square Meter (sqm)</option>
                    </select>
                    @error('sizeMeasurementUnit')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="maximumGuests" class="p-2 text-sm font-medium text-gray-800">Maximum Guests <span class="text-red-500">*</span></label>
                    <input type="number" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="maximumGuests" value="{{ $eventVenue->maximum_guests }}">
                    @error('maximumGuests')
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
                    <label for="availability" class="p-2 text-sm font-medium text-gray-800">Availability <span class="text-red-500">*</span></label>
                    <textarea class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="availability" rows="3">{{ $eventVenue->availability }}</textarea>
                    @error('availability')
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
                    <label for="packagesPricing" class="p-2 text-sm font-medium text-gray-800">Packages & Pricing <span class="text-red-500">*</span></label>
                    <textarea class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="packagesPricing" rows="6">{{ $eventVenue->packages_pricing }}</textarea>
                    @error('packagesPricing')
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
                    <label for="amenities" class="p-2 text-sm font-medium text-gray-800">Amenities <span class="text-red-500">*</span></label>
                    <textarea class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="amenities" rows="6">{{ $eventVenue->amenities }}</textarea>
                    @error('amenities')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="accessibility" class="p-2 text-sm font-medium text-gray-800">Accessibility <span class="text-red-500">*</span></label>
                    <textarea class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="accessibility" rows="6">{{ $eventVenue->accessibility }}</textarea>
                    @error('accessibility')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="addOnServices" class="p-2 text-sm font-medium text-gray-800">Add-On Services <span class="text-red-500">*</span></label>
                    <textarea class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="addOnServices" rows="6">{{ $eventVenue->add_on_services }}</textarea>
                    @error('addOnServices')
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
                    <label for="eventVenueImages" class="p-2 text-sm font-medium text-gray-800">Event Venue Images</label>
                    <input type="file" class="p-1.5 text-sm text-gray-800 border border-gray-300 rounded-md cursor-pointer" name="eventVenueImages[]" accept="image/jpeg, image/png, image/tiff" multiple>
                    <div></div>
                    <div>
                        <p class="text-sm font-medium text-red-500 text-right">JPG, PNG & TIFF (Multiple Images)</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mt-20 mb-6">
                <div class="grid justify-items-end">
                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Update</button>
                </div>

                <div class="grid justify-items-start">
                    <a href="/evbs/event-venues/{{ $eventVenue->id }}" class="p-2 w-40 text-center text-sm text-white rounded-md bg-red-500 hover:bg-red-700 transition">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    {{-- select option with search box --}}
    <script>
        $(document).ready(function() {
            $("#select-event-venue-owner").select2();
        });
    </script>
@endsection
