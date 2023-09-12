@extends('layouts.booking-system')

@section('content')
    <div class="flex items-center min-h-screen bg-gray-100 px-6 py-6">
        <div class="flex-1 h-full max-w-4xl mx-auto bg-white rounded-lg shadow-xl mt-10 mb-10">
            <div class="flex flex-col md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                <img class="object-cover w-full h-full rounded-l-lg" src="{{env('CLOUD_FRONT_URL')}}/assets/event-3.jpg" alt="">
                </div>

                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                    <div class="w-full">
                        <h1 class="text-3xl font-bold text-center tracking-wide text-gray-800 mb-4">Register as an Owner</h1>

                        <form action="/event-venue-owner/register" method="POST">
                            @csrf

                            <div class="mt-6 mb-4">
                                <label for="firstName" class="block mb-2 text-sm font-medium text-gray-800">First Name <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="firstName" value="{{ old('firstName') }}">
                                @error('firstName')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="lastName" class="block mb-2 text-sm font-medium text-gray-800">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="lastName" value="{{ old('lastName') }}">
                                @error('lastName')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-800">Email <span class="text-red-500">*</span></label>
                                <input type="email" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="phoneNumber" class="block mb-2 text-sm font-medium text-gray-800">Phone Number <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="phoneNumber" value="{{ old('phoneNumber') }}">
                                @error('phoneNumber')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-800">Password <span class="text-red-500">*</span></label>
                                <input type="password" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="password">
                                @error('password')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="confirmPassword" class="block mb-2 text-sm font-medium text-gray-800">Confirm Password <span class="text-red-500">*</span></label>
                                <input type="password" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="password_confirmation">
                                @error('password_confirmation')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="address" class="block mb-2 text-sm font-medium text-gray-800">Address <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="address" value="{{ old('address') }}">
                                @error('address')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="postalCode" class="block mb-2 text-sm font-medium text-gray-800">Postal Code <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="postalCode" value="{{ old('postalCode') }}">
                                @error('postalCode')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="city" class="block mb-2 text-sm font-medium text-gray-800">City <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="city" value="{{ old('city') }}">
                                @error('city')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="state" class="block mb-2 text-sm font-medium text-gray-800">State <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="state" value="{{ old('state') }}">
                                @error('state')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label for="country" class="block mb-2 text-sm font-medium text-gray-800">Country <span class="text-red-500">*</span></label>
                                <input type="text" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="country" value="{{ old('country') }}">
                                @error('country')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>


                            <button type="submit" class="p-2.5 w-full text-sm font-bold text-white rounded-md bg-brown-500 hover:bg-brown-700 transition mb-4">Register</button>
                        </form>

                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-800">Have an account? <a href="/evbs/login" class="text-brown-700 hover:underline" target="_blank">Sign in as owner</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
