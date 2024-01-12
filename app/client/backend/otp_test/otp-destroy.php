<?php
session_start();
unset($_SESSION['otp']);
unset($_SESSION['otp_time']);
$response['otp'] = $_SESSION['otp'];
echo json_encode($response);
?>
