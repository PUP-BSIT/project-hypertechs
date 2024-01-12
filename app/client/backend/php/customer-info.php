<?php
require "./common.php";

connect_database();
session_start();
/*
$account_table = "bank_account_holder";
$account_number_col = "account_number";
$name_col = "account_name";
$balance_col = "balance";
*/
$account_table = "account";
$account_number_col = "account_number";
$name_col = "account_name";
$balance_col = "balance";

$response['success'] = false;
$account_number = $_SESSION['account_number'];
$result = get_account_data($account_table, $account_number);
if (!$result) {
        echo json_encode($response);
        exit;
}
$name = get_name($account_number);
if(!$name) {
        echo json_encode($response);
        exit;
}
$response['data'] = array(
        'accountNumber' => $result[$account_number_col],
        'name' => $name,
        'balance' => $result[$balance_col]
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
