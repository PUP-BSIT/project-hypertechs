<?php
require "./common.php";

session_start();
connect_database();
$admin_number = $_POST["admin_number"];
$password = $_POST["password"];
$response['success'] = false;
if (!does_admin_exist($admin_number)) {
        $response['errorMessage'] = "admin not found";
        echo json_encode($response);
        exit;
}
if (!does_password_match($admin_number, $password)) {
        $response['errorMessage'] = "Password is incorrect";
        echo json_encode($response);
        exit;
}
$phone_number = get_phone_number($admin_number);
if (!$phone_number) {
        echo json_encode($response);
        exit;
}
$_SESSION['phone_number'] = $phone_number;
$response['phone'] = $phone_number;
$response['success'] = true;
close_database();
echo json_encode($response);
?>
