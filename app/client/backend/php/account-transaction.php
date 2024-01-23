<?php
require "./common.php";
session_start();
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
if ($transac_type == 'all') {

}

$sql_stmt = "";
switch ($transac_type) {
case 'all':
$sql_stmt = "SELECT transaction_id, source, recipient, amount, date, time,
                NULL AS bank_code , DATE_FORMAT(time, '%h:%i %p') AS timef,
                description
        FROM fund_transfer
        WHERE source='$account_number'
        $date_condition

        UNION ALL
        SELECT transaction_id, source, recipient, amount, date, time, bank_code
                , DATE_FORMAT(time, '%h:%i %p') AS timef, NULL AS description
        FROM fund_transfer_external_send
        WHERE source='$account_number'
        $date_condition

        UNION ALL
        SELECT transaction_id, source, recipient, amount, date, time, bank_code
                , DATE_FORMAT(time, '%h:%i %p') AS timef, NULL AS description
        FROM fund_transfer_external_receive
        WHERE recipient='$account_number'
        $date_condition

        UNION ALL
        SELECT transaction_id, source, recipient, amount, date, time, 
                NULL AS bank_code, DATE_FORMAT(time, '%h:%i %p') AS timef,
                description
        FROM fund_transfer
        WHERE recipient='$account_number'
        $date_condition

        ORDER BY date DESC, time DESC 
        LIMIT 10";
        break;
case 'internal':
$sql_stmt = "SELECT transaction_id, source, recipient, amount, date, time,
                NULL AS bank_code, DATE_FORMAT(time, '%h:%i %p') AS timef,
                description
        FROM fund_transfer
        WHERE source='$account_number'
        $date_condition

        ORDER BY date DESC, time DESC 
        LIMIT 10";
        break;
case 'external':
$sql_stmt = "SELECT transaction_id, source, recipient, amount, date, time, 
                bank_code, DATE_FORMAT(time, '%h:%i %p') AS timef
        FROM fund_transfer_external_send
        WHERE source='$account_number'
        $date_condition

        ORDER BY date DESC, time DESC 
        LIMIT 10";
        break;
case 'received':
$sql_stmt = "SELECT transaction_id, source, recipient, amount, date, 
                time, bank_code , DATE_FORMAT(time, '%h:%i %p') AS timef 
        FROM fund_transfer_external_receive
        WHERE recipient='$account_number'
        $date_condition

        UNION ALL
        SELECT transaction_id, source, recipient, amount, date, time, 
                NULL AS bank_code
                , DATE_FORMAT(time, '%h:%i %p') AS timef
        FROM fund_transfer
        WHERE recipient='$account_number'
        $date_condition

        ORDER BY date DESC, time DESC 
        LIMIT 10";
        break;
}
$result = extract_database($sql_stmt);
$data = array();
for ($i = 0; $row = mysqli_fetch_assoc($result); $i++) {
        $type = "External Transfer";
        $account = $row['recipient'];
        $description = "";

        if ($row['bank_code'] == NULL) {
                $type = "Internal Transfer"; 
                $description = $row['description'];
        }
        if ($row['recipient'] == $account_number) {
                $type = "Received Transfer";
                $account = $row['source'];
        }
        $name = get_name($account);
        if (!$name) {
                $name = get_bank_name($row['bank_code']) . " Account";
        }
        $data[$i] = array(
                'name' => $name,
                'account' => $account,
                'transactionID' => $row['transaction_id'],
                'type' => $type,
                'date' => $row['date'] . " " . $row['timef'],
                'amount' => '&#8369 ' . $row['amount'],
                'description' => $description
        );
}
close_database();
$response['data'] = $data;
$response['success'] = true;
$response['start_date'] = $start_date;
$response['end_date'] = $end_date;
echo json_encode($response);
?>
