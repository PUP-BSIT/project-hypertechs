<?php
$DB_CONN;
$BANK_CODE = "APEX";
$REGISTER_ERROR = "";

function connect_database() {
        global $DB_CONN;

        $hostname = "127.0.0.1";
        $username = "root";
        $password = "";
        $database = "admin_db";

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


function get_admin_data($table, $admin_id) {
        $admin_id_col = "admin_id";
        $sql_stmt = "SELECT * FROM $table WHERE
                $admin_id_col='$admin_id'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data;
}

function get_balance($admin_id) {
        $balance_col = "balance";
        $table = "admin";
        $admin_col = "admin_id";
        $sql_stmt = "SELECT $balance_col FROM $table WHERE
                 $admin_col='$admin_id'";
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
                return $data[$first_name_col] . " " . $data[$surname_col];
        if ($data[$middle_name_col] === NULL && $data[$suffix_col] !== NULL)
                return $data[$first_name_col] . " " . $data[$surname_col] .
                        " " . $data[$suffix_col];
        if ($data[$middle_name_col] !== NULL && $data[$suffix_col] === NULL)
                return $data[$first_name_col] . " " . $data[$middle_name_col]
                       . " " . $data[$surname_col];
        return $data[$first_name_col] . " " . $data[$middle_name_col]
               . " " . $data[$surname_col] . " " . $data[$suffix_col];
}

function get_phone_number($email) {
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

function add_balance($admin_id, $amount) {
        $balance = get_balance($admin_id);
        if (!$balance) return false;
        $new_balance = $balance + $amount; 
        return set_balance($admin_id, $new_balance); 
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
?>
