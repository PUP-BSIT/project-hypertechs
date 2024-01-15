<?php
session_start();
$request_url = $_GET['request_url'];
$request_body = $_GET['request_body'];
$phone_number = $_GET['phone_number'];
$_SESSION['request_url'] = $request_url;
$_SESSION['request_body'] = $request_body;
$_SESSION['otp_session'] = true;
$_SESSION['otp_phone'] = $phone_number;
//header("Location: https://apexapp.tech/app/client/pages/verify.html");
header("Location: /app/client/pages/verify.html");
?>
