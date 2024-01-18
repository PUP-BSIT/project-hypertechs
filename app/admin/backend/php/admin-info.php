<?php
require "./common.php";

connect_database();
session_start();
$admin_table = "admin";
$admin_id_col = "admin_id";
$name_col = "admin_name";
$first_name_col = "first_name";
$creation_date_col = "creation_date";
$admin_contact_col = "phone_number";
$user_column = "account_number";
$deposit_amount_col = "amount";
$withdraw_amount_col = "amount";

$response['success'] = false;
$admin_id = $_SESSION['admin_id'];
$result = get_admin_data($admin_table, $admin_id);
if (!$result) {
        echo json_encode($response);
        exit;
}

$name = get_name($admin_id);
if(!$name) {
        echo json_encode($response);
        exit;
}

$users = get_total_users($user_column);
$total_admin = get_total_admin($admin_id_col);
$total_deposit = get_total_deposit($deposit_amount_col);
$total_withdraw = get_total_withdraw($withdraw_amount_col);

$response['data'] = array(
        'adminId' => $result[$admin_id_col],
        'name' => $name,
        'firstName' => $result[$first_name_col],
        'phone' => $result[$admin_contact_col],
        'totalUser'=>$users,
        'totalAdmin'=>$total_admin,
        'totalDeposit'=>$total_deposit,
        'totalWithdraw'=>$total_withdraw
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
