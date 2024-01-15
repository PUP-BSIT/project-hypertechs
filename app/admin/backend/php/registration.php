<?php
require "./common.php";
session_start();
connect_database();

$admin_table = "admin";
$admin_number_col = "admin_number";
$password_col = "password";

$contact_table = "admin_contact";
$phone_number_col = "phone_number";
$address_col = "address";
$email_col = "email";

$name_table = "admin_name";
$surname_col = "surname";
$first_name_col = "first_name";
$middle_name_col = "middle_name";
$suffix_col = "suffix";

$birth_table = "admin_birthdate";
$birth_col = "birth_date";

$response['success'] = false;
$admin_number = "1899" . random_int(12345678, 87654321);
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$surname = $_POST['surname'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$birth = $_POST['birth_date'];
$address = $_POST['address'];
$email = $_POST['email'];
$suffix = $_POST['suffix'];

$sql = "INSERT INTO $admin_table(
        $admin_number_col, 
        $password_col, 
        $surname_col, 
        $first_name_col, 
        $middle_name_col,
        $suffix_col,
        $phone_number_col, 
        $address_col, 
        $email_col,
        $birth_col
) VALUES(
        '$admin_number', 
        '$password',
        '$surname', 
        '$first_name',
        '$middle_name',
        '$suffix',
        '$phone_number', 
        '$address',
        '$email',
        '$birth'
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
