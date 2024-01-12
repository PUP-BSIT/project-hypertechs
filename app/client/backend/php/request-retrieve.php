<?php
session_start();
$response['success'] = false;
if (!isset($_SESSION['request_url']) || !isset($_SESSION['request_body'])) { 
        echo json_encode($response);
        exit;
}
$response['requestURL'] = $_SESSION['request_url']; 
$response['requestBody'] = $_SESSION['request_body'];
$response['success'] = true;
echo json_encode($response);
?>
