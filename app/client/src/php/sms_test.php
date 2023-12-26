<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ch = curl_init();
$parameters = array(
    'apikey' => '7dce37931f1bbe6f1dc105d481d83ccf',
    'number' => '09274596753',
    'message' => 'This is another message from Apex Bank. I am testing the SMS endpoint.',
    'sendername' => 'SEMAPHORE'
);
curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/otp');
curl_setopt($ch, CURLOPT_POST, 1);

//Send the parameters set above with the request
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

// Receive response from server
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

//Show the server response
echo $output;
