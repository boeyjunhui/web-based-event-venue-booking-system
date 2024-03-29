@extends('layouts.management-system')

@section('content')
    <p class="text-gray-400"><a href="/evbs/super-admins" class="hover:underline hover:text-teal-500 transition">Super Admins</a> / <a href="/evbs/super-admins/{{ $superAdmin->id }}" class="hover:underline hover:text-teal-500 transition">{{ $superAdmin->first_name }} {{ $superAdmin->last_name }}</a> / <span class="text-teal-500">Edit Super Admin</span></p>

    <div class="p-4 bg-white rounded-lg mt-6">
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Edit Super Admin</h1>
        </div>

        <form action="/evbs/super-admins/{{ $superAdmin->id }}/update" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4 mt-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="firstName" class="p-2 text-sm font-medium text-gray-800">First Name <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="firstName" value="{{ $superAdmin->first_name }}">
                    @error('firstName')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="lastName" class="p-2 text-sm font-medium text-gray-800">Last Name <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="lastName" value="{{ $superAdmin->last_name }}">
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
                    <input type="email" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="email" value="{{ $superAdmin->email }}">
                    @error('email')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="phoneNumber" class="p-2 text-sm font-medium text-gray-800">Phone Number <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="phoneNumber" value="{{ $superAdmin->phone_number }}">
                    @error('phoneNumber')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-12 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="address" class="p-2 text-sm font-medium text-gray-800">Address <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="address" value="{{ $superAdmin->address }}">
                    @error('address')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="postalCode" class="p-2 text-sm font-medium text-gray-800">Postal Code <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="postalCode" value="{{ $superAdmin->postal_code }}">
                    @error('postalCode')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="city" class="p-2 text-sm font-medium text-gray-800">City <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="city" value="{{ $superAdmin->city }}">
                    @error('city')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="state" class="p-2 text-sm font-medium text-gray-800">State <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="state" value="{{ $superAdmin->state }}">
                    @error('state')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="country" class="p-2 text-sm font-medium text-gray-800">Country <span class="text-red-500">*</span></label>
                    <input type="text" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="country" value="{{ $superAdmin->country }}">
                    @error('country')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mt-20 mb-6">
                <div class="grid justify-items-end">
                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition">Update</button>
                </div>

                <div class="grid justify-items-start">
                    <a href="/evbs/super-admins/{{ $superAdmin->id }}" class="p-2 w-40 text-center text-sm text-white rounded-md bg-red-500 hover:bg-red-700 transition">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
