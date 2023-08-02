@extends('layouts.booking-system')

@section('content')
    <div class="flex min-h-screen bg-gray-100 px-6 py-6">
        <div class="container mx-auto mt-8 mb-8">
            <div class="flex flex-wrap">                
                <form action="/event-venue" method="GET">
                    <div class="flex">
                        <input type="text" class="block p-2.5 w-64 text-sm text-gray-800 border border-gray-300 rounded-md" name="search" placeholder="Search event venue">
                        
                        <button type="submit" class="p-2 w-12 text-xl text-white rounded-md bg-brown-500 hover:bg-brown-700 transition ml-4"><i class="bx bx-search"></i></button>
                    </div>
                </form>
            </div>

            <div class="flex flex-wrap mt-10 mb-6">
                @foreach ($eventTypes as $eventType)
                    <div class="px-2 py-2">
                        <form action="/event-type" method="GET">
                            <input type="hidden" name="eventType" value="{{ $eventType->id }}">

                            <button type="submit" class="p-2 w-full text-gray-800 border border-gray-400 rounded-md bg-white hover:bg-brown-100 transition">{{ $eventType->event_type_name }}</button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="flex flex-wrap">
                @if (!$eventVenues->isEmpty())
                    @forelse ($eventVenues as $eventVenue)
                        <div class="w-full sm:w-1/2 md:w-1/2 xl:w-1/4 p-4">
                            <a href="/make-booking/{{ $eventVenue->id }}" class="block bg-white shadow-md hover:shadow-2xl transition rounded-xl overflow-hidden">
                                @php
                                    $eventVenueImage = explode(',', $eventVenue->event_venue_images)[0];
                                @endphp

                                <div class="relative pb- overflow-hidden">
                                    @if ($eventVenueImage != "")
                                        {{-- todo --}}
                                        <img class="object-fill h-56 w-full rounded-t-xl" src="{{ asset('/uploads/event-venues/' . $eventVenueImage) }}" alt="">
                                    @else
                                        {{-- todo --}}
                                        <img class="object-fill h-56 w-full rounded-t-xl" src="{{ asset('/assets/image-placeholder.jpg') }}" alt="">
                                    @endif
                                </div>

                                <div class="p-4">
                                    <span class="inline-block px-2 py-1 leading-none bg-brown-700 text-white rounded-full font-semibold uppercase tracking-wider text-xs">
                                        {{ number_format($eventVenue->maximum_guests) }} guests
                                    </span>

                                    <span class="inline-block px-2 py-1 leading-none bg-gray-700 text-white rounded-full font-semibold uppercase tracking-wider text-xs ml-1">
                                        {{ $eventVenue->event_type_name }}
                                    </span>

                                    <div class="lg:h-12 sm:h-12">
                                        <h2 class="font-bold text-lg text-gray-800 mt-2">{{ $eventVenue->event_venue_name }}</h2>
                                    </div>

                                    <p class="text-sm text-gray-600 mt-2">{{ $eventVenue->city }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        
                    @endforelse
                @elseif ($eventVenues->isEmpty())
                        <p class="font-bold text-lg text-gray-800 mt-12">No event venues available.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
