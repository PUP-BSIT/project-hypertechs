<?php
require "./common.php";
session_start();
global $connection;
connect_database();

$account_number = $_SESSION['account_number'];

$sql_stmt = "SELECT
                recipient AS account, source,
                'Internal Transfer' AS type,
                amount, date, time
            FROM fund_transfer
            WHERE source='$account_number'

            UNION ALL

            SELECT
                source AS account, recipient,
                'Received Transfer' AS type,
                amount, date, time
            FROM fund_transfer
            WHERE recipient='$account_number'

            UNION ALL

            SELECT
                source AS account, recipient,
                'Received Transfer' AS type,
                amount, date, time
            FROM fund_transfer_external_receive
            WHERE recipient='$account_number'

            UNION ALL

            SELECT
                recipient AS account, source,
                'External Transfer' AS type,
                amount, date, time
            FROM fund_transfer_external_send
            WHERE source='$account_number'

            ORDER BY date DESC, time DESC
            LIMIT 5";

$result = extract_database($sql_stmt);

$response = array();

if (!$result) {
    $response['error'] = mysqli_error($connection);
    $response['success'] = false;
} else {
    $data = array();

    for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
        $name = "";
        $type = $row['type'];
        if ($row['type'] == 'External Transfer') {
            $name = "VRZN Account";
        }
        if ($row['type'] == 'Internal Transfer') {
            $name = get_name($row['account']);
        }
        if ($row['type'] == 'Received Transfer') {
            $name = get_name($row['account']);
            if (!$name) {
                $name = " VRZN Bank Account";
            }
        }
        $data[$i] = array(
            'name' => $name,
            'type' => $type,
            'amount' => '&#8369 ' . $row['amount'],
        );
    }
    close_database();
    $response['data'] = $data;
    $response['success'] = true;
}

echo json_encode($response);
