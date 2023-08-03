<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    {{-- tailwind css --}}
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}
    {{-- @vite('resources/css/app.css') --}}

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    {{-- for xray --}}
    @php
        \Pkerrigan\Xray\Trace::getInstance()
            ->setName('my-app')
            ->setUrl('http:/ss')
            ->setMethod('GET')
            ->begin();
    @endphp
</head>
<body class="antialiased">

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="  bg-red-50">
            {{-- todo this is image file from s3 --}}
            <img src="https://ddac-assignment-1.s3.amazonaws.com/urban-space-logo-white.png" alt="log">

            {{-- todo form that upload file to s3 --}}
            <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file">
                <button type="submit">Upload</button>
            </form>
            @if (session('success'))
                <div>{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div>{{ session('error') }}</div>
            @endif
        </div>
    </div>
    @php
        
        \Pkerrigan\Xray\Trace::getInstance()
            ->end()
            ->setResponseCode(http_response_code())
            ->setError(http_response_code() >= 400 && http_response_code() < 500)
            ->setFault(http_response_code() >= 500)
            ->submit(new \Pkerrigan\Xray\Submission\DaemonSegmentSubmitter());
        
    @endphp
</body>

</html>
