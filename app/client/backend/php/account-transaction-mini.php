<?php
require "./common.php";
session_start();
global $connection;
connect_database();

$account_number = $_SESSION['account_number'];

$sql_stmt = "SELECT
                source AS account,
                'Internal Transfer' AS type,
                amount
            FROM fund_transfer
            WHERE source='$account_number'

            UNION ALL

            SELECT
                recipient AS account,
                'Received Transfer' AS type,
                amount
            FROM fund_transfer
            WHERE recipient='$account_number'

            UNION ALL

            SELECT
                source AS account,
                'External Transfer' AS type,
                amount
            FROM fund_transfer_external_send
            WHERE source='$account_number'

            ORDER BY date DESC, time DESC
            LIMIT 10";

$result = extract_database($sql_stmt);

if (!$result) {
    // Add error handling here
    $response['error'] = mysqli_error($connection);
    $response['success'] = false;
} else {
    $data = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'account' => $row['account'],
            'type' => $row['type'],
            'amount' => '&#8369 ' . $row['amount'],
        );
    }

    close_database();
    $response['data'] = $data;
    $response['success'] = true;
}

echo json_encode($response);
?>
