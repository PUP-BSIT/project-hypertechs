<?php
require "./common.php";
session_start();
connect_database();
$email = $_POST["email"];
$password = $_POST["password"];
$redirect_url = $_POST['redirect_url'];
$admin_number = get_admin_number($email);
$_SESSION['admin_number'] = $admin_number;
http_response_code(302);
$response['url'] = $redirect_url;
$response['success'] = true;
close_database();
echo json_encode($response);
exit;
?>
