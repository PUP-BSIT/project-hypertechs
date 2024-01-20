<?php
require "./common.php";

connect_database();
session_start();
$account_table = "account";
$account_number_col = "account_number";
$name_col = "account_name";
$balance_col = "balance";
$first_name_col = "first_name";
$creation_date_col = "creation_date";

$response['success'] = false;
$account_number = $_SESSION['account_number'];
$result = get_account_data($account_table, $account_number);
if (!$result) {
        echo json_encode($response);
        exit;
}
$name = get_name($account_number);
if (!$name) {
        echo json_encode($response);
        exit;
}
$lastTransac = get_last_transaction_date($account_number);
/*
if (!$lastTransac) {
        echo json_encode($response);
        exit;
}
*/
$response['data'] = array(
        'accountNumber' => $result[$account_number_col],
        'name' => $name,
        'balance' => $result[$balance_col],
        'firstName' => $result[$first_name_col],
        'lastTransac' => $lastTransac
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
