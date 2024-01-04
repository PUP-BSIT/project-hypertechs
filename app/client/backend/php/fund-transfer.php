<?php
require "./common.php";

connect_database();
$transfer_table = "transfer_send";
$amount_col = "amount_sent";
$source_col = "account_number";
$recipient_col = "receiver_account_number";
$transaction_id_col = "transaction_number";
$status_col = "status";
$date_col = "date_sent";

$response['fundTransferSuccess'] = false;
$redirect_url = $_POST['redirect_url'];
$amount = (float)$_POST['transaction_amount'];
$source = (int)$_POST['source_account_no'];
$recipient = (int)$_POST['recipient_account_no'];
$transaction_id = "TID" . time() . uniqid ();
$status = "Pending";
$date = date ("Y-m-d");
if ($recipient == $source) {
        http_response_code(403);
        echo json_encode($response);
        exit;
}
if (!does_account_exist($recipient)) {
        http_response_code(404);
        echo json_encode($response);
        exit;
}
if (!deduct_balance($source, $amount)) {
        http_response_code(404);
        echo json_encode($response);
        exit;
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $status_col, $date_col) 
        VALUES ($amount, $source, $recipient, '$transaction_id', '$status', 
        '$date')"; 
if (!modify_database($sql_stmt)) {
        http_response_code(403);
        echo json_encode($response);
        exit;
} 
http_response_code(302);
$response['url'] = "$redirect_url" . "?fund_transfer_success=true&" .
        "transaction_id=" . $transaction_id;
echo json_encode($response);
close_database();
?>
