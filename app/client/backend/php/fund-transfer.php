<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$date_col = "date";

$redirect_url = $_POST['redirect_url'];
$amount = (float)$_POST['transaction_amount'];
$source = $_POST['source_account_no'];
$recipient = $_POST['recipient_account_no'];
$transaction_id = "TID" . random_int(10000000, 99999999) . date("Ymd");
$date = date ("Y-m-d");
$balance = get_balance($source);
if (!$balance) {
        close_database();
        header("Location: " . "$redirect_url" . 
                "?error_message=Internal server error");
        exit;
}
if ($amount > $balance) {
        close_database();
        header("Location: " . "$redirect_url" . 
                "?error_message=The set amount exceeds account balance");
        exit;
}

if ($recipient == $source) {
        close_database();
        header("Location: " . "$redirect_url" . 
                "?error_message=The account number is not valid");
        exit;
}
if (!does_account_exist($recipient)) {
        close_database();
        header("Location: " . "$redirect_url" . 
                "?error_message=The account does not exist");
        exit;
}
if (!deduct_balance($source, $amount)) {
        close_database();
        header("Location: " . "$redirect_url" . 
                "?error_message=Internal server error");
        exit;
}
if (!add_balance($recipient, $amount)) {
        close_database();
        header("Location: " . "$redirect_url" . 
                "?error_message=Internal server error");
        exit;
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $date_col) 
        VALUES ($amount, '$source', '$recipient', '$transaction_id', '$date')"; 
if (!modify_database($sql_stmt)) {
        close_database();
        header("Location: " . "$redirect_url" . 
                "?error_message=Internal server error");
        exit;
} 
close_database();
header("Location: " . "$redirect_url" . "?fund_transfer_success=true&" .
        "transaction_id=" . $transaction_id);
exit;
?>
