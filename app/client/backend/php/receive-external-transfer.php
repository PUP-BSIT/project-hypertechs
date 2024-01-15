<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer_external_receive";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$date_col = "date";
$bank_code_col = "bank_code";

$parameters_complete = isset($_POST['source_bank_code']) && 
        isset($_POST['transaction_amount']) && 
        isset($_POST['source_account_no']) && 
        isset($_POST['recipient_account_no']);
if (!$parameters_complete) {
        close_database();
        http_response_code(403);
        exit;
}
$bank_code = $_POST['source_bank_code'];
$amount = (float)$_POST['transaction_amount'];
$source = $_POST['source_account_no'];
$recipient = $_POST['recipient_account_no'];
$transaction_id = "TID" . random_int(10000000, 99999999) . date("Ymd");
$date = date("Y-m-d");
if ($recipient == $source) {
        close_database();
        http_response_code(403);
        exit;
}
if (!does_account_exist($recipient)) {
        close_database();
        http_response_code(404);
        exit();                
}
if (!does_bank_exist($bank_code)) {
        close_database();
        http_response_code(403);
        exit();
}
if (!add_balance($recipient, $amount)) {
        close_database();
        http_response_code(403);
        exit;
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $date_col, 
        $bank_code_col) VALUES ($amount, '$source', '$recipient', 
        '$transaction_id', '$date', '$bank_code')"; 
if (!modify_database($sql_stmt)) {
        close_database();
        http_response_code(404);
        exit(); 
}
close_database();
$response['fund_transfer_success'] = true;
$response['transaction_id'] = $transaction_id; 
echo json_encode($response);
?>
