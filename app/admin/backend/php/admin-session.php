<?php
session_start();
$response['success'] = false;
if (!isset($_SESSION['admin_number'])) {
        echo json_encode($response);
        exit;
}
$response['adminNumber'] = $_SESSION['admin_number'];
$response['success'] = true;
echo json_encode($response);
?>
