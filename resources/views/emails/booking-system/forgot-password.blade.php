<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite('resources/css/app.css')
</head>

<body>
    <section class="min-h-screen overflow-y-auto bg-gray-200">
        <div class="flex flex-col items-center justify-center px-8 py-8">
            <div class="grid justify-items-center mt-2 mb-6" style="text-align: center;">
                {{-- todo --}}
                <img src="{{ asset('/assets/urban-space-logo-white-bg.png') }}" class="rounded-lg" alt="" style="width: 325px; height: 61px;">
            </div>

            <div class="w-full bg-white rounded-2xl shadow-xl sm:max-w-md">
                <div class="p-6">
                    <h3 class="text-md font-bold text-gray-700 mb-8">Reset your account password</h3>

                    <p class="mb-2">Dear {{ $name }},</p>
                    <p class="mb-8">You are receiving this email because we have received a password reset request for your account.</p>
                    <p class="mb-8">Please click the link below to reset your account password.</p>

                    <div class="grid justify-items-center">
                        <a href="{{ route('displayGuestResetPasswordForm', $token) }}" class="p-2.5 w-36 text-sm text-white text-center rounded-lg bg-indigo-500 hover:bg-indigo-700 transition mb-8">Reset Password Link</a>
                    </div>
                    
                    <p class="mb-8">If you did not request a password reset link, please ignore this email.</p><br>

                    <p>Regards,</p>
                    <p>The Urban Space team</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
