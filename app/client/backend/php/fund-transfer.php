<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$date_col = "date";

$response['fundTransferSuccess'] = false;
$redirect_url = $_POST['redirect_url'];
$amount = (float)$_POST['transaction_amount'];
$source = (int)$_POST['source_account_no'];
$recipient = (int)$_POST['recipient_account_no'];
$transaction_id = "TID" . time() . uniqid ();
$date = date ("Y-m-d");
http_response_code(302);
if ($recipient == $source) {
        $response['url'] = "$redirect_url" . "?error_message=Account number is not valid";
        echo json_encode($response);
        exit;
}
if (!does_account_exist($recipient)) {
        $response['url'] = "$redirect_url" . "?error_message=Account does not exist";
        echo json_encode($response);
        exit;
}
if (!deduct_balance($source, $amount)) {
        $response['url'] = "$redirect_url" . "?error_message=Internal server error";
        echo json_encode($response);
        exit;
}
if (!add_balance($recipient, $amount)) {
        $response['url'] = "$redirect_url" . "?error_message=Internal server error";
        echo json_encode($response);
        exit;
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $date_col) 
        VALUES ($amount, '$source', '$recipient', '$transaction_id', '$date')"; 
if (!modify_database($sql_stmt)) {
        http_response_code(403);
        echo json_encode($response);
        exit;
} 
$response['url'] = "$redirect_url" . "?fund_transfer_success=true&" .
        "transaction_id=" . $transaction_id;
close_database();
echo json_encode($response);
?>
