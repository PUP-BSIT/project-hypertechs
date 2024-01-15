<?php
require "./common.php";

connect_database();
$transfer_table = "fund_transfer_external_send";
$amount_col = "amount";
$source_col = "source";
$recipient_col = "recipient";
$transaction_id_col = "transaction_id";
$date_col = "date";

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
$amount = (float)$_POST['transaction_amount'];
$source = $_POST['source_account_no'];
$recipient = $_POST['recipient_account_no'];
$bank_code = $_POST['recipient_bank_code'];
$date = date ("Y-m-d");
$balance = get_balance($source);
if (!$balance) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_url . 
                "?error_message=Internal server error";
        echo json_encode($response);

        exit;
}
if ($amount > $balance) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_url . 
                "?error_message=The set amount exceeds account balance";
        echo json_encode($response);

        exit;
}

if ($recipient == $source) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_url . 
                "?error_message=The account number is not valid";
        echo json_encode($response);

        exit;
}
//$bank_api_url = get_bank_api_url($bank_code);
$bank_api_url = "http://localhost/app/client/backend/php/receive-external-transfer.php";
if (!$bank_api_url) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_url . 
                "?error_message=Internal server error";
        echo json_encode($response);

        exit;
}
$request_body = array(
        'transaction_amount' => $amount,
        'source_account_no' => $source,
        'source_bank_code' => "VRZN",
        'recipient_account_no' => $recipient
);

$response = post_data($bank_api_url, $request_body);
if (isset($response['status_code']) && $response['status_code'] != 200) {
        close_database();
        $error_message = get_error_message($response['status_code']);
        http_response_code(302);
        $response['location'] = $redirect_url . 
                "?error_message=$error_message";
        echo json_encode($response);

        exit;
}
if (!deduct_balance($source, $amount)) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_url . 
                "?error_message=Internal server error";
        echo json_encode($response);
        exit;
}
$transaction_id = $response['transaction_id'];
$sql_stmt = "INSERT INTO $transfer_table ($amount_col, $source_col, 
        $recipient_col, $transaction_id_col, $date_col) 
        VALUES ($amount, '$source', '$recipient', 
        '$transaction_id', '$date')"; 
if (!modify_database($sql_stmt)) {
        close_database();
        http_response_code(302);
        $response['location'] = $redirect_url . 
                "?error_message=Internal server error";
        echo json_encode($response);

        exit;
} 
close_database();
http_response_code(302);
$response['location'] = $redirect_url . "?fund_transfer_success=true&" .
        "transaction_id=" . $response['transaction_id'];
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
        if ($status_code != 200) {
                $data['status_code'] = $status_code;
                return $data;
        }
        $data = json_decode($response, true);
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
                return "Not Found";
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
                return "Internal Server error";
        }
}
?>
