<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer_external_send";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$date_col = "date";
$bank_code_col = "bank_code";

$response['fundTransferSuccess'] = false;
$redirect_url = $_POST['redirect_url'];
$bank_code = $_POST['recipient_bank_code'];
$amount = (float)$_POST['transaction_amount'];
$source = (int)$_POST['source_account_no'];
$recipient = (int)$_POST['recipient_account_no'];
$transaction_id = "TID" . time() . uniqid();
// $transaction_id = $_POST['transaction_id'];
$date = date ("Y-m-d");
// ob_start();
if ($recipient == $source) {
        http_response_code(403);
        echo json_encode($response);
        exit;
}
if (!deduct_balance($source, $amount)) {
        http_response_code(404);
        echo json_encode($response);
        exit;
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $date_col,
        $bank_code_col) VALUES ($amount, '$source', '$recipient', 
        '$transaction_id', '$date', '$bank_code')"; 
if (!modify_database($sql_stmt)) {
        http_response_code(403);
        echo json_encode($response);
        exit;
}
http_response_code(302);
$response['url'] = $redirect_url . "?fund_transfer_success=true&" .
        "transaction_id=" . $transaction_id;
close_database();
echo json_encode($response);
?>
