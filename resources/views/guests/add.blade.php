@extends('layouts.management-system')

@section('content')
    <p class="text-gray-400"><a href="/evbs/guests" class="hover:underline hover:text-teal-500 transition">Guests</a> / <span class="text-teal-500">Add Guest</span></p>

    <div class="p-4 bg-white rounded-lg mt-6">
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Add Guest</h1>
        </div>

        <form action="/evbs/guests/create" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-2 gap-4 mt-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="firstName" class="p-2 text-sm font-medium text-gray-800">First Name <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="firstName" value="{{ old('firstName') }}">
                    @error('firstName')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="lastName" class="p-2 text-sm font-medium text-gray-800">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="lastName" value="{{ old('lastName') }}">
                    @error('lastName')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="email" class="p-2 text-sm font-medium text-gray-800">Email <span class="text-red-500">*</span></label>
                    <input type="email" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="phoneNumber" class="p-2 text-sm font-medium text-gray-800">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="phoneNumber" value="{{ old('phoneNumber') }}">
                    @error('phoneNumber')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="password" class="p-2 text-sm font-medium text-gray-800">Password <span class="text-red-500">*</span></label>
                    <input type="password" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="password">
                    @error('password')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="confirmPassword" class="p-2 text-sm font-medium text-gray-800">Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="password_confirmation">
                </div>
                @error('password_confirmation')
                    <div></div>
                    <div>
                        <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                    </div>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-8 mt-20 mb-6">
                <div class="grid justify-items-end">
                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Create</button>
                </div>

                <div class="grid justify-items-start">
                    <a href="/evbs/guests" class="p-2 w-40 text-center text-sm text-white rounded-md bg-red-500 hover:bg-red-700 transition">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
