<?php
session_start();
if (isset($_POST['otp_only'])) {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_time']);
}
unset($_SESSION['otp_session']);
unset($_SESSION['otp']);
unset($_SESSION['otp_time']);
$response['otp'] = $_SESSION['otp'];
echo json_encode($response);
?>
