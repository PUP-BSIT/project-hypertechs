<?php
$DB_CONN;

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
        $database = "bank";
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
        $transaction_id_col = "transaction_number";
        $sql_stmt = "SELECT * FROM $table WHERE
                $transaction_id_col='$transaction_id';";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data;
}

function get_account_data($table, $account_number) {
        $account_number_col = "account_number";
        $sql_stmt = "SELECT * FROM $table WHERE
                $account_number_col=$account_number";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data;
}

function get_balance($account_number) {
        $balance_col = "balance";
        $table = "bank_account_holder";
        $account_col = "account_number";
        $sql_stmt = "SELECT $balance_col FROM $table WHERE
                 $account_col=$account_number";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$balance_col];
}

function set_balance($account_number, $new_balance) {
        $account_table = "bank_account_holder";
        $account_col = "account_number";
        $balance_col = "balance";
        $sql_stmt = "UPDATE $account_table SET $balance_col=$new_balance WHERE
                $account_col=$account_number";
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

function does_account_exist($account_number) {
        $account_table = "bank_account_holder";
        $account_col = "account_number";
        $sql_stmt = "SELECT $account_col FROM $account_table WHERE 
                $account_col=$account_number";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_employee_exist($employee_number) {
        $employee_table = "bank_teller";
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

function does_ext_transfer_id_exist($transaction_id, $status) {
        $transaction_table = "external_transfer_send";
        $transaction_id_col = "transaction_number";
        $status_col = "status";
        $sql_stmt = "SELECT $transaction_id_col FROM $transaction_table WHERE 
                $transaction_id_col='$transaction_id' AND  
                $status_col='$status'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_transfer_id_exist($transaction_id, $status) {
        $transaction_table = "transfer_send";
        $transaction_id_col = "transaction_number";
        $status_col = "status";
        $sql_stmt = "SELECT $transaction_id_col FROM $transaction_table WHERE 
                $transaction_id_col='$transaction_id' AND  
                $status_col='$status'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_password_match($account_number, $password) {
        $account_table = "bank_account_holder";
        $account_col = "account_number";
        $password_col = "password";
        $sql_stmt = "SELECT $account_col FROM $account_table WHERE
                $account_col=$account_number AND $password_col='$password'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_employee_password_match($employee_number, $password) {
        $employee_table = "bank_teller";
        $number_col = "employee_number";
        $password_col = "password";
        $sql_stmt = "SELECT $number_col FROM $employee_table WHERE
                $number_col=$employee_number AND $password_col='$password'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

?>
