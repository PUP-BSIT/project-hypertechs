<?php
require "./common.php";

connect_database();
$admin_number = $_POST["admin_number"];
$password = $_POST["password"];
$redirect_url = $_POST['redirect_url'];
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
session_start();
$_SESSION['admin_number'] = $admin_number;
$phone_number = get_phone_number($admin_number);
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
