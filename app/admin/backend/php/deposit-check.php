<?php
require "./common.php";

connect_database();
$deposit_table = "deposit";
$amount_col = "amount";
$account_col = "account_number";
$admin_col = "admin_id";
$transaction_id_col = "transaction_id";
$date_col = "date";
$time_col = "time";

$amount = (float)$_POST['amount'];
$account_number = $_POST['account_number'];
$admin_id = $_POST['admin_id'];
$transaction_id = "TID" . time() . uniqid ();
$date = date("Y-m-d");
$time = date("H:i:s");

$response['success'] = false;
if (!does_account_exist($account_number)) {
        $response['accountBalance'] = "[The account does not exist]";
        $response['errorMessage'] = "Account does not exist.";
        echo json_encode($response);
        exit;
}
$response['accountBalance'] = get_balance($account_number);
if (!$response['accountBalance']) {
        $response['accountBalance'] = "[The account does not exist]";
        $response['errorMessage'] = "Internal server error.";
        echo json_encode($response);
        exit;
}
$response['success'] = true;
$response['accountName'] = get_account_name($account_number);
close_database();
echo json_encode($response);
?>
