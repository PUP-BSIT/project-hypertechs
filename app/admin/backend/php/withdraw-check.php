<?php
require "./common.php";

connect_database();
$withdraw_table = "withdraw";
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
        $response['errorMessage'] = "Account does not exist.";
        $response['accountBalance'] = "[The account does not exist]";
        close_database();
        echo json_encode($response);
        exit;
}

$current_balance = get_balance($account_number);
$response['accountBalance'] = $current_balance;
if (!$current_balance) {
        $response['errorMessage'] = "Insufficient balance.";
        $response['accountBalance'] = "[Internal server error]";
        close_database();
        echo json_encode($response);
        exit;
}
if ($current_balance < $amount) {
        $response['errorMessage'] = "Insufficient balance.";
        close_database();
        echo json_encode($response);
        exit;
}
$response['success'] = true;
$response['accountName'] = get_account_name($account_number);
close_database();
echo json_encode($response);
?>
