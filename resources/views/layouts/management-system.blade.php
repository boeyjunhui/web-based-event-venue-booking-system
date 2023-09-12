@include('layouts.xray.start-xray', ['name' => 'urban-space.us-east-1.elasticbeanstalk.com'])

@include('layouts.management-system.header')
@yield('content')
@include('layouts.management-system.footer')

@include('layouts.xray.end-xray')