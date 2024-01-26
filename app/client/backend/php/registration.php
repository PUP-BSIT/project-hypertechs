<?php
require "./common.php";
session_start();
connect_database();

$CARD_YEAR = 5;

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
$card_number_col = "card_number";
$card_expiration_col = "card_expiration_date";
$cvv_col = "cvv";

$birth_table = "account_birthdate";
$birth_col = "birth_date";

$response['success'] = false;
$balance = 500.00;
$account_number = "1899" . random_int(12345678, 87654321);
$phone_number = cleanstr($_POST['phone_number']);
$password = cleanstr($_POST['password']);
$surname = cleanstr(trim($_POST['surname']));
$first_name = cleanstr(trim($_POST['first_name']));
$middle_name = cleanstr(trim($_POST['middle_name']));
$birth = cleanstr($_POST['birth_date']);
$address = cleanstr($_POST['address']);
$email = cleanstr($_POST['email']);
$suffix = cleanstr($_POST['suffix']);

$card_number = "1077" . random_int(123456789123, 987654321987);
$card_expiration = date("Y-m-d", strtotime("+$CARD_YEAR years", time()));
$cvv = random_int(123, 987);

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
        $birth_col,
        $card_number_col,
        $card_expiration_col,
        $cvv_col
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
        '$birth',
        '$card_number',
        '$card_expiration',
        '$cvv'
)";
if (!modify_database($sql)) {
        echo json_encode($response);
        exit;
}
$_SESSION['account_number'] = $account_number;
close_database();
$redirect_url = "/app/client/pages/welcome.html";
http_response_code(302);
$response['location'] = $redirect_url;
echo json_encode($response);
exit;
?>
