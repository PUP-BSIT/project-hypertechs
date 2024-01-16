<?php
session_start();
$DURATION_SEC = 5 * 60;
$response = array();
if (isset($_POST['renew']) || !isset($_SESSION['otp'])) {
        $response['otp'] = $_SESSION['otp'] = $otp = get_fake_otp();
/*
        $response['otp'] = $_SESSION['otp'] = $otp = get_fake_otp();
*/
        $response['time'] = ($_SESSION['otp_time'] = time() +
                $DURATION_SEC) - time(); 
        echo json_encode($response);
        return;
}
$response['otp'] = $_SESSION['otp'];
$response['phone'] = $_SESSION['phone_number'];
$response['time'] = $_SESSION['otp_time'] - time();
echo json_encode($response);

function get_fake_otp() {
        return random_int(111111, 999999);
}

//echo get_otp();

function get_otp() {
        session_start();
        $phone_number = $_SESSION['phone_number'];
        if (isset($_SESSION['otp_phone']))
                $phone_number = $_SESSION['otp_phone'];
        $ch = curl_init();
        $parameters = array(
                'apikey' => "7dce37931f1bbe6f1dc105d481d83ccf",
                'number' => $phone_number,
                // 'number' => "09550266782",
                'message' => "This is a message from Apex Bank. " .
                "Your One Time Password (OTP) is: " . 
                "{otp}. This code will be valid for only 5 minutes."
        );
        curl_setopt($ch, CURLOPT_URL, 'https://api.semaphore.co/api/v4/otp');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output, true);
        return ($data[0])['code'];
        //return $output;
}
?>
