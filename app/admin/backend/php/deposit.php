<?php
require "./common.php";

connect_database();
$deposit_table = "deposit";
$amount_col = "amount";
$account_holder = "recipient";
$transaction_id_col = "transaction_id";
$date_col = "date";

$redirect_url = $_POST['redirect_url'];
$amount = (float)$_POST['transaction_amount'];
$recipient = (int)$_POST['recipient_account_no'];
$transaction_id = "TID" . time() . uniqid ();
$date = date ("Y-m-d");
http_response_code(302);

if (!does_account_exist($recipient)) {
        $response['url'] = "$redirect_url" . "?error_message=account does not exist";
        echo json_encode($response);
        exit;
}

if (!add_balance($recipient, $amount)) {
        $response['url'] = "$redirect_url" . "?error_message=Internal server error";
        echo json_encode($response);
        exit;
}
$sql_stmt = "INSERT INTO $deposit_table ($amount_col, $account_holder, $transaction_id_col, $date_col) 
        VALUES ($amount, '$recipient', '$transaction_id', '$date')"; 
if (!modify_database($sql_stmt)) {
        http_response_code(403);
        echo json_encode($response);
        exit;
} 

close_database();
echo json_encode($response);
?>
