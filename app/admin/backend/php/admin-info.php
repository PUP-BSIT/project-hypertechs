<?php
require "./common.php";

connect_database();
session_start();
$admin_table = "admin";
$admin_number_col = "admin_number";
$name_col = "admin_name";
$first_name_col = "first_name";

$response['success'] = false;
$admin_number = $_SESSION['admin_number'];
$result = get_admin_data($admin_table, $admin_number);
if (!$result) {
        echo json_encode($response);
        exit;
}
$name = get_name($admin_number);
if(!$name) {
        echo json_encode($response);
        exit;
}
$response['data'] = array(
        'adminNumber' => $result[$admin_number_col],
        'name' => $name,
        'firstName' => $result[$first_name_col]
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
