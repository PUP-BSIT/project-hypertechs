<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Retrieve user data from the AJAX request
$userData = json_decode($_POST['user_data'], true);

// Insert user data into the database
$sql = "INSERT INTO registration_table (surname, middle_name, first_name, suffix, birth_date, residential_address, email, phone_number, password)
        VALUES ('{$userData['surname']}', '{$userData['middle_name']}', '{$userData['first_name']}', '{$userData['suffix']}', '{$userData['birth_date']}', '{$userData['residential_address']}', '{$userData['email']}', '{$userData['phone_number']}', '{$userData['password']}')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
