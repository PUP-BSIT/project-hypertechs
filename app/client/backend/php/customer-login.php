<?php
require "./common.php";
session_start();
connect_database();
$phone_number = $_POST["phone_number"];
$password = $_POST["password"];
$redirect_url = $_POST['redirect_url'];
$account_number = get_account_number_via_phone($phone_number);
close_database();
$_SESSION['account_number'] = $account_number;
http_response_code(302);
$response['location'] = $redirect_url;
echo json_encode($response);
exit;
?>
