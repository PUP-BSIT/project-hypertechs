<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ch = curl_init();
$parameters = array(
    'apikey' => '',
    'number' => '09274596753',
    'message' => 'Hello, this is a message from Apex Bank. Thank you for using our service!',
    'sendername' => 'SEMAPHORE'
);
curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
curl_setopt($ch, CURLOPT_POST, 1);

//Send the parameters set above with the request
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

// Receive response from server
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);

//Show the server response
echo $output;
