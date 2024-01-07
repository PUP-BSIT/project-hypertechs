<?php
require "./common.php";

connect_database();
$account_table = "bank_account_holder";
$account_number_col = "account_number";
$name_col = "account_name";
$balance_col = "balance";

$response['success'] = false;
$account_number = $_POST['account_number'];
$result = get_account_data($account_table, $account_number);
if (!$result) {
        echo $response;
        return;
}
$response['data'] = array(
        'accountNumber' => $result[$account_number_col],
        'name' => $result[$name_col],
        'balance' => $result[$balance_col]
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
