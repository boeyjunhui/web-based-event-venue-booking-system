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
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">My Profile</h1>
        </div>

        <div class="grid grid-cols-1 justify-items-center content-center mt-4">
            <div class="grid mb-10">
                <label for="name" class="p-2 text-2xl font-bold text-gray-800">{{ $user->first_name }} {{ $user->last_name }}</label>
            </div>

            <div class="grid">
                <div class="grid gap-2 mb-6">
                    <label for="email" class="font-bold text-gray-800">Email</label>
                    <label for="email" class="font-medium text-gray-800">
                        <a href="mailto:{{ $user->email }}" class="hover:underline hover:text-teal-500 transition">{{ $user->email }}</a>
                    </label>
                </div>
    
                <div class="grid gap-2 mb-6">
                    <label for="phoneNumber" class="font-bold text-gray-800">Phone Number</label>
                    <label for="phoneNumber" class="font-medium text-gray-800">
                        <a href="tel:{{ $user->phone_number }}" class="hover:underline hover:text-teal-500 transition">{{ $user->phone_number }}</a>
                    </label>
                </div>
    
                <div class="grid gap-2 mb-6">
                    <label for="address" class="font-bold text-gray-800">Address</label>
                    <label for="address" class="font-medium text-gray-800">{{ $user->address }}, {{ $user->postal_code }} {{ $user->city }}, {{ $user->state }}, {{ $user->country }}.</label>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 justify-center gap-8 mt-20 mb-6" style="display: flex;">
            <a href="/evbs/profile/edit-profile"><button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Edit Profile</button></a>
            <a href="/evbs/profile/change-password"><button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Change Password</button></a>
        </div>
    </div>
@endsection
