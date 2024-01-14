<?php
session_start();

$response['success'] = false;
if (!isset($_POST['request_url']) || !isset($_POST['request_body'])) {
        http_response_code(302);
        $response['url'] = "./internal_error.html"; 
        echo json_encode($response);
        exit;
}
$_SESSION['request_url'] = $_POST['request_url'];
$_SESSION['request_body'] = $_POST['request_body'];
$response['success'] = true;
echo json_encode($response);
?>
