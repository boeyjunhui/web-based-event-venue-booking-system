@extends('layouts.management-system')

@section('content')
    <p class="text-gray-400"><a href="/evbs/profile" class="hover:underline hover:text-teal-500 transition">My Profile</a> / <span class="text-teal-500">Change Password</span></p>

    <div class="p-4 bg-white rounded-lg mt-6">
        <div class="grid justify-items-start">
            <h1 class="content-center text-2xl font-bold text-gray-800 mt-2 mb-2">Change Password</h1>
        </div>

        <form action="/evbs/profile/update-password" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-2 gap-4 mt-4 mb-6">
                <div class="grid grid-cols-2 gap-2">
                    <label for="newPassword" class="p-2 text-sm font-medium text-gray-800">New Password <span class="text-red-500">*</span></label>
                    <input type="password" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="password">
                    @error('password')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-2">
                    <label for="newConfirmPassword" class="p-2 text-sm font-medium text-gray-800">New Confirm Password <span class="text-red-500">*</span></label>
                    <input type="password" class="p-2 text-sm text-gray-800 border border-gray-300 rounded-md" name="password_confirmation">
                    @error('password_confirmation')
                        <div></div>
                        <div>
                            <p class="text-sm font-medium text-red-500 text-right">{{ $message }}</p>
                        </div>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 mt-20 mb-6">
                <div class="grid justify-items-end">
                    <button type="submit" class="p-2 w-40 text-sm text-white rounded-lg bg-teal-500 hover:bg-teal-700 transition">Update</button>
                </div>

                <div class="grid justify-items-start">
                    <a href="/evbs/profile" class="p-2 w-40 text-center text-sm text-white rounded-lg bg-red-500 hover:bg-red-700 transition">Cancel</a>
                </div>
            </div>
        </form>
    </div>
@endsection
