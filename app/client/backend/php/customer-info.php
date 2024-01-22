<?php
require "./common.php";

$PAST_DAYS = 7;

connect_database();
session_start();
$account_table = "account";
$account_number_col = "account_number";
$name_col = "account_name";
$balance_col = "balance";
$first_name_col = "first_name";
$creation_date_col = "creation_date";
$card_number_col = "card_number";
$card_expiration_col = "card_expiration_date";
$cvv_col = "cvv";

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
$card_expiration = date("m-Y", $result['card_expf']);
$response['data'] = array(
        'accountNumber' => $result[$account_number_col],
        'name' => $name,
        'balance' => $result[$balance_col],
        'firstName' => $result[$first_name_col],
        'lastTransac' => $lastTransac,
        'totalTransac' => get_total_num_of_transac($PAST_DAYS, $account_number),
        'totalTransferred' => get_total_amount_transferred($PAST_DAYS, 
                $account_number),
        'totalReceived' => get_total_amount_received($PAST_DAYS, 
                $account_number),
        'averageTransferred' => get_average_amount_transferred($PAST_DAYS, 
                $account_number),
        'cardNumber' => $result[$card_number_col],
        'cardExpiration' => $card_expiration,
        'cvv' => $result[$cvv_col]
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
