@include('layouts.xray.start-xray', ['name' => 'urban-space-test.us-east-1.elasticbeanstalk.com/evbs'])

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

<style>
    input {
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
            <img src="{{env('CLOUD_FRONT_URL')}}/assets/urban-space-logo-black.png" alt="" style="width: 380px; height: 75px;">
            </span>
            
            <div class="w-full bg-white rounded-lg sm:max-w-md">
                <div class="p-6">
                    <h1 class="text-2xl font-bold text-center text-gray-800">Reset Password</h1>

                    <form action="/evbs/reset-password" method="POST">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mt-6 mb-4">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-800 @error('email') is-invalid @enderror">Email</label>
                            <input type="email" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="email" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-sm font-medium text-right text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="newPassword" class="block mb-2 text-sm font-medium text-gray-800 @error('password') is-invalid @enderror">New Password</label>
                            <input type="password" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="password">
                            @error('password')
                                <p class="text-sm font-medium text-right text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="confirmNewPassword" class="block mb-2 text-sm font-medium text-gray-800 @error('password_confirmation') is-invalid @enderror">Confirm New Password</label>
                            <input type="password" class="block p-2.5 w-full text-sm text-gray-800 border border-gray-300 rounded-md" name="password_confirmation">
                            @error('password_confirmation')
                                <p class="text-sm font-medium text-right text-red-500 mt-1.5">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="p-2.5 w-full text-sm text-white rounded-md bg-teal-500 hover:bg-teal-700 transition mb-20">Reset Password</button>
                    </form>

                    <a href="/evbs/login"><button type="submit" class="p-2.5 w-full text-sm text-gray-500 border border-gray-300 rounded-md hover:bg-gray-100 transition mb-4">Login</button></a>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
@include('layouts.xray.end-xray')
