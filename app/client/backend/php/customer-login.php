<?php
require "./common.php";

connect_database();
$account_number = $_POST["account_number"];
$password = $_POST["password"];
$redirect_url = $_POST['redirect_url'];
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
$phone_number = get_phone_number($account_number);
if (!$phone_number) {
        echo json_encode($response);
        exit;
}
$_SESSION['phone_number'] = $phone_number;
http_response_code(302);
$response['url'] = $redirect_url;
$response['success'] = true;
close_database();
echo json_encode($response);
exit;
?>
