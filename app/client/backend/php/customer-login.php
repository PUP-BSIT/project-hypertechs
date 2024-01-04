<?php
require "./common.php";

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
session_start();
$_SESSION['account_number'] = $account_number;
$response['success'] = true;
echo json_encode($response);
close_database();
?>
