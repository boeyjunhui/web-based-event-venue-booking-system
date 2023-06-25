@extends('layouts.internal-user')

@section('content')
    <p class="text-gray-400"><a href="/evbs/guests" class="hover:underline hover:text-teal-500 transition">Guests</a> / <span class="text-teal-500">{{ $guest->first_name }} {{ $guest->last_name }}</span></p>

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
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Guest</h1>
        </div>

        <div class="grid grid-cols-1 justify-items-center content-center mt-4">
            <div class="grid">
                <label for="name" class="p-2 text-2xl font-bold text-gray-800">{{ $guest->first_name }} {{ $guest->last_name }}</label>
            </div>

            <div class="grid mb-10">
                @if ($guest->status == 0)
                    <span class="p-1.5 text-sm font-medium text-white bg-red-500 rounded-lg">Inactive</span>
                @elseif ($guest->status == 1)
                    <span class="p-1.5 text-sm font-medium text-white bg-teal-500 rounded-lg">Active</span>
                @endif
            </div>

            <div class="grid">
                <div class="grid gap-2 mb-6">
                    <label for="email" class="font-bold text-gray-800">Email</label>
                    <label for="email" class="font-medium text-gray-800">
                        <a href="mailto:{{ $guest->email }}" class="hover:underline hover:text-teal-500 transition">{{ $guest->email }}</a>
                    </label>
                </div>
    
                <div class="grid gap-2 mb-6">
                    <label for="phoneNumber" class="font-bold text-gray-800">Phone Number</label>
                    <label for="phoneNumber" class="font-medium text-gray-800">
                        <a href="tel:{{ $guest->phone_number }}" class="hover:underline hover:text-teal-500 transition">{{ $guest->phone_number }}</a>
                    </label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 justify-center gap-8 mt-20 mb-6" style="display: flex;">
            <a href="/evbs/guests/{{ $guest->id }}/edit"><button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Edit</button></a>
            <a href="/evbs/guests/{{ $guest->id }}/change-password"><button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Change Password</button></a>

            @if ($guest->status == 0)
                <form action="/evbs/guests/{{ $guest->id }}/activate" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-teal-500 hover:bg-teal-700 transition" id="activate-confirmation">Activate</button>
                </form>
            @elseif ($guest->status == 1)
                <form action="/evbs/guests/{{ $guest->id }}/deactivate" method="POST">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="deactivate-confirmation">Deactivate</button>
                </form>
            @endif

            <form action="/evbs/guests/{{ $guest->id }}/delete" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition" id="delete-confirmation">Delete</button>
            </form>
        </div>
    </div>
@endsection
