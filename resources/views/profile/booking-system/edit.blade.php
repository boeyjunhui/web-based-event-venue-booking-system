@extends('layouts.booking-system')

@section('content')
    <div class="flex min-h-screen bg-gray-100 px-6 py-6">
        <div class="flex-1 h-full max-w-2xl mx-auto bg-white rounded-xl shadow-xl mt-10">
            <div class="flex items-center justify-center p-6 sm:p-12">
                <div class="w-full">
                    <h1 class="text-3xl font-bold text-center tracking-wide text-gray-800 mb-4">Edit Profile</h1>

                    <form action="/profile/update-profile" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="mt-6 mb-4">
                            <label for="firstName" class="block mb-2 text-sm font-medium text-gray-800">First Name <span class="text-red-500">*</span></label>
                            <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="firstName" value="{{ $guest->first_name }}">
                            @error('firstName')
                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="lastName" class="block mb-2 text-sm font-medium text-gray-800">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="lastName" value="{{ $guest->last_name }}">
                            @error('lastName')
                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-800">Email <span class="text-red-500">*</span></label>
                            <input type="email" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="email" value="{{ $guest->email }}">
                            @error('email')
                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-8">
                            <label for="phoneNumber" class="block mb-2 text-sm font-medium text-gray-800">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="phoneNumber" value="{{ $guest->phone_number }}">
                            @error('phoneNumber')
                                <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="p-2.5 w-full text-sm font-bold text-white rounded-md bg-brown-500 hover:bg-brown-700 transition mb-4">Update</button>
                    </form>

                    <a href="/profile"><button type="submit" class="p-2.5 w-full text-sm font-bold text-gray-800 border border-gray-800 rounded-md hover:bg-brown-100 transition">Cancel</button></a>
                </div>
            </div>
        </div>
    </div>
@endsection
