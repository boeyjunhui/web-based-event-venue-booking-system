<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Pkerrigan\Xray\Trace;
use Pkerrigan\Xray\SqlSegment;
use Pkerrigan\Xray\Submission\DaemonSegmentSubmitter;
use Pkerrigan\Xray\RemoteSegment;
use Illuminate\Support\Facades\Session;


class XRayController extends Controller
{
    public function begin()
    {
        echo 'start';
        Trace::getInstance()
            ->setTraceHeader($_SERVER['HTTP_X_AMZN_TRACE_ID'] ?? null)
            ->setParentId(session('parent_id'))
            ->setTraceId(session('trace_id'))
            ->setIndependent(true)
            ->setName('urban-space-test.us-east-1.elasticbeanstalk.com')
            ->setUrl($_SERVER['REQUEST_URI'])
            ->setMethod($_SERVER['REQUEST_METHOD'])
            ->begin(100);
    }
    public function startS3()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->addSubsegment(
                (new RemoteSegment())
                    ->setName('s3://cleanconnect-image/images/')
                    ->begin(100)
            );


    }
    public function startRds()
    {
        echo 'start rds';
        Trace::getInstance()
            ->getCurrentSegment()
            ->addSubsegment(
                (new SqlSegment())
                    ->setName('urbanSpaceRDS')
                    ->setUrl(env('DB_HOST'))
                    ->setDatabaseType('MySQL Community')
                    ->begin(100)
            );

    }
    public function addRdsQuery($query)
    {
        echo 'start collection';

        Trace::getInstance()
            ->getCurrentSegment()
            ->setQuery($query)
            ->end();
    }

    public function end()
    {
        Trace::getInstance()
            ->getCurrentSegment()
            ->end();

        // Trace::getInstance()
        // 	->end()
        // 	->setResponseCode(http_response_code())
        // 	->submit(new DaemonSegmentSubmitter());	

    }
    public function submit()
    {
        echo 'end';
        // Trace::getInstance()
        //     ->getCurrentSegment()
        //     ->end();

        Trace::getInstance()
            ->end()
            ->setResponseCode(http_response_code())
            ->submit(new DaemonSegmentSubmitter());



    }

}