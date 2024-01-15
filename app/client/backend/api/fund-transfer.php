<?php
$query = array(
        'redirect_url' => $_POST['redirect_url'],
        'amount' => (float)$_POST['transaction_amount'],
        'source' => $_POST['source_account_no'],
        'recipient' => $_POST['recipient_account_no'],
        'transfer_type' => "INTERNAL"
);
header("Location: ./verify.php?" . http_build_query($query)); 
exit;
?>
