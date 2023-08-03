<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AwsSmsService;
// use AWS;
// use Aws\Laravel\AwsFacade as AWS; // Import the AWS facade with an alias

class SNSController extends Controller
{
  // protected $awsSmsService;

  // public function __construct(AwsSmsService $awsSmsService)
  // {
  //   $this->awsSmsService = $awsSmsService;
  // }

  public function sendSMS()
  {
    // $phoneNumber = '+60132911366'; // Replace with the recipient's phone number
    // $message = 'This is a test SMS sent from Laravel using AWS SNS.';

    // $result = $this->awsSmsService->sendSms($phoneNumber, $message);
    $params = [
      'Message' => 'Hello from AWS SNS!',
      // The message you want to send
      'PhoneNumber' => '+60132911366', // Replace with the recipient's phone number in E.164 format
    ];
    $sns = \Illuminate\Support\Facades\App::make('aws')->createClient('sns');
    $result = $sns->publish($params);

    // Handle the result or send a response
     return response()->json(['result' => $result]);
  }
  // public function sendSMS()
  // {
  //   // $sns = AWS::createClient('sns');

  //   // $args = array(
  //   //   "MessageAttributes" => [
  //   //     'AWS.SNS.SMS.SMSType' => [
  //   //       'DataType' => 'String',
  //   //       'StringValue' => 'Transactional',
  //   //     ]
  //   //   ],
  //   //   "Message" => "Your message text",
  //   //   // set your sms text here
  //   //   "PhoneNumber" => "+60132911366" // set phone number here
  //   // );



  //   // $result = $sns->publish($args);

  //   // // return result
  //   // return $result;
  //   return response()->json(['message' => 'Controller method executed successfully.']);
  // }
}