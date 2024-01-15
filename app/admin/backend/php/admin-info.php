<?php
require "./common.php";

connect_database();
session_start();
$admin_table = "admin";
$admin_id_col = "admin_id";
$name_col = "admin_name";
$first_name_col = "first_name";

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
$response['data'] = array(
        'adminId' => $result[$admin_id_col],
        'name' => $name,
        'firstName' => $result[$first_name_col]
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
