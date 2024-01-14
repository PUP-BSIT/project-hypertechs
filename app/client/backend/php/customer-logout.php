<?php
session_start();

$ONE_DAY = 60*60*24;

unset($_SESSION['account_number']);
unset($_SESSION['phone_number']);
$params = session_get_cookie_params();
setcookie(session_name(), "", time() - $ONE_DAY, $params['path'], 
        $params['domain'], $params['secure'], $params['httponly']);
session_destroy();
$response['success'] = true;
echo json_encode($response);
?>
