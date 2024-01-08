<?php
require "./common.php";
session_start();

$account_table = "bank_account_holder";
$account_number_col = "account_number";
$name_col = "account_name";
$password_col = "password";
$phone_number_col = "phone_number";
$balance_col = "balance";

$response['success'] = false;
$account_number = random_int(123456789, 987654321);
//$name = "$_POST['first_name'] $_POST['last_name']";
$name = $_POST['first_name']; 
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$balance = 0.00;
connect_database();
$sql = "INSERT INTO $account_table(
                $account_number_col, 
                $name_col, 
                $phone_number_col, 
                $password_col, 
                $balance_col
        ) VALUES(
                $account_number, 
                '$name', 
                '$phone_number', 
                '$password',
                $balance
        )";
if (!modify_database($sql)) {
        echo json_encode($response);
        exit;
}
$_SESSION['account_number'] = $account_number;
close_database();
http_response_code(302);
$response['url'] = "./welcome.html";
$response['success'] = true;
echo json_encode($response);
?>
