<?php
require "./common.php";

connect_database();
$phone_number = $_POST['phone_number'];
$response['success'] = false;
if (!does_phone_number_exist($phone_number)) {
        close_database();
        echo json_encode($response);
        exit;
}
$_SESSION['phone_number'] = $phone_number;
close_database();
$response['success'] = true;
echo json_encode($response);
?>
