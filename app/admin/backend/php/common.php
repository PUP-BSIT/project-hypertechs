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

function get_admin_data($table, $admin_number) {
        $admin_number_col = "admin_number";
        $sql_stmt = "SELECT * FROM $table WHERE
                $admin_number_col='$admin_number'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data;
}

function get_phone_number($admin_number) {
        $phone_col = "phone_number";
        $table = "admin";
        $admin_col = "admin_number";
        $sql_stmt = "SELECT $phone_col FROM $table WHERE
                 $admin_col='$admin_number'";
        $result = extract_database($sql_stmt);
        $data = mysqli_fetch_assoc($result);
        if (!$data) return false;
        return $data[$phone_col];
}

function does_admin_exist($admin_number) {
        $admin_table = "admin";
        $admin_col = "admin_number";
        $sql_stmt = "SELECT $admin_col FROM $admin_table WHERE 
                $admin_col='$admin_number'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

function does_password_match($admin_number, $password) {
        $admin_table = "admin";
        $admin_col = "admin_number";
        $password_col = "password";
        $sql_stmt = "SELECT $admin_col FROM $admin_table WHERE
                $admin_col='$admin_number' AND $password_col='$password'";
        $result = extract_database($sql_stmt);
        if (!mysqli_fetch_assoc($result)) return false;
        return true;
}

//for checking if acc id exist if account holder will deposit thru admin/bankteller
function does_acc_id_exist($client_number) {
        $client_table = "client";
        $client_col = "client_number";
        $sql_stmt = "SELECT $client_col FROM $client_table WHERE 
                $client_col='$client_number'";
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
?>
