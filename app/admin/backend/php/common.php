<?php
$DB_CONN;
$BANK_CODE = "APEX";
$REGISTER_ERROR = "";

function connect_database() {
        global $DB_CONN;

/*
        $hostname = "127.0.0.1:3306";
        $username = "u754510873_apex_user";
        $password = "Hypertechsnumber1";
        $database = "u754510873_apex_DB";
*/

        $hostname = "localhost";
        $username = "calib";
        $password = "Hypertechsnumber1";
        $database = "apex_bank";

        $conn =  mysqli_connect($hostname, $username, $password, $database);
        if (!$conn) {
                exit("Error: ".mysqli_connect_error()); 
        }
        $DB_CONN = $conn;
}

function modify_database($statement) {
        global $DB_CONN;
        if (!mysqli_query($DB_CONN, $statement)) return false;
        return true;
}

function extract_database($statement) {
        global $DB_CONN;
        $sql_query = mysqli_query($DB_CONN, $statement);
        if (!$sql_query) return false;
        return $sql_query;
}

function close_database() {
        global $DB_CONN;
        mysqli_close($DB_CONN);
}

function get_transaction_data($table, $transaction_id) {
        $transaction_id_col = "transaction_id";
        $sql_stmt = "SELECT *, TIME_FORMAT(time, '%H:%i %p') AS timef FROM 
                $table WHERE $transaction_id_col='$transaction_id';";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data;
}

function get_admin_data($table, $admin_id) {
        $admin_id_col = "admin_id";
        $sql_stmt = "SELECT * FROM $table WHERE
                $admin_id_col='$admin_id'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data;
}

function get_balance($account_number) {
        $balance_col = "balance";
        $table = "account";
        $account_col = "account_number";
        $sql_stmt = "SELECT $balance_col FROM $table WHERE
                 $account_col='$account_number'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$balance_col];
}

function get_name($admin_id) {
        $surname_col = "surname";
        $first_name_col = "first_name";
        $middle_name_col = "middle_name";
        $suffix_col = "suffix";
        $table = "admin";
        $admin_col = "admin_id";
        $sql_stmt = "SELECT $surname_col, $first_name_col, $middle_name_col, 
                $suffix_col FROM $table WHERE
                 $admin_col='$admin_id'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        $name = "";
        if ($data[$middle_name_col] === NULL && $data[$suffix_col] === NULL)
                return $data[$first_name_col] . " " . 
                        $data[$surname_col];
        if ($data[$middle_name_col] === NULL && $data[$suffix_col] !== NULL)
                return $data[$first_name_col] . " " . 
                        $data[$surname_col] . " " . 
                        $data[$suffix_col];
        if ($data[$middle_name_col] !== NULL && $data[$suffix_col] === NULL)
                return $data[$first_name_col] . " " . 
                        $data[$middle_name_col] . " " . 
                        $data[$surname_col];
        return $data[$first_name_col] . " " . 
                $data[$middle_name_col] . " " . 
                $data[$surname_col] . " " . 
                $data[$suffix_col];
}

function get_phone_number_via_email($email) {
        $phone_col = "phone_number";
        $table = "admin";
        $email_col = "email";
        $sql_stmt = "SELECT $phone_col FROM $table WHERE
                 $email_col='$email'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$phone_col];
}

function get_phone_number($admin_id) {
        $phone_col = "phone_number";
        $table = "admin";
        $admin_col = "admin_id";
        $sql_stmt = "SELECT $phone_col FROM $table WHERE
                 $admin_col='$admin_id'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$phone_col];
}

function get_admin_id($email) {
        $admin_col = "admin_id";
        $table = "admin";
        $email_col = "email";
        $sql_stmt = "SELECT $admin_col FROM $table WHERE
                 $email_col='$email'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$admin_col];
}

function get_admin_id_via_phone($phone_number) {
        $admin_col = "admin_id";
        $table = "admin";
        $phone_number_col = "phone_number";
        $sql_stmt = "SELECT $admin_col FROM $table WHERE
                 $phone_number_col='$phone_number'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$admin_col];
}

function get_password($admin_id) {
        $admin_col = "admin_id";
        $table = "admin";
        $password_col = "password";
        $sql_stmt = "SELECT $password_col FROM $table WHERE
                 $admin_col='$admin_id'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$password_col];
}

function set_balance($account_number, $new_balance) {
        $account_table = "account";
        $account_col = "account_number";
        $balance_col = "balance";
        $sql_stmt = "UPDATE $account_table SET $balance_col=$new_balance WHERE
                $account_col='$account_number'";
        return modify_database($sql_stmt);
}

function add_balance($account_number, $amount) {
        $balance = get_balance($account_number);
        if (!$balance) return false;
        $new_balance = $balance + $amount; 
        return set_balance($account_number, $new_balance); 
}

function deduct_balance($account_number, $amount) {
        $balance = get_balance($account_number);
        if (!$balance) return false;
        $new_balance = $balance - $amount; 
        return set_balance($account_number, $new_balance); 
}

function get_bank_name($bank_code) {
        $bank_table = "external_bank";
        $bank_name_col = "bank_name";
        $bank_code_col = "bank_code";
        $sql_stmt = "SELECT $bank_name_col FROM $bank_table WHERE
                 $bank_code_col='$bank_code'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$bank_name_col];
}

function get_bank_api_url($bank_code) {
        $bank_table = "external_bank";
        $bank_url_col = "api_url";
        $bank_code_col = "bank_code";
        $sql_stmt = "SELECT $bank_url_col FROM $bank_table WHERE
                 $bank_code_col='$bank_code'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$bank_url_col];
}

function does_admin_exist($admin_id) {
        $admin_table = "admin";
        $admin_col = "admin_id";
        $sql_stmt = "SELECT $admin_col FROM $admin_table WHERE 
                $admin_col='$admin_id'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_account_exist($account_number) {
        $account_table = "account";
        $account_col = "account_number";
        $sql_stmt = "SELECT $account_col FROM $account_table WHERE 
                $account_col='$account_number'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_employee_exist($employee_number) {
        $employee_table = "admin";
        $employee_col = "employee_number";
        $sql_stmt = "SELECT $employee_col FROM $employee_table WHERE 
                $employee_col=$employee_number";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_bank_exist($bank_code) {
        $bank_table = "external_bank";
        $bank_code_col = "bank_code";
        $sql_stmt = "SELECT $bank_code_col FROM $bank_table WHERE 
                $bank_code_col='$bank_code'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_ext_transfer_id_exist($transaction_id) {
        $transaction_table = "fund_transfer_external_send";
        $transaction_id_col = "transaction_id";
        $sql_stmt = "SELECT $transaction_id_col FROM $transaction_table WHERE 
                $transaction_id_col='$transaction_id'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_transfer_id_exist($transaction_id) {
        $transaction_table = "fund_transfer";
        $transaction_id_col = "transaction_id";
        $sql_stmt = "SELECT $transaction_id_col FROM $transaction_table WHERE 
                $transaction_id_col='$transaction_id'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_password_match($email, $password) {
        $admin_table = "admin";
        $email_col = "email";
        $password_col = "password";
        $sql_stmt = "SELECT $email_col FROM $admin_table WHERE
                $email_col='$email' AND $password_col='$password'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_employee_password_match($employee_number, $password) {
        $employee_table = "admin";
        $number_col = "employee_number";
        $password_col = "password";
        $sql_stmt = "SELECT $number_col FROM $employee_table WHERE
                $number_col=$employee_number AND $password_col='$password'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function is_register_valid() {
        session_start();
        global $REGISTER_ERROR;
        if (!trim($_POST['first_name']) || !trim($_POST['last_name']) || 
                !trim($_POST['phone_number']) || !trim($_POST['password'])
        ) {
                $REGISTER_ERROR = "Please fill the required fields"; 
                return false; 
        }
        $_SESSION['phone_number'] = $_POST['phone_number'];
        return true;
}

function does_email_exist($email) {
        $admin_table = "admin";
        $email_col = "email";
        $sql_stmt = "SELECT $email_col FROM $admin_table WHERE 
                $email_col='$email'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_phone_number_exist($phone_number) {
        $admin_table = "admin";
        $phone_number_col = "phone_number";
        $sql_stmt = "SELECT $phone_number_col FROM $admin_table WHERE 
                $phone_number_col='$phone_number'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function change_pass_via_phone($phone_number, $password) {
        $admin_table = "admin";
        $password_col = "password";
        $phone_number_col = "phone_number";
        $sql_stmt = "UPDATE $admin_table SET $password_col='$password' WHERE
                $phone_number_col='$phone_number'";
        return modify_database($sql_stmt);
}

function clear_spaces($string) {
        return str_replace(' ', '', $string);
}

?>
