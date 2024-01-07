<?php
session_start();
if (isset($_POST['start'])) {
        $_SESSION['otp_session'] = true;
        $response['otp_session'] = $_SESSION['otp_session'];
        echo json_encode($response);
        exit;
}
if (isset($_POST['destroy'])) {
        unset($_SESSION['otp_session']);
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
        $response['otp'] = $_SESSION['otp'];
        echo json_encode($response);
        exit;
}
if (isset($_POST['destroy_otp'])) {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
        $response['otp'] = $_SESSION['otp'];
        echo json_encode($response);
        exit;
}

$response['hasSession'] = false;
if (!isset($_SESSION['otp_session'])) {
        echo json_encode($response);
        exit;
}
$response['hasSession'] = true;
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
