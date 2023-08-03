<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Urban Space Event Venue Booking System</title>
    <link rel="icon" href="{{ asset('/assets/urban-space-logo-black.png') }}">

    {{-- tailwind css --}}
    @vite('resources/css/app.css')


</head>

@php
    // echo 'test x ray start 1';
    use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;
Trace::getInstance()
    ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
    ->setName('app.example.com')
    ->setUrl($_SERVER['REQUEST_URI'])
    ->setMethod($_SERVER['REQUEST_METHOD'])
    ->begin(); 

sleep(1); // give x-ray something to actually measure

Trace::getInstance()
    ->end()
    ->setResponseCode(http_response_code())
    ->submit(new DaemonSegmentSubmitter());

    // echo 'test x ray end 1';


@endphp

<style>
    input {
        outline-offset: 0px;
        outline-color: #14b8a6;
    }
    
    select {
        outline-offset: 0px;
        outline-color: #14b8a6;
    }
</style>

<body>
    <section class="min-h-screen overflow-y-auto bg-gray-300">
        <div class="flex flex-col items-center justify-center px-8 py-8">
            @if (session('success'))
                <div class="w-full p-3 mt-4 mb-2 text-sm text-green-800 border border-green-200 rounded-lg bg-green-100 sm:max-w-md">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="w-full p-3 mt-4 mb-2 text-sm text-red-800 border border-red-200 rounded-lg bg-red-100 sm:max-w-md">
                    {{ session('error') }}
                </div>
            @endif

            <span class="flex items-center mt-24 mb-6">
            <img src="{{env('CLOUD_FRONT_URL')}}/assets/urban-space-logo-black.png" alt=""style="width: 380px; height: 75px;">
            </span>
            
            <div class="w-full bg-white rounded-lg sm:max-w-md">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-center text-gray-800">Sign In</h1>

                    <form action="/evbs/login" method="POST">
                        @csrf

                        <div class="mt-6 mb-4">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-800 @error('email') is-invalid @enderror">Email</label>
                            <input type="email" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="email" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-sm font-medium text-right text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-800 @error('password') is-invalid @enderror">Password</label>
                            <input type="password" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="password">
                            @error('password')
                                <p class="text-sm font-medium text-right text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="userRole" class="block mb-2 text-sm font-medium text-gray-800 @error('userRole') is-invalid @enderror">User Role</label>
                            <select class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md cursor-pointer" name="userRole">
                                <option value="">-- Select User Role --</option>
                                <option value="1">Super Admin</option>
                                <option value="2">Event Venue Owner</option>
                            </select>
                            @error('userRole')
                                <p class="text-sm font-medium text-right text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid justify-items-center mb-6">
                            <a href="/evbs/forgot-password" class="text-sm font-medium text-teal-500 hover:underline transition">Forgot password?</a>
                        </div>

                        <button type="submit" class="p-2.5 w-full text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition mb-2">Sign In</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
