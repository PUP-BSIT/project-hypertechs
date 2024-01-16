<?php
require "./common.php";

session_start();
connect_database();
$email = $_POST["email"];
$password = $_POST["password"];
$response['success'] = false;
if (!does_email_exist($email)) {
        $response['errorMessage'] = "Account not found. Please check your " .
        "account email.";
        echo json_encode($response);
        exit;
}
if (!does_password_match($email, $password)) {
        $response['errorMessage'] = "You entered an incorrect password.";
        echo json_encode($response);
        exit;
}
$phone_number = get_phone_number_via_email($email);
if (!$phone_number) {
        $response['errorMessage'] = "Your account does not have a " .
                "phone number.";
        echo json_encode($response);
        exit;
}
$_SESSION['otp_phone'] = $phone_number;
$response['phone'] = $phone_number;
$response['success'] = true;
close_database();
echo json_encode($response);
?>
