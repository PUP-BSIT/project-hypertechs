<?php
require "../php/common.php";
connect_database();
$params_complete = $_POST['redirect_url'] !== '' &&
        $_POST['transaction_amount'] !== '' &&
        $_POST['source_account_no'] !== '' &&
        $_POST['recipient_account_no'] !== '' &&
        $_POST['recipient_bank_code'] !== '';
if (!$params_complete) {
        http_response_code(302);
        $response['location'] = "https://apexapp.tech/app/client/pages/" .
                "account/fund_transfer_result.php?error_message=There is some missing parameters";

        echo json_encode($response);
        exit;
}
$redirect_url = $_POST['redirect_url']; 
$amount = $_POST['transaction_amount'];
$source = $_POST['source_account_no'];
$recipient = $_POST['recipient_account_no'];
$bank_code = $_POST['recipient_bank_code'];
if (!does_account_exist($source)) {
        close_database();
        http_response_code(302);
        $response['location'] = "https://apexapp.tech/app/client/pages/" .
                "account/fund_transfer_result.php?error_message=Account not found";

        echo json_encode($response);
        exit;
}
$phone_number = get_phone_number($source);
if (!$phone_number) {
        close_database();
        http_response_code(302);
        $response['location'] = "https://apexapp.tech/app/client/pages/" . 
                "account/fund_transfer_result.php?error_message=Internal server error";
        echo json_encode($response);
        exit;
}
$request_body = array(
        'redirect_url' => $redirect_url,
        'transaction_amount' => (float)$amount,
        'source_account_no' => $source,
        'recipient_account_no' => $recipient,
        'recipient_bank_code' => $bank_code
);
$query = array(
        'request_url' => "https://apexapp.tech/app/client/backend/php/" .
                "fund-transfer-external.php",
        'request_body' => json_encode($request_body),
        'phone_number' => $phone_number
);
close_database();
http_response_code(302);
$response['location'] = "https://apexapp.tech/app/client/backend/api/" .
        "request.php?" . http_build_query($query); 
echo json_encode($response);
?>
