<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start the session
session_start();

// Retrieve user data from the session
$registrationData = $_SESSION['registration_data'];

// Retrieve the entered OTP
$enteredOTP = $_POST['otp'];
// Get the OTP sent by Semaphore (you need to implement this part)
$semaphoreOTP = $registrationData['generated_otp'];

echo "Entered OTP: $enteredOTP\n";
echo "Semaphore OTP: $semaphoreOTP\n";

// Assuming you have a database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Compare entered OTP with Semaphore OTP
if ($enteredOTP === $semaphoreOTP) {
    include '/app/client/src/php/insert_data.php';
    echo "Registration and OTP verification successful!";
} else {
    // Display error message or perform any other actions as needed
    echo "Invalid OTP";
}

// Close the database connection
$conn->close();
