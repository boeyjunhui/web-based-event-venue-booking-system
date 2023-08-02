@extends('layouts.booking-system')

@section('content')
    <div class="flex items-center min-h-screen bg-gray-100 px-6 py-6">
        <div class="flex-1 h-full max-w-4xl mx-auto bg-white rounded-xl shadow-xl">
            <div class="flex flex-col md:flex-row">
                <div class="h-32 md:h-auto md:w-1/2">
                    {{-- todo --}}
                    <img class="object-cover w-full h-full rounded-l-xl" src="{{ asset('/assets/vault.jpg') }}" alt="">
                </div>
                
                <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
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
                        
                        <h1 class="text-3xl font-bold text-center tracking-wide text-gray-800 mb-4">Reset Password</h1>

                        <form action="/reset-password" method="POST">
                            @csrf
                            
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="mt-6 mb-4">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-800">Email <span class="text-red-500">*</span></label>
                                <input type="email" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="newPassword" class="block mb-2 text-sm font-medium text-gray-800">New Password <span class="text-red-500">*</span></label>
                                <input type="password" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-lg" name="password">
                                @error('password')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>
    
                            <div class="mb-6">
                                <label for="confirmNewPassword" class="block mb-2 text-sm font-medium text-gray-800">Confirm New Password <span class="text-red-500">*</span></label>
                                <input type="password" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-lg" name="password_confirmation">
                                @error('password_confirmation')
                                    <p class="text-sm font-medium text-red-500 mt-1.5">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="p-2.5 w-full text-sm font-bold text-white rounded-md bg-brown-500 hover:bg-brown-700 transition mb-16">Reset Password</button>
                        </form>

                        <a href="/login"><button type="submit" class="p-2.5 w-full text-sm font-bold text-gray-800 border border-gray-800 rounded-md hover:bg-brown-100 transition">Back to Login</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
