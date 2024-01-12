<?php
require "./common.php";

connect_database();

$admin_table = "admin";
$admin_number_col = "admin_number";
$name_col = "admin_name";

$response['success'] = false;
$admin_number = $_POST['admin_number'];
$result = get_admin_data($admin_table, $admin_number);
if (!$result) {
        echo $response;
        return;
}

$response['data'] = array(
        'adminNumber' => $result[$admin_number_col],
        'name' => $result[$name_col]     
);
$response['success'] = true;
close_database();
echo json_encode($response);
?>
