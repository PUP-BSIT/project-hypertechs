<?php
require "./common.php";

connect_database();
$transfer_table = "external_transfer_receive";
$amount_col = "amount_received";
$source_col = "sender_account_number";
$recipient_col = "account_number";
$transaction_id_col = "transaction_number";
$status_col = "status";
$date_col = "date_received";
$bank_code_col = "bank_code";

$response['fundTransferSuccess'] = false;
$bank_code = $_POST['source_bank_code'];
$amount = (float)$_POST['transaction_amount'];
$source = (int)$_POST['source_account_no'];
$recipient = (int)$_POST['recipient_account_no'];
$transaction_id = "TID".time().uniqid();
$status = "Pending";
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
        $recipient_col, $transaction_id_col, $status_col, $date_col, 
        $bank_code_col) VALUES ($amount, $source, $recipient, 
        '$transaction_id', '$status', '$date', '$bank_code')"; 
if (!modify_database($sql_stmt)) {
        http_response_code(404);
        echo json_encode($response);
        exit(); 
}
$response['fundTransferSuccess'] = true;
$response['transactionID'] = $transaction_id; 
close_database();
echo json_encode($response);
?>
