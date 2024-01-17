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
$time = date("h:i");

$response['success'] = false;
if (!does_account_exist($account_number)) {
        $response['errorMessage'] = "Account does not exist";
        echo json_encode($response);
        exit;
}

if (!deduct_balance($account_number, $amount)) {
        $response['errorMessage'] = "Something went wrong";
        echo json_encode($response);
        exit;
}
$sql_stmt = "INSERT INTO $withdraw_table ($transaction_id_col, $admin_col, 
        $amount_col,  $account_col, $date_col, $time_col) 
        VALUES ('$transaction_id', '$admin_id', $amount, '$account_number',
        '$date', '$time')"; 
if (!modify_database($sql_stmt)) {
        $response['errorMessage'] = "Something went wrong";
        echo json_encode($response);
        exit;
} 
close_database();
$response['success'] = true;
echo json_encode($response);
?>
