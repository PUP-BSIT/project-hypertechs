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

$response['fundTransferSuccess'] = false;
$bank_code = $_POST['source_bank_code'];
$amount = (float)$_POST['transaction_amount'];
$source = (int)$_POST['source_account_no'];
$recipient = (int)$_POST['recipient_account_no'];
$transaction_id = "TID".time().uniqid();
$date = date("Y-m-d");
if ($recipient == $source) {
        http_response_code(403);
        echo json_encode($response);
        exit;
}
if (!does_account_exist($recipient)) {
        http_response_code(404);
        echo json_encode($response);
        exit();                
}
if (!does_bank_exist($bank_code)) {
        http_response_code(403);
        echo json_encode($response);
        exit();
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $date_col, 
        $bank_code_col) VALUES ($amount, '$source', '$recipient', 
        '$transaction_id', '$date', '$bank_code')"; 
if (!modify_database($sql_stmt)) {
        http_response_code(404);
        echo json_encode($response);
        exit(); 
}
$response['fundTransferSuccess'] = true;
$response['transactionID'] = $transaction_id; 
echo json_encode($response);
close_database();
?>
