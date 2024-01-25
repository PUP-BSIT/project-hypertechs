<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer_external_send";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$bank_code_col = "bank_code";
$date_col = "date";
$time_col = "time";

$parameters_complete = isset($_POST['redirect_url']) && 
        isset($_POST['transaction_amount']) && 
        isset($_POST['source_account_no']) && 
        isset($_POST['recipient_account_no']) && 
        isset($_POST['recipient_bank_code']);
if (!$parameters_complete) {
        $response['success'] = false;
        $response['errorMessage'] = "Some parameters are missing.";
        echo json_encode($response);
        exit;
}
$redirect_url = $_POST['redirect_url'];
/*
$amount = $_POST['transaction_amount'];
*/
$amount = (float)$_POST['transaction_amount'];
$source = $_POST['source_account_no'];
$recipient = $_POST['recipient_account_no'];
$bank_code = $_POST['recipient_bank_code'];
date_default_timezone_set("Asia/Manila");
$date = date("Y-m-d");
$time = date("H:i");
$balance = get_balance($source);
$redirect_error = "/app/client/pages/account/fund_transfer_result.php";

$response['success'] = false;
if (!$balance) {
        close_database();
        $response['errorMessage'] = "Internal server error";
        echo json_encode($response);

        exit;
}
if ($amount > $balance) {
        close_database();
        $response['errorMessage'] = "The set amount exceeds account balance";
        echo json_encode($response);

        exit;
}

if ($recipient == $source) {
        close_database();
        $response['errorMessage'] = "The account number is not valid";
        echo json_encode($response);

        exit;
}
$response['success'] = true;
$response['accountName'] = "VRZN Bank Account"; 
close_database();
echo json_encode($response);
?>
