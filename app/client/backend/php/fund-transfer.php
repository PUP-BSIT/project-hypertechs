<?php
require "./common.php";

// Set the timezone to Manila
date_default_timezone_set('Asia/Manila');

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

if (!$balance) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error .  "?error_message=Internal server error";
        echo json_encode($response);
        exit;
}
if ($amount > $balance) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error .
                "?error_message=The set amount exceeds account balance";
        echo json_encode($response);

        exit;
}

if ($amount < 1) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error .
                "?error_message=The transfer amount cannot be less than 1 peso";
        echo json_encode($response);
        exit;
}

if ($recipient == $source) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error .
                "?error_message=The account number is not valid";
        echo json_encode($response);
        exit;
}
if (!does_account_exist($recipient)) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error .
                "?error_message=The account does not exist";
        echo json_encode($response);

        exit;
}
if (!deduct_balance($source, $amount)) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error .
                "?error_message=Internal server error";
        echo json_encode($response);

        exit;
}
if (!add_balance($recipient, $amount)) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error .
                "?error_message=Internal server error";
        echo json_encode($response);

        exit;
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
                $recipient_col, $transaction_id_col, $date_col, $time_col,
                $description_col) 
        VALUES ($amount, '$source', '$recipient', '$transaction_id', '$date', 
                '$time', '$description')"; 
if (!modify_database($sql_stmt)) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error . 
                "?error_message=Internal server error";
        echo json_encode($response);

        exit;
} 
close_database();
http_response_code(302);
$response['location'] = $redirect_url . "?fund_transfer_success=true&" .
        "transaction_id=" . $transaction_id;
echo json_encode($response);
exit;
?>
