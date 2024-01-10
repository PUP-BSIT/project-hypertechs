<?php
require "./common.php";

connect_database();
$response['success'] = false;
if (!isset($_POST['recipient_bank_code'])) {
        echo json_encode($response);
        exit;
}
$external_bank_code = $_POST['recipient_bank_code'];
$external_bank_url = get_bank_url($external_bank_code);
if (!$external_bank_url) {
        echo json_encode($response);
        exit;
}
$response['bankCode'] = $BANK_CODE;
$response['externalBankURL'] = $external_bank_url;
$response['success'] = true;
close_database();
echo json_encode($response);
?>
