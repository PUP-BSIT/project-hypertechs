<?php
require "../../backend/php/common.php";

connect_database();
$transaction_id = $_GET['transaction_id'];
// $status = $_GET['fund_transfer_success'] ? "Approved" : "Pending";
$status = "Pending";
$error_message = $_GET['error_message'];
//$error_message = "Hello";
echo <<<EOT
<!DOCTYPE html>
<html>
<head>
    <title>GoodBank</title>    
</head>
<body>
    <div id="content">
        <div class="center">
            <div>

EOT;
$end = <<<EOT

            </div> 
        </div>
    </div>
</body>
</html>
EOT;
$success = <<<EOT
                <p class="big">Success!</p><p>Fund transfer successful! We 
                    appreciate your trust in our services.
                </p>
                <p>Transaction ID: $transaction_id</p> 
                <a class="link-button" href="./overview.html">
                    <button class="btn">Go to account</button>
                </a>
EOT; 
$failure = <<<EOT
                <p>Unfortunately, the transaction ID does not exist in our
                    records.
                </p>
EOT;
$error = <<<EOT
                <p>$error_message</p>
                <a class="link-button" href="./transfer.html">
                    <button class="btn">Retry</button>
                </a>
EOT;
if (isset($error_message)) {
        echo $error;
        echo $end;
        exit();
}
echo does_transfer_id_exist($transaction_id, $status) ? $success : $failure;
close_database();
?>
