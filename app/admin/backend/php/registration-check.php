<?php
require "./common.php";
$response['success'] = false;
if (!is_register_valid()) {
        $response['errorMessage'] = $REGISTER_ERROR;
        echo json_encode($response);
        exit;
}
$response['success'] = true;
echo json_encode($response);
?>
