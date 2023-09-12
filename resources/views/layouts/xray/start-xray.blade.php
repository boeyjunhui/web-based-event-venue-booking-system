@php
    use Pkerrigan\Xray\Trace;
    use Pkerrigan\Xray\SqlSegment;
    use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;
    use Illuminate\Support\Facades\Session;
    
    Trace::getInstance()
        ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
        ->setName($name)
        ->setUrl($_SERVER['REQUEST_URI'])
        ->setMethod($_SERVER['REQUEST_METHOD'])
        ->begin(100);
@endphp
