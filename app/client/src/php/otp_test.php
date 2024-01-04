<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Semaphore API endpoint
$apiEndpoint = 'https://api.semaphore.co/api/v4/otp';

// Replace 'YOUR_API_KEY' with your actual Semaphore API key
$apiKey = '7dce37931f1bbe6f1dc105d481d83ccf';

// Replace 'MOBILE_NUMBER' with the recipient's mobile number
$mobileNumber = '09690227888';

// Your message with the placeholder "{otp}"
$message = 'This is a sample message. Your One Time Password is: {otp}. 
Thank you for using Apex Bank!';

// Build the payload
$payload = [
    'apikey' => $apiKey,
    'number' => $mobileNumber,
    'message' => $message,
];

// Initialize cURL session
$ch = curl_init($apiEndpoint);

// Set cURL options
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL session
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Check if the response contains any errors
    if (isset($responseData['error'])) {
        echo 'Error: ' . $responseData['error']['message'];
    } else {
        // Output the response
        print_r($responseData);
    }
}

// Close cURL session
curl_close($ch);
