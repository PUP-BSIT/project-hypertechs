<?php
require "./common.php";
session_start();
global $connection;
connect_database();

$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$transac_type = $_POST['transac_type'];
$account_number = $_SESSION['account_number'];
$date_condition = "";

if ($start_date == "" && $end_date == "") {
    $date_condition = "";
} else if ($start_date != "" && $end_date == "") {
    $date_condition = "AND date >= '$start_date'";
} else if ($start_date == "" && $end_date != "") {
    $date_condition = "AND date <= '$end_date'";
} else {
    $date_condition = "AND date >= '$start_date' AND date <= '$end_date'";
}

$sql_stmt = "";

switch ($transac_type) {
    case 'all':
        $sql_stmt = "SELECT
                        source AS account,
                        'Internal Transfer' AS type,
                        amount
                    FROM fund_transfer
                    WHERE source='$account_number'
                    $date_condition

                    UNION ALL

                    SELECT
                        recipient AS account,
                        'Received Transfer' AS type,
                        amount
                    FROM fund_transfer
                    WHERE recipient='$account_number'
                    $date_condition

                    ORDER BY date DESC, time DESC
                    LIMIT 5";
        break;
    case 'internal':
        $sql_stmt = "SELECT
                        source AS account,
                        'Internal Transfer' AS type,
                        amount
                    FROM fund_transfer
                    WHERE source='$account_number'
                    $date_condition

                    ORDER BY date DESC, time DESC
                    LIMIT 5";
        break;
    case 'external':
        $sql_stmt = "SELECT
                        source AS account,
                        'External Transfer' AS type,
                        amount
                    FROM fund_transfer_external_send
                    WHERE source='$account_number'
                    $date_condition

                    ORDER BY date DESC, time DESC
                    LIMIT 5";
        break;
    case 'received':
        $sql_stmt = "SELECT
                        recipient AS account,
                        'Received Transfer' AS type,
                        amount
                    FROM fund_transfer
                    WHERE recipient='$account_number'
                    $date_condition

                    ORDER BY date DESC, time DESC
                    LIMIT 10";
        break;
}

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
    $response['start_date'] = $start_date;
    $response['end_date'] = $end_date;
}

echo json_encode($response);
?>
