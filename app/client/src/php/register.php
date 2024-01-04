<?php
//backend for registration

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token");
    $conn = mysqli_connect("127.0.0.1:3306", "u754510873_apex_user", "tTKja:5~Kw", "u754510873_apex_DB");
    
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Check if connection is successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // SQL query to insert data into the database
        $sql = "INSERT INTO registration_table (surname, middle_name, first_name, suffix, birth_date, residential_address, email, phone_number, password )
        VALUES ('$surname', '$middle_name', '$first_name', '$suffix', '$birth_date', '$residential_address', '$email', '$phone_number', '$password' )";

        // Execute the SQL query
        if (!mysqli_query($conn, $sql)) return;

        echo "Registration Successful!";

        // Close the database connection
        mysqli_close($conn);
    }
?>
