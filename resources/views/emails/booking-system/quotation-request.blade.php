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
                    <p class="mb-2">Dear {{ $name }},</p>
                    <p class="mb-8">This is to confirm that we have received your quotation request for {{ $eventVenueName }} event space.</p>

                    <br>
                    
                    <p class="mb-8">The following are the quotation request details:-</p>

                    <p class="mb-2">Event Venue: <b>{{ $eventVenueName }}</b></p>
                    <p class="mb-2">Address: <b>{{ $address }}</b></p>

                    <br>

                    <p class="mb-2">Start Date: <b>{{ $startDate }}</b></p>
                    <p class="mb-2">End Date: <b>{{ $endDate }}</b></p>
                    <p class="mb-2">Start Time: <b>{{ $startTime }}</b></p>
                    <p class="mb-2">End Time: <b>{{ $endTime }}</b></p>

                    <br>

                    <p class="mb-2">Number of Guests: <b>{{ $numberOfGuests }}</b></p>

                    <br>

                    <p class="mb-2">Remarks: <b>{{ $remarks }}</b></p>

                    <br>

                    <p>Thank you for your interest in booking an event space from us.</p>
                    <p>We will prepare an official quotation and get back to you within three working days.</p>

                    <br>

                    <p>Regards,</p>
                    <p>The Urban Space team</p>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
