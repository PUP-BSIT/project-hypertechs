<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$date_col = "date";
$time_col = "time";
$description_col = "description";

$redirect_url = $_POST['redirect_url'];
$amount = (float)$_POST['transaction_amount'];
$source = $_POST['source_account_no'];
$recipient = $_POST['recipient_account_no'];
$description = $_POST['description'];
$transaction_id = "TID" . random_int(10000000, 99999999) . date("Ymd");
date_default_timezone_set("Asia/Manila");
$date = date("Y-m-d");
$time = date("H:i");
$balance = get_balance($source);
$redirect_error = "/app/client/pages/account/fund_transfer_result.php";

$response['success'] = false;
if (!does_account_exist($recipient)) {
        close_database();
        $response['errorMessage'] = "The account does not exist";
        echo json_encode($response);
        exit;
}
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
$response['accountName'] = get_name($recipient); 
close_database();
echo json_encode($response);
exit;
?>
