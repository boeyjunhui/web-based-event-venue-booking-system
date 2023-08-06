@include('layouts.xray.start-xray', ['name' => 'urban-space-test.us-east-1.elasticbeanstalk.com/evbs'])

@include('layouts.management-system.header')
@yield('content')
@include('layouts.management-system.footer')

@include('layouts.xray.end-xray')