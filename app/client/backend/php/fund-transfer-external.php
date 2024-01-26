<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer_external_send";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$bank_code_col = "bank_code";
$date_col = "date";
$time_col = "time";

$parameters_complete = isset($_POST['redirect_url']) && 
        isset($_POST['transaction_amount']) && 
        isset($_POST['source_account_no']) && 
        isset($_POST['recipient_account_no']) && 
        isset($_POST['recipient_bank_code']);
if (!$parameters_complete) {
        $response['success'] = false;
        $response['errorMessage'] = "Some parameters are missing.";
        echo json_encode($response);
        exit;
}
$redirect_url = $_POST['redirect_url'];
/*
$amount = $_POST['transaction_amount'];
*/
$amount = (float)$_POST['transaction_amount'];
$source = $_POST['source_account_no'];
$recipient = $_POST['recipient_account_no'];
$bank_code = $_POST['recipient_bank_code'];
date_default_timezone_set("Asia/Manila");
$date = date("Y-m-d");
$time = date("H:i");
$balance = get_balance($source);
$redirect_error = "/app/client/pages/account/fund_transfer_result.php";
if (!$balance) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error . 
                "?error_message=Internal server error";
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
/*
$bank_api_url = get_bank_api_url($bank_code);
$bank_api_url = "http://localhost/app/client/backend/php/" . 
        "receive-external-transfer.php";
$bank_api_url = "https://apexapp.tech/app/client/backend/php/" . 
        "receive-external-transfer.php";
*/
$bank_api_url = "https://projectvrzn.online/vrzn-bank/app/database/" .
                "receive-external-transfer.php";

if (!$bank_api_url) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_error . 
                "?error_message=Internal server error";
        echo json_encode($response);

        exit;
}
$request_body = array(
        'transaction_amount' => $amount,
        'source_account_no' => $source,
        'source_bank_code' => "APEX",
        'recipient_account_no' => $recipient
);

$api_response = post_data($bank_api_url, $request_body);
if (isset($api_response['status_code']) && $api_response['status_code'] != 200) {
        close_database();
        $error_message = get_error_message($api_response['status_code']);
        http_response_code(302);
        $response['location'] = $redirect_error . 
                "?error_message=$error_message";
        $response['api_response'] = $api_response;
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
$transaction_id = $api_response['transaction_id'];
if (!$transaction_id) {
        $transaction_id = "TID" . random_int(10000000, 99999999) . date("Ymd");
}
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $date_col, $time_col, 
        $bank_code_col) 
        VALUES ($amount, '$source', '$recipient', 
        '$transaction_id', '$date', '$time', '$bank_code')"; 
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
$response['api_response'] = $api_response;
echo json_encode($response);
exit;

function post_data($url, $body) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($body));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
/*
        if ($status_code != 200) {
                $data['status_code'] = $status_code;
                return $data;
        }
*/
        $data = json_decode($response, true);
        $data['status_code'] = $status_code;
        return $data;
}

function get_error_message($status_code) {
        switch ($status_code) {
        case 400:
                return "Bad Request";
                break;
        case 401:
                return "Unauthorized";
                break;
        case 403:
                return "Forbidden";
                break;
        case 404:
                return "Account does not exist";
                break;
        case 405:
                return "Method Not Allowed";
                break;
        case 406:
                return "Not Acceptable";
                break;
        case 408:
                return "Request Timeout";
                break;
        case 409:
                return "Conflict";
                break;
        default:
                return "Something went wrong";
        }
}
?>
