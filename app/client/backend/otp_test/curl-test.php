<?php
/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts/1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);
echo $output;
exit;
$data = json_decode($output, true);
echo $data['title'];
*/

$ch = curl_init();
$parameters = array(
        'apikey' => "7dce37931f1bbe6f1dc105d481d83ccf",
        'number' => "09550266782",
        'message' => "This is a sample message. Your One Time Password is: " . 
                "{otp}. Thank you for using Apex Bank!"
);
curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/otp');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
curl_close($ch);
echo $output;
$data = json_decode($output, true);
?>
