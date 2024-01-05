<?php
session_start();

if (isset($_POST['destroy'])) {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
        exit;
}
$response['hasExpired'] = false;
if (!isset($_SESSION['otp'])) {
        echo json_encode($response);
        exit;
}
if (($_SESSION['otp_time'] - time()) > 0) {
        echo json_encode($response);
        exit;
}
$response['hasExpired'] = true;
echo json_encode($response);
?>
