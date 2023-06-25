@extends('layouts.internal-user')

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
                <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Guests</h1>
            </div>

            <div class="grid justify-items-end">
                <a href="/evbs/guests/add"><button type="submit" class="p-1 w-16 text-2xl text-white rounded-md bg-teal-500 hover:bg-teal-700 transition"><i class="bx bx-plus"></i></button></a>
            </div>
        </div>

        <div class="grid">
            <div class="overflow-x-scroll mb-6">
                <table id="data-table" class="text-sm whitespace-nowrap">
                    <thead class="text-white bg-gray-700">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Status</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Updated At</th>
                            <th scope="col">Actions</th>
                    </thead>

                    <tbody class="text-gray-800 bg-neutral-50">
                        @php $no = 1; @endphp

                        @forelse ($guests as $guest)
                            <tr class="hover:bg-neutral-200 transition">
                                <td>{{ $no }}</td>
                                <td>{{ $guest->first_name }} {{ $guest->last_name }}</td>
                                <td>
                                    <a href="mailto:{{ $guest->email }}" class="hover:underline hover:text-teal-500 transition">{{ $guest->email }}</a>
                                </td>
                                <td>
                                    <a href="tel:{{ $guest->phone_number }}" class="hover:underline hover:text-teal-500 transition">{{ $guest->phone_number }}</a>
                                </td>
                                <td>
                                    @if ($guest->status == 0)
                                        <span class="p-1.5 text-sm font-medium text-white bg-red-500 rounded-md">Inactive</span>
                                    @elseif ($guest->status == 1)
                                        <span class="p-1.5 text-sm font-medium text-white bg-teal-500 rounded-md">Active</span>
                                    @endif
                                </td>
                                <td>{{ $guest->created_at }}</td>
                                <td>{{ $guest->updated_at }}</td>
                                <td style="display: flex;">
                                    <a href="/evbs/guests/{{ $guest->id }}"><button type="submit" class="p-1 w-10 text-lg text-white rounded-md bg-blue-500 hover:bg-blue-700 transition"><i class="bx bx-info-circle"></i></button></a>
                                    <span class="ml-2"></span>
                                    <a href="/evbs/guests/{{ $guest->id }}/edit"><button type="submit" class="p-1 w-10 text-lg text-white rounded-md bg-amber-500 hover:bg-amber-700 transition"><i class="bx bx-pencil"></i></button></a>

                                    @if ($guest->status == 0)
                                        <form action="/evbs/guests/{{ $guest->id }}/activate" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="ml-2 p-1 w-10 text-lg text-white rounded-md bg-teal-500 hover:bg-teal-700 transition" id="activate-confirmation-{{ $no }}"><i class="bx bx-show"></i></button>
                                        </form>
                                    @elseif ($guest->status == 1)
                                        <form action="/evbs/guests/{{ $guest->id }}/deactivate" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="ml-2 p-1 w-10 text-lg text-white rounded-md bg-red-500 hover:bg-red-700 transition" id="deactivate-confirmation-{{ $no }}"><i class="bx bx-hide"></i></button>
                                        </form>
                                    @endif

                                    <form action="/evbs/guests/{{ $guest->id }}/delete" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="ml-2 p-1 w-10 text-lg text-white rounded-md bg-red-500 hover:bg-red-700 transition" id="delete-confirmation-{{ $no }}"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            {{-- activate confirmation --}}
                            <script>
                                document.getElementById('activate-confirmation-{{ $no }}').addEventListener('click', function () {
                                    var form = $(this).closest("form");
                                    event.preventDefault();

                                    Swal.fire({
                                        titleText: 'Activate',
                                        text: "Are you sure you want to activate {{ $guest->first_name }} {{ $guest->last_name }}?",
                                        icon: 'question',
                                        showConfirmButton: true,
                                        showCancelButton: true,
                                        color: '#1f2937',
                                        confirmButtonColor: '#14b8a6',
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

                            {{-- deactivate confirmation --}}
                            <script>
                                document.getElementById('deactivate-confirmation-{{ $no }}').addEventListener('click', function () {
                                    var form = $(this).closest("form");
                                    event.preventDefault();

                                    Swal.fire({
                                        titleText: 'Deactivate',
                                        text: "Are you sure you want to deactivate {{ $guest->first_name }} {{ $guest->last_name }}?",
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

                            {{-- delete confirmation --}}
                            <script>
                                document.getElementById('delete-confirmation-{{ $no }}').addEventListener('click', function () {
                                    var form = $(this).closest("form");
                                    event.preventDefault();

                                    Swal.fire({
                                        titleText: 'Delete',
                                        text: "Are you sure you want to delete {{ $guest->first_name }} {{ $guest->last_name }}?",
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
