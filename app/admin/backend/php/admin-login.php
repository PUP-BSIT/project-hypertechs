<?php
require "./common.php";
session_start();
connect_database();
$email = $_POST["email"];
$password = $_POST["password"];
$redirect_url = $_POST['redirect_url'];
$admin_id = get_admin_id($email);
close_database();
$_SESSION['admin_id'] = $admin_id;
http_response_code(302);
$response['location'] = $redirect_url;
echo json_encode($response);
exit;
?>
