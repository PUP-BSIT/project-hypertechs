<?php
require "./common.php";
session_start();
connect_database();
$email = $_POST["email"];
$password = $_POST["password"];
$redirect_url = $_POST['redirect_url'];
$account_number = get_account_number($email);
$_SESSION['account_number'] = $account_number;
http_response_code(302);
$response['url'] = $redirect_url;
$response['success'] = true;
close_database();
echo json_encode($response);
exit;
?>
