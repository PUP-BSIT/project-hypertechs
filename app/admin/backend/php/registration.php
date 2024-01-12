<?php
require "./common.php";
session_start();

$admin_table = "admin";
$admin_number_col = "admin_number";
$name_col = "admin_name";
$password_col = "password";
$phone_number_col = "phone_number";

$response['success'] = false;
$admin_number = "1899" . random_int(12345678, 87654321);
$name = $_POST['first_name'] . " " . $_POST['last_name']; 
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];

connect_database();
$sql = "INSERT INTO $admin_table(
                $admin_number_col, 
                $name_col, 
                $phone_number_col, 
                $password_col
        ) VALUES(
                '$admin_number', 
                '$name', 
                '$phone_number', 
                '$password'
        )";
if (!modify_database($sql)) {
        echo json_encode($response);
        exit;
}
$_SESSION['admin_number'] = $admin_number;
close_database();
http_response_code(302);
$response['url'] = "./welcome.html";
$response['success'] = true;
echo json_encode($response);
?>
