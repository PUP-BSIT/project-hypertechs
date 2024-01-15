<?php
require "./common.php";

$DURATION_SEC = 5 * 60;

session_start();
$response['success'] = false;
$response['expired'] = false;
if (isset($_POST['phone_number'])) {
        $_SESSION['forgotpass_phone'] = $_POST['phone_number'];
        $_SESSION['forgotpass_time'] = time() + $DURATION_SEC;
        http_response_code(302);
        $response['location'] = "/app/client/pages/reset_pass.html";
        echo json_encode($response);
        exit;
}
if (!isset($_SESSION['forgotpass_phone'])) {
        $response['expired'] = true;
        $response['errorMessage'] = "Session for password reset has expired. " .
                "Please repeat the password reset procedure.";
        echo json_encode($response);
        exit;
}
if (($_SESSION['forgotpass_time'] - time()) < 0) {
        unset($_SESSION['forgotpass_phone']);
        unset($_SESSION['forgotpass_time']);
        $response['expired'] = true;
        $response['errorMessage'] = "Session for password reset has expired. " .
                "Please repeat the password reset procedure.";
        echo json_encode($response);
        exit;
}
connect_database();
$password = $_POST['password'];
$phone_number = $_SESSION['forgotpass_phone'];
$account_number = get_account_number_via_phone($phone_number);
if (!$account_number) {
        close_database();
        echo json_encode($response);
        exit;
}
$old_password = get_password($account_number);
if (!$old_password) {
        close_database();
        echo json_encode($response);
        exit;
}
if ($old_password === $password) {
        close_database();
        $response['errorMessage'] = "This password was used before and " .
                "cannot be reused.";
        echo json_encode($response);
        exit;
}
if (!change_pass_via_phone($_SESSION['forgotpass_phone'], $password)) {
        close_database();
        echo json_encode($response);
        exit;
}
$_SESSION['account_number'] = $account_number;
close_database();
unset($_SESSION['forgotpass_phone']);
unset($_SESSION['forgotpass_time']);
$response['success'] = true;
echo json_encode($response);
?>
