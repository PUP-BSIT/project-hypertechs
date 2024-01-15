<?php
require "./common.php";
session_start();
connect_database();
$response['success'] = false;
if(does_email_exist($_POST['email'])) {
        $response['errorMessage'] = "Your email is already used by other " .
                "account";
        echo json_encode($response);
        exit;
}
if(does_phone_number_exist($_POST['phone_number'])) {
        $response['errorMessage'] = "Your phone number is already used by " .
                "other account";
        echo json_encode($response);
        exit;
}
$_SESSION['phone_number'] = $_POST['phone_number'];
$response['success'] = true;
close_database();
echo json_encode($response);
?>
