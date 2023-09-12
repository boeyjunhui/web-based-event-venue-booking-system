@extends('layouts.booking-system')

@section('content')
    <div class="flex min-h-screen bg-gray-100 px-6 py-6">
        <div class="flex-1 h-full max-w-2xl mx-auto bg-white rounded-xl shadow-xl mt-10">
            <div class="flex items-center justify-center p-6 sm:p-12">
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

                    <h1 class="text-3xl font-bold text-center tracking-wide text-gray-800 mb-4">My Profile</h1>
                    
                    <div class="mt-6 mb-6">
                        <label for="name" class="block mb-2 text-md font-bold text-gray-800">Name</label>
                        <label for="name" class="block mb-2 text-md font-medium text-gray-800">{{ $guest->first_name }} {{ $guest->last_name }}</label>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block mb-2 text-md font-bold text-gray-800">Email</label>
                        <label for="email" class="block mb-2 text-md font-medium text-gray-800">{{ $guest->email }}</label>
                    </div>

                    <div class="mb-8">
                        <label for="phoneNumber" class="block mb-2 text-md font-bold text-gray-800">Phone Number</label>
                        <label for="phoneNumber" class="block mb-2 text-md font-medium text-gray-800">{{ $guest->phone_number }}</label>
                    </div>

                    <a href="/profile/edit-profile"><button type="submit" class="p-2.5 w-full text-sm font-bold text-white rounded-md bg-brown-500 hover:bg-brown-700 transition mb-4">Edit Profile</button></a>
                    <a href="/profile/change-password"><button type="submit" class="p-2.5 w-full text-sm font-bold text-white rounded-md bg-brown-500 hover:bg-brown-700 transition">Change Password</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection
