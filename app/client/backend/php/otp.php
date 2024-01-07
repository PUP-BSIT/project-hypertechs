<?php
session_start();

$DURATION_SEC = 5;

$_SESSION['otp_session'] = true;
$response = array();
if (isset($_POST['renew']) || !isset($_SESSION['otp'])) {
        $response['otp'] = $_SESSION['otp'] = $otp = get_fake_otp(); 
        $response['time'] = ($_SESSION['otp_time'] = time() +
                $DURATION_SEC) - time(); 
        echo json_encode($response);
        return;
}
$response['otp'] = $_SESSION['otp'];
$response['time'] = $_SESSION['otp_time'] - time();
echo json_encode($response);

function get_fake_otp() {
        return random_int(111111, 999999);
}

function get_otp() {
        $ch = curl_init();
        $parameters = array(
                'apikey' => "7dce37931f1bbe6f1dc105d481d83ccf",
                'number' => "09550266782",
                'message' => "This is a sample message. Your One Time Password is: " . 
                        "{otp}. Thank you for using Apex Bank!"
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/otp');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return ($data[0])['code'];
}
?>