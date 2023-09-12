@extends('layouts.management-system')

@section('content')
    @if (session('success'))
        <div class="p-3 mt-4 mb-4 text-sm text-teal-800 border border-teal-200 rounded-lg bg-teal-100">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="p-3 mt-4 mb-4 text-sm text-red-800 border border-red-200 rounded-lg bg-red-100">
            {{ session('error') }}
        </div>
    @endif

    <div class="p-4 bg-white rounded-lg mt-2">
        <div class="grid grid-cols-2 mb-6 items-center">
            <div class="grid justify-items-start">
                <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Guest Bookings</h1>
            </div>

            <div class="grid justify-items-end">
                <a href="/evbs/bookings/add-guest-booking"><button type="submit" class="p-1 w-16 text-2xl text-white rounded-md bg-teal-500 hover:bg-teal-700 transition"><i class="bx bx-plus"></i></button></a>
            </div>
        </div>

        <div class="grid">
            <div class="overflow-x-scroll mb-6">
                <table id="data-table" class="text-sm whitespace-nowrap">
                    <thead class="text-white bg-gray-700">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Actions</th>
                            <th scope="col">Guest</th>
                            <th scope="col">Event Venue</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Start Time</th>
                            <th scope="col">End Time</th>
                            <th scope="col">No of Guests</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Updated At</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800 bg-neutral-50">
                        @php $no = 1; @endphp

                        @forelse ($guestBookings as $guestBooking)
                            <tr class="hover:bg-neutral-200 transition">
                                <td>{{ $no }}</td>
                                <td style="display: flex;">
                                    <a href="/evbs/bookings/guest-booking/{{ $guestBooking->id }}"><button type="submit" class="p-1 w-10 text-lg text-white rounded-md bg-blue-500 hover:bg-blue-700 transition"><i class="bx bx-info-circle"></i></button></a>

                                    @if ($guestBooking->status == 1)
                                        <span class="ml-2"></span>
                                        <a href="/evbs/bookings/{{ $guestBooking->id }}/edit-guest-booking"><button type="submit" class="p-1 w-10 text-lg text-white rounded-md bg-amber-500 hover:bg-amber-700 transition"><i class="bx bx-pencil"></i></button></a>

                                        <form action="/evbs/bookings/{{ $guestBooking->id }}/delete-guest-booking" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="ml-2 p-1 w-10 text-lg text-white rounded-md bg-red-500 hover:bg-red-700 transition" id="delete-confirmation-{{ $no }}"><i class="bx bx-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    @if (session('user_role') == "Super Admin")
                                        <a href="/evbs/guests/{{ $guestBooking->guest_id }}" class="hover:underline hover:text-teal-500 transition" target="_blank">{{ $guestBooking->first_name }} {{ $guestBooking->last_name }}</a>
                                    @elseif (session('user_role') == "Event Venue Owner")
                                        {{ $guestBooking->first_name }} {{ $guestBooking->last_name }}
                                    @endif
                                </td>
                                <td>
                                    <a href="/evbs/event-venues/{{ $guestBooking->event_venue_id }}" class="hover:underline hover:text-teal-500 transition" target="_blank">{{ $guestBooking->event_venue_name }}</a>
                                </td>
                                <td>{{ $guestBooking->start_date }}</td>
                                <td>{{ $guestBooking->end_date }}</td>
                                <td>{{ $guestBooking->start_time }}</td>
                                <td>{{ $guestBooking->end_time }}</td>
                                <td>{{ number_format($guestBooking->number_of_guests) }}</td>
                                <td>
                                    @if ($guestBooking->status == 0)
                                        <span class="p-1.5 text-sm font-medium text-white bg-red-500 rounded-md">Cancelled</span>
                                    @elseif ($guestBooking->status == 1)
                                        <span class="p-1.5 text-sm font-medium text-white bg-gray-500 rounded-md">Pending</span>
                                    @elseif ($guestBooking->status == 2)
                                        <span class="p-1.5 text-sm font-medium text-white bg-teal-500 rounded-md">Confirmed</span>
                                    @endif
                                </td>
                                <td>{{ $guestBooking->created_at }}</td>
                                <td>{{ $guestBooking->updated_at }}</td>
                            </tr>

                            {{-- delete confirmation --}}
                            <script>
                                document.getElementById('delete-confirmation-{{ $no }}')?.addEventListener('click', function () {
                                    var form = $(this).closest("form");
                                    event.preventDefault();

                                    Swal.fire({
                                        titleText: 'Delete',
                                        text: "Are you sure you want to delete this guest booking?",
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
@endsection
