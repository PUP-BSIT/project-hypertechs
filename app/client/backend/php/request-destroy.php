<?php
session_start();
unset($_SESSION['request_url']); 
unset($_SESSION['request_body']);
$response['success'] = true;
echo json_encode($response);
?>
