@extends('layouts.booking-system')

@section('content')
    <div class="flex min-h-screen bg-gray-100 px-6 py-6">
        <div class="flex-1 h-full max-w-7xl mx-auto bg-white rounded-xl shadow-xl mt-10">
            <div class="p-4 bg-white rounded-lg mx-4 mt-6">
                <button onclick="history.back()" class="text-sm font-bold text-gray-800 bg-white border-2 border-gray-800 hover:bg-brown-100 tracking-wider rounded-md transition px-3 py-2 "><i class="bx bx-arrow-back"></i> Back</button>

                <div class="grid grid-cols-1 mt-10">
                    <div>
                        @if ($booking->status == 0)
                            <span class="p-1.5 text-sm font-medium text-white bg-red-500 rounded-lg">Cancelled</span>
                        @elseif ($booking->status == 1)
                            <span class="p-1.5 text-sm font-medium text-white bg-gray-500 rounded-lg">Pending</span>
                        @elseif ($booking->status == 2)
                            <span class="p-1.5 text-sm font-medium text-white bg-teal-500 rounded-lg">Confirmed</span>
                        @endif
                    </div>
                </div>
        
                <div class="grid grid-cols-2 gap-4 mt-4 mb-2">
                    <div class="grid grid-cols-2 gap-2">
                        <label for="eventVenue" class="p-2 font-bold text-gray-800">Event Venue</label>
                        <label for="eventVenue" class="p-2 font-medium text-gray-800">{{ $booking->event_venue_name }}</label>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <label for="address" class="p-2 font-bold text-gray-800">Address</label>
                        <label for="address" class="p-2 font-medium text-gray-800">{{ $booking->address }}, {{ $booking->postal_code }} {{ $booking->city }}, {{ $booking->state }}, {{ $booking->country }}.</label>
                    </div>
                </div>
        
                <div class="grid grid-cols-2 gap-4 mb-2">
                    <div class="grid grid-cols-2 gap-2">
                        <label for="startDate" class="p-2 font-bold text-gray-800">Start Date</label>
                        <label for="startDate" class="p-2 font-medium text-gray-800">{{ $booking->start_date }}</label>
                    </div>
        
                    <div class="grid grid-cols-2 gap-2">
                        <label for="endDate" class="p-2 font-bold text-gray-800">End Date</label>
                        <label for="endDate" class="p-2 font-medium text-gray-800">{{ $booking->end_date }}</label>
                    </div>
                </div>
        
                <div class="grid grid-cols-2 gap-4 mb-2">
                    <div class="grid grid-cols-2 gap-2">
                        <label for="startTime" class="p-2 font-bold text-gray-800">Start Time</label>
                        <label for="startTime" class="p-2 font-medium text-gray-800">{{ $booking->start_time }}</label>
                    </div>
        
                    <div class="grid grid-cols-2 gap-2">
                        <label for="endTime" class="p-2 font-bold text-gray-800">End Time</label>
                        <label for="endTime" class="p-2 font-medium text-gray-800">{{ $booking->end_time }}</label>
                    </div>
                </div>
        
                <div class="grid grid-cols-2 gap-4 mb-2">
                    <div class="grid grid-cols-2 gap-2">
                        <label for="numberOfGuests" class="p-2 font-bold text-gray-800">Number of Guests</label>
                        <label for="numberOfGuests" class="p-2 font-medium text-gray-800">{{ number_format($booking->number_of_guests) }}</label>
                    </div>
                </div>
        
                <div class="grid grid-cols-2 gap-4 mb-2">
                    <div class="grid grid-cols-2 gap-2">
                        <label for="remarks" class="p-2 font-bold text-gray-800">Remarks</label>
                        <label for="remarks" class="p-2 font-medium text-gray-800">{{ $booking->remarks }}</label>
                    </div>
                </div>
        
                @if ($booking->status == 1)
                    <div class="grid grid-cols-1 justify-center gap-8 mt-20 mb-6" style="display: flex;">
                        <form action="/cancel-booking/{{ $booking->id }}" method="POST">
                            @csrf
                            @method('PATCH')
        
                            <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="cancel-booking-confirmation">Cancel Booking</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- cancel booking confirmation --}}
    <script>
        document.getElementById('cancel-booking-confirmation')?.addEventListener('click', function () {
            var form = $(this).closest("form");
            event.preventDefault();

            Swal.fire({
                titleText: 'Cancel Booking',
                text: "Are you sure you want to cancel this booking?",
                icon: 'warning',
                showConfirmButton: true,
                showCancelButton: true,
                color: '#1f2937',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#14b8a6',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        })
    </script>
@endsection
