@php
    use Pkerrigan\Xray\Trace;
    use Pkerrigan\Xray\SqlSegment;
    use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;
    use Illuminate\Support\Facades\Session;

    Trace::getInstance()
        ->end()
        ->setResponseCode(http_response_code())
        ->submit(new DaemonSegmentSubmitter());

    Session::put(['trace_id' => Trace::getInstance()->getTraceId(), 'parent_id' => Trace::getInstance()->getId()]);

@endphp
