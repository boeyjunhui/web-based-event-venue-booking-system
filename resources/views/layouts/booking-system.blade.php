@include('layouts.xray.start-xray', ['name' => 'urban-space.us-east-1.elasticbeanstalk.com'])

@include('layouts.booking-system.header')
@yield('content')
@include('layouts.booking-system.footer')

@include('layouts.xray.end-xray')


