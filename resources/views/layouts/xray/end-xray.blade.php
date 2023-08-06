@php
    use Pkerrigan\Xray\Trace;
    use Pkerrigan\Xray\SqlSegment;
    use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;
    use Illuminate\Support\Facades\Session;

    Trace::getInstance()
        ->end()
        ->setResponseCode(http_response_code())
        ->submit(new DaemonSegmentSubmitter());
    
    // Store a single value in the session
    // Session::put('key', 'value');
    // print 'trace_id';
    // // print_r(Trace::getInstance()->getTraceId());
    
    // print_r('parent_id');
    // print_r(Trace::getInstance()->getId());
    
    // Store multiple values in the session
    Session::put(['trace_id' => Trace::getInstance()->getTraceId(), 'parent_id' => Trace::getInstance()->getId()]);
    //   $_SESSION['trace_id'] = Trace::getInstance()->getTraceId();
    // $_SESSION['parent_id'] = Trace::getInstance()->getId();
    // $data = $request->session()->all();
    // echo session('trace_id');
    // echo session('parent_id');
    // dd('trace', session('trace_id'), 'par', session('parent_id'));


// echo Trace::getInstance()->getTraceId();
@endphp
