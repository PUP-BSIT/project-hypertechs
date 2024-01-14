<?php
require "./common.php";
session_start();
connect_database();

$account_table = "account";
$account_number_col = "account_number";
$password_col = "password";
$balance_col = "balance";

$contact_table = "account_contact";
$phone_number_col = "phone_number";
$address_col = "address";
$email_col = "email";

$name_table = "account_name";
$surname_col = "surname";
$first_name_col = "first_name";
$middle_name_col = "middle_name";
$suffix_col = "suffix";

$birth_table = "account_birthdate";
$birth_col = "birth_date";

$response['success'] = false;
$balance = 500.00;
$account_number = "1899" . random_int(12345678, 87654321);
$phone_number = $_POST['phone_number'];
$password = $_POST['password'];
$surname = $_POST['surname'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$birth = $_POST['birth_date'];
$address = $_POST['address'];
$email = $_POST['email'];
$suffix = $_POST['suffix'];

$sql = "INSERT INTO $account_table(
        $account_number_col, 
        $password_col, 
        $balance_col,
        $surname_col, 
        $first_name_col, 
        $middle_name_col,
        $suffix_col,
        $phone_number_col, 
        $address_col, 
        $email_col,
        $birth_col
) VALUES(
        '$account_number', 
        '$password',
        $balance,
        '$surname', 
        '$first_name',
        '$middle_name',
        '$suffix',
        '$phone_number', 
        '$address',
        '$email',
        '$birth'
)";
if (!modify_database($sql)) {
        echo json_encode($response);
        exit;
}
$_SESSION['account_number'] = $account_number;
close_database();
$redirect_url = "/app/client/pages/welcome.html";
header("Location: $redirect_url");
exit;
?>
