@extends('layouts.booking-system')

@section('content')
    <div class="flex min-h-screen bg-gray-100 px-6 py-6">
        <div class="flex-1 h-full max-w-7xl mx-auto bg-white rounded-xl shadow-xl mt-10 mb-10">
            <div class="p-4 bg-white rounded-lg mx-4">
                @if (session('success'))
                    <div class="p-3 mt-4 mb-4 text-sm text-teal-800 border border-teal-200 rounded-lg bg-teal-100">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="p-3 mt-4 mb-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-100">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-2 mb-6 items-center">
                    <div class="grid justify-items-start">
                        <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">My Bookings</h1>
                    </div>
                </div>

                <div class="grid">
                    <div class="overflow-x-scroll">
                        <table id="data-table" class="text-sm whitespace-nowrap">
                            <thead class="text-white bg-gray-700">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Actions</th>
                                    <th scope="col">Event Venue</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
                                    <th scope="col">No of Guests</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-800 bg-neutral-50">
                                @php $no = 1; @endphp

                                @forelse ($bookings as $booking)
                                    <tr class="hover:bg-neutral-200 transition">
                                        <td>{{ $no }}</td>
                                        <td style="display: flex;">
                                            <a href="/bookings/{{ $booking->id }}"><button type="submit" class="p-1 w-10 text-lg text-white rounded-md bg-brown-500 hover:bg-brown-700 transition"><i class="bx bx-info-circle"></i></button></a>

                                            @if ($booking->status == 1)
                                                <form action="/cancel-booking/{{ $booking->id }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="ml-2 p-1 w-10 text-lg text-white rounded-md bg-red-500 hover:bg-red-700 transition" id="cancel-booking-confirmation-{{ $no }}"><i class="bx bx-block"></i></button>
                                                </form>
                                            @endif
                                        </td>
                                        <td>{{ $booking->event_venue_name }}</td>
                                        <td>{{ $booking->start_date }}</td>
                                        <td>{{ $booking->end_date }}</td>
                                        <td>{{ $booking->start_time }}</td>
                                        <td>{{ $booking->end_time }}</td>
                                        <td>{{ number_format($booking->number_of_guests) }}</td>
                                        <td>
                                            @if ($booking->status == 0)
                                                <span class="p-1.5 text-sm font-medium text-white bg-red-500 rounded-md">Cancelled</span>
                                            @elseif ($booking->status == 1)
                                                <span class="p-1.5 text-sm font-medium text-white bg-gray-500 rounded-md">Pending</span>
                                            @elseif ($booking->status == 2)
                                                <span class="p-1.5 text-sm font-medium text-white bg-teal-500 rounded-md">Confirmed</span>
                                            @endif
                                        </td>
                                    </tr>

                                    {{-- cancel booking confirmation --}}
                                    <script>
                                        document.getElementById('cancel-booking-confirmation-{{ $no }}')?.addEventListener('click', function () {
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

                                    @php $no++; @endphp
                                @empty
                                
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
