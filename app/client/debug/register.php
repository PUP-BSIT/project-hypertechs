<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start a session
session_start();

// Retrieve form data
$surname = $_POST['surname'];
$middle_name = $_POST['middle_name'];
$first_name = $_POST['first_name'];
$suffix = $_POST['suffix'];
$birth_date = $_POST['dob'];
$residential_address = $_POST['residential_address'];
$email = $_POST['email'];
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];

// Store form data in session
$_SESSION['registration_data'] = [
    'surname' => $surname,
    'middle_name' => $middle_name,
    'first_name' => $first_name,
    'suffix' => $suffix,
    'birth_date' => $birth_date,
    'residential_address' => $residential_address,
    'email' => $email,
    'phone_number' => $phone_number,
    'password' => $password,
    'generated_otp' => $otpCode
];

// Set up Semaphore OTP API parameters
$apiKey = "7dce37931f1bbe6f1dc105d481d83ccf"; // Replace with your actual Semaphore API key
$otpMessage = "Your One Time Password is: {otp}. Thank you for using Apex Bank!";
$otpApiUrl = "https://api.semaphore.co/api/v4/otp";

// Set up curl options
$curl = curl_init($otpApiUrl);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, "apikey=$apiKey&number=$phone_number&message=$otpMessage");

// Execute curl and capture the response
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($curl);

// Close curl connection
curl_close($curl);

// Process the response (you may want to add error handling here)
$responseData = json_decode($response, true);
$otpCode = $responseData[0]['code'];

// Store the received OTP in the session
$_SESSION['generated_otp'] = $otpCode;

// Redirect to the OTP verification page
header("Location: /app/client/pages/otp.php");
exit();
?>
