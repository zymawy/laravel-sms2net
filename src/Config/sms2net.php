<?php
/**
 * Created by PhpStorm.
 * User: ironside
 * Date: 12/24/18
 * Time: 8:53 PM
 */

return [
    'userName' => env('SMS2NET_USERNAME'),
    'password' => env('SMS2NET_PASSWORD'),
    'Unicode' => env('SMS2NET_UNICODE'),
    'sender' => env('SMS2NET_SENDER'),
    'SMSDateTime' => null,  // Optional Max 30 Date and Time Desired deferred delivery date and Time
    'SMSGateway' => null, // Optional Max 1 Integer Routing specification
    'SmsRef' => null, // Optional Max 20 String Id Reference sent by the user
    'SMSTest' => env('SMS2NET_IS_TEST',1), // Determine Wither You Are In Development Mode Or Production Mode
];