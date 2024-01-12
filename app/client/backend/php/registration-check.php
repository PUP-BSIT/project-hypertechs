<?php
require "./common.php";
session_start();
/*
        Might be useful for server-side validation
*/
$_SESSION['phone_number'] = $_POST['phone_number'];
$response['success'] = true;
echo json_encode($response);
?>
