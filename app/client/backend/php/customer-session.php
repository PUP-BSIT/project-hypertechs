<?php
session_start();
$response['success'] = false;
if (!isset($_SESSION['account_number'])) {
        echo json_encode($response);
        exit;
}
$response['accountNumber'] = $_SESSION['account_number'];
$response['success'] = true;
echo json_encode($response);
?>
