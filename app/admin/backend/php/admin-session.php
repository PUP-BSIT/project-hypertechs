<?php
session_start();
$response['success'] = false;
if (!isset($_SESSION['admin_id'])) {
        echo json_encode($response);
        exit;
}
$response['adminId'] = $_SESSION['admin_id'];
$response['success'] = true;
echo json_encode($response);
?>
