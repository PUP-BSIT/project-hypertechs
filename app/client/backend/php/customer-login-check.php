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
$response['success'] = true;
close_database();
echo json_encode($response);
?>
