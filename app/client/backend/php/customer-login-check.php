<?php
require "./common.php";

session_start();
connect_database();
$account_number = $_POST["account_number"];
$password = $_POST["password"];
$response['success'] = false;
if (!does_account_exist($account_number)) {
        $response['errorMessage'] = "Account not found";
        echo json_encode($response);
        exit;
}
if (!does_password_match($account_number, $password)) {
        $response['errorMessage'] = "Password is incorrect";
        echo json_encode($response);
        exit;
}
$phone_number = get_phone_number($account_number);
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
