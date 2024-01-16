<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../src/css/account/transfer_message.css">
    <link rel="icon" href="/app/client/assets/img/apex_brand.png" type="image/png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Apex Bank – Transfer Result</title>
</head>

<body>
    <script src="../../src/scripts/preload.js"></script>
    <section id="transfer_message_grid_container">
        <div id="header_container">
            <div id="apex_logo">
                <img src="../../assets/img/apex_brand.png" alt="apex logo">
                <h1>Apex Bank</h1>
            </div>

            <nav>
                <div id="toggle_theme">
                    <input type="checkbox" class="checkbox" id="theme_mode" />
                    <label class="label" for="theme_mode" onclick="toggleTheme()">
                        <i class="fas fa-moon"></i>
                        <i class="fas fa-sun"></i>
                        <div class="ball"></div>
                    </label>
                </div>
            </nav>
        </div>
<?php
// -----------------------------------------
ini_set('date.timezone', 'Asia/Manila');
require "../../backend/php/common.php";
connect_database();
if (isset($_GET['error_message'])) {
        $error_message = htmlspecialchars($_GET['error_message']);
        echo <<<EOT
        <div id="transfer_message_container">
            <div id="tranfer_message_text">
                <div id="transfer_failed"> <!--Get OTP-->
                    <h1><i class="fa-solid fa-circle-xmark"></i>Transfer Failed</h1>
                    <p>$error_message</p>
                    <button id="btn_try" onclick="history.back()" type="button">Try Again</button>
                    <p id="loading_get" hidden><!--Please wait. --></p>
                </div>
            </div>
        </div>

EOT;
        exit;
}
if (!isset($_GET['fund_transfer_success']) || !isset($_GET['transaction_id'])) {
        echo <<<EOT
        <div id="transfer_message_container">
            <div id="tranfer_message_text">
                <div id="transfer_failed"> <!--Get OTP-->
                    <h1><i class="fa-solid fa-circle-xmark"></i>
                    Something went wrong.
                    </h1>
                    <p>Internal server error</p>
                    <button id="btn_try" type="button">Try Again</button>
                    <p id="loading_get" hidden><!--Please wait. --></p>
                </div>
            </div>
        </div>

EOT;
        exit;
}
$data = get_transaction_data("fund_transfer", $_GET['transaction_id']);
$transfer_type = "Internal Transfer";
if (!$data) {
        $data = get_transaction_data("fund_transfer_external_send", 
                $_GET['transaction_id']);
        $transfer_type = "External Transfer";
}
if (!$data) {
        echo <<<EOT
        <div id="transfer_message_container">
            <div id="tranfer_message_text">
                <div id="transfer_failed"> <!--Get OTP-->
                    <h1><i class="fa-solid fa-circle-xmark"></i>
                    Something went wrong.
                    </h1>
                    <p>The transaction ID was not found in our server</p>
                    <button id="btn_try" type="button">Try Again</button>
                    <p id="loading_get" hidden><!--Please wait. --></p>
                </div>
            </div>
        </div>

EOT;
        exit;
}
$transaction_id = htmlspecialchars($data['transaction_id']);
$amount = htmlspecialchars($data['amount']);

$dateTimeString = $data['date'] . ' ' . $data['timef'];
$dateTimeUTC = new DateTime($dateTimeString, new DateTimeZone('UTC'));

// Convert UTC time to Asia/Manila timezone
$dateTimeManila = clone $dateTimeUTC;
$dateTimeManila->setTimezone(new DateTimeZone('Asia/Manila'));

$recipient_name = strtoupper(htmlspecialchars(get_name($data['recipient'])));

echo <<<EOT
        <div id="transfer_message_container">
            <div id="tranfer_message_text">
                <div id="transfer_successful">
                    <h1>
                        <i class="fa-solid fa-circle-check"></i>Transfer Successful
                    </h1>

                    <div id="transfer_amount_container">
                        <h2>&#8369;<span id="display_transfer_msg_amount">
                                $amount
                            </span>
                        </h2>
                    </div>

                    <p> 
                        Your money has been successfully transferred to
                        <strong>
                            <span id="display_transfer_msg_recipient">
                                $recipient_name.
                            </span>
                        </strong>
                        Thank you for choosing Apex Bank!
                    </p>
                    <div id="transfer_message_details">
                        <h3 id="trans_id_heading">
                            <i class="fas fa-info-circle"></i>Transaction ID:
                            <span id="display_transaction_id">
                                $transaction_id
                            </span>
                        </h3>
                        <h3 id="transfer_date_heading">
                            <i class="far fa-calendar-alt"></i>Transfer Date:
                            <span id="display_transfer_date">
                                {$dateTimeManila->format('Y-m-d H:i:s')}
                                </span>
                        </h3>
                        <h3 id="transfer_type_heading">
                            <i class="fas fa-exchange-alt"></i>Transfer Type:
                            <span id="display_transfer_type">$transfer_type</span>
                        </h3>
                    </div>
                    <div id="transfer_goto_account">
                        <a href="./overview.html">Go to account<i class="fa-solid fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>

EOT;
// ---------------------------------------------
?>
        <div id="transfer_message_image_container">
            <svg class="animated" id="freepik_stories-plain-credit-card" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 500 500" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                xmlns:svgjs="http://svgjs.com/svgjs">
                <g id="freepik--Floor--inject-47" class="animable animator-hidden"
                    style="transform-origin: 266.065px 442.885px;">
                    <path
                        d="M472.62,442.88c0,.15-92.49.27-206.55.27S59.51,443,59.51,442.88s92.46-.26,206.56-.26S472.62,442.74,472.62,442.88Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 266.065px 442.885px;" id="elh8f1xopxhtk"
                        class="animable"></path>
                </g>
                <g id="freepik--Device--inject-47" class="animable" style="transform-origin: 187.232px 251.705px;">
                    <path d="M181.61,128.06s.87-44.81-36.2-67.57H262.9s33.59,27.22,33.87,67.57Z"
                        style="fill: rgb(235, 235, 235); transform-origin: 221.09px 94.275px;" id="eli0g7s240ry"
                        class="animable"></path>
                    <path
                        d="M253.94,76.83c0,.15-13.42.27-30,.27s-30-.12-30-.27,13.42-.26,30-.26S253.94,76.69,253.94,76.83Z"
                        style="fill: rgb(69, 90, 100); transform-origin: 223.94px 76.835px;" id="el4yr7nuydp3o"
                        class="animable"></path>
                    <path
                        d="M266.76,84.94c0,.14-17.78.26-39.71.26s-39.71-.12-39.71-.26,17.78-.27,39.71-.27S266.76,84.79,266.76,84.94Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 227.05px 84.935px;" id="elhpqqs3xmfkq"
                        class="animable"></path>
                    <path
                        d="M273.44,105.44c0,.14-17.78.26-39.71.26s-39.72-.12-39.72-.26,17.78-.26,39.72-.26S273.44,105.3,273.44,105.44Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 233.725px 105.44px;" id="ela4iqnbjuswv"
                        class="animable"></path>
                    <path
                        d="M231.94,94.27a9.8,9.8,0,0,1-1.62.11l-4.44.08c-3.75.05-8.92.08-14.64.08s-10.89,0-14.64-.08l-4.44-.08a9.8,9.8,0,0,1-1.62-.11,9.79,9.79,0,0,1,1.62-.1l4.44-.08c3.75,0,8.92-.08,14.64-.08s10.89,0,14.64.08l4.44.08A9.79,9.79,0,0,1,231.94,94.27Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 211.24px 94.275px;" id="el31bumut23rl"
                        class="animable"></path>
                    <path
                        d="M266.76,94.27a5.36,5.36,0,0,1-1.2.11l-3.28.08c-2.76.05-6.59.08-10.81.08s-8.05,0-10.81-.08l-3.28-.08a5.36,5.36,0,0,1-1.2-.11,6.08,6.08,0,0,1,1.2-.1l3.28-.08c2.76,0,6.59-.08,10.81-.08s8,0,10.81.08l3.28.08A5.41,5.41,0,0,1,266.76,94.27Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 251.47px 94.275px;" id="ele61m6wivtzq"
                        class="animable"></path>
                    <path
                        d="M239.31,116.43a9.85,9.85,0,0,1-1.63.11l-4.43.08c-3.75,0-8.93.08-14.64.08s-10.9,0-14.65-.08l-4.43-.08a9.85,9.85,0,0,1-1.63-.11,9.85,9.85,0,0,1,1.63-.1l4.43-.08c3.75,0,8.93-.08,14.65-.08s10.89,0,14.64.08l4.43.08A9.85,9.85,0,0,1,239.31,116.43Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 218.605px 116.435px;" id="elqw5jjer41m"
                        class="animable"></path>
                    <path
                        d="M274.13,116.43a5.36,5.36,0,0,1-1.2.11l-3.28.08c-2.77,0-6.59.08-10.81.08s-8,0-10.82-.08l-3.28-.08a5.36,5.36,0,0,1-1.2-.11,6.08,6.08,0,0,1,1.2-.1l3.28-.08c2.77,0,6.59-.08,10.82-.08s8,0,10.81.08l3.28.08A6.08,6.08,0,0,1,274.13,116.43Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 258.835px 116.435px;" id="el1vsjv2fwqpx"
                        class="animable"></path>
                    <path
                        d="M157.59,126.79H330.93l9.44,300.3a15.34,15.34,0,0,1-14.86,15.82H144.78a9.92,9.92,0,0,1-9.91-9.43l-8.33-169.57S75.13,245.25,76,188.32C76,188.32,78.34,126.79,157.59,126.79Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 208.183px 284.85px;" id="els8efebd2qu"
                        class="animable"></path>
                    <path d="M167,442.46l-7.56-315.67H337.22l3.21,302.39a13.28,13.28,0,0,1-12.85,13.69h-.46Z"
                        style="fill: rgb(69, 90, 100); transform-origin: 249.938px 284.83px;" id="elhfwx6oegcto"
                        class="animable"></path>
                    <polygon points="174.13 145.08 177.73 292.06 322.52 292.06 320.57 145.08 174.13 145.08"
                        style="fill: rgb(38, 50, 56); transform-origin: 248.325px 218.57px;" id="el7efi5dwa2s8"
                        class="animable"></polygon>
                    <path
                        d="M190.15,164.1c7.07,1.91,16,1.1,23.26.75a2,2,0,0,0,0-4c-7.26-.36-16.2-1.17-23.26.75a1.33,1.33,0,0,0-.9,1.65,1.35,1.35,0,0,0,.9.9Z"
                        style="fill: rgb(224, 224, 224); transform-origin: 202.303px 162.846px;" id="eleqii3c19yes"
                        class="animable"></path>
                    <path
                        d="M225.77,163.81c6.94,1.77,15.91,1.45,23,.77a2,2,0,0,0,0-4c-7.09-.69-16.06-1-23,.77a1.29,1.29,0,0,0-.86,1.61,1.28,1.28,0,0,0,.86.86Z"
                        style="fill: rgb(224, 224, 224); transform-origin: 237.812px 162.578px;" id="elvmrxq89m4e8"
                        class="animable"></path>
                    <path
                        d="M260.91,163.18c3.49,1.06,7.26.88,10.88.94a70.81,70.81,0,0,0,11.09-.21c1.81-.26,1.81-3.41,0-3.66a69.59,69.59,0,0,0-11.09-.22c-3.62.06-7.39-.12-10.88.94a1.15,1.15,0,0,0,0,2.21Z"
                        style="fill: rgb(224, 224, 224); transform-origin: 272.158px 162.075px;" id="elet7qx4dcvn4"
                        class="animable"></path>
                    <path
                        d="M293.47,163.38a58.73,58.73,0,0,0,7.95.61c2.64.06,5.49.49,8.05-.24a1.75,1.75,0,0,0,0-3.35c-2.56-.73-5.41-.3-8.05-.24a57.17,57.17,0,0,0-7.95.62,1.36,1.36,0,0,0,0,2.6Z"
                        style="fill: rgb(224, 224, 224); transform-origin: 301.611px 162.075px;" id="elvodcjqb30oa"
                        class="animable"></path>
                    <rect x="177.78" y="309.54" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 198.76px 324.535px;" id="eluyf78xyv3q"
                        class="animable"></rect>
                    <rect x="177.78" y="309.54" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 181.575px 324.535px;" id="elutw0jbjobo"
                        class="animable"></rect>
                    <rect x="229.16" y="309.54" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 250.14px 324.535px;" id="ellygiyh93qi"
                        class="animable"></rect>
                    <rect x="228.73" y="309.54" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 232.525px 324.535px;" id="el8qz6i7k62sp"
                        class="animable"></rect>
                    <rect x="280.55" y="309.54" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 301.53px 324.535px;" id="el4hcqlqirej4"
                        class="animable"></rect>
                    <rect x="279.35" y="309.54" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 283.145px 324.535px;" id="elxowuics7u3f"
                        class="animable"></rect>
                    <rect x="280.55" y="349.44" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 301.53px 364.435px;" id="elv9qfcq35b1"
                        class="animable"></rect>
                    <rect x="280.55" y="349.44" width="7.82" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 284.46px 364.435px;" id="eltpbm8iq61hf"
                        class="animable"></rect>
                    <rect x="177.78" y="349.44" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 198.76px 364.435px;" id="el2fbw2pfovis"
                        class="animable"></rect>
                    <rect x="177.78" y="349.38" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 181.575px 364.375px;" id="el7hmfibhbb3o"
                        class="animable"></rect>
                    <rect x="177.78" y="388.94" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 198.76px 403.935px;" id="elugj5tvb23ts"
                        class="animable"></rect>
                    <g id="elsi08dg6d02">
                        <rect x="177.78" y="388.94" width="41.96" height="29.99"
                            style="isolation: isolate; opacity: 0.3; transform-origin: 198.76px 403.935px;"
                            class="animable"></rect>
                    </g>
                    <rect x="177.78" y="388.94" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 181.575px 403.935px;" id="elhpmoj1w3s8"
                        class="animable"></rect>
                    <rect x="228.93" y="349.44" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 249.91px 364.435px;" id="elusx7ttnjqz"
                        class="animable"></rect>
                    <rect x="228.93" y="349.38" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 232.725px 364.375px;" id="el6nrcrrmnv1c"
                        class="animable"></rect>
                    <rect x="229.16" y="388.94" width="41.96" height="29.99"
                        style="fill: rgb(36, 106, 248); transform-origin: 250.14px 403.935px;" id="elv8b1nwv4w0d"
                        class="animable"></rect>
                    <g id="el4cy17468ypl">
                        <rect x="229.16" y="388.94" width="41.96" height="29.99"
                            style="isolation: isolate; opacity: 0.3; transform-origin: 250.14px 403.935px;"
                            class="animable"></rect>
                    </g>
                    <rect x="229.16" y="388.94" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 232.955px 403.935px;" id="eldt1buz8e49s"
                        class="animable"></rect>
                    <rect x="280.55" y="388.94" width="41.96" height="29.99"
                        style="fill: rgb(224, 224, 224); transform-origin: 301.53px 403.935px;" id="el6qbj9rsxl2f"
                        class="animable"></rect>
                    <rect x="280.55" y="388.94" width="7.59" height="29.99"
                        style="fill: rgb(38, 50, 56); transform-origin: 284.345px 403.935px;" id="eln28nkl98d"
                        class="animable"></rect>
                    <path
                        d="M153.15,442.92c-.72,0-3.35-70.74-5.88-158s-4-158.09-3.28-158.11,3.35,70.72,5.88,158S153.87,442.9,153.15,442.92Z"
                        style="fill: rgb(69, 90, 100); transform-origin: 148.57px 284.865px;" id="el5rlnl3jo7tg"
                        class="animable"></path>
                    <polygon points="322.3 275.32 322.3 280.71 338.9 284.84 338.81 276.53 322.3 275.32"
                        style="fill: rgb(69, 90, 100); transform-origin: 330.6px 280.08px;" id="elx7kja2conci"
                        class="animable"></polygon>
                    <path
                        d="M120.79,264.51a6.81,6.81,0,0,0-2.86-.47,10.07,10.07,0,0,0-2.86.7l-11.36,3.8L81.51,276l-42,14a7,7,0,0,0-4,3,6.73,6.73,0,0,0-.95,4.81,18.35,18.35,0,0,0,.72,2.43l.81,2.42c.54,1.61,1.07,3.2,1.61,4.79q3.16,9.49,6.16,18.43c4,11.9,7.68,23,11.07,33.09,6.74,20.23,12.21,36.61,16,47.93,1.88,5.66,3.33,10.05,4.33,13,.48,1.49.86,2.62,1.11,3.39s.36,1.16.36,1.16h0a6.25,6.25,0,0,0,.51,1.1,7,7,0,0,0,2.42,2.55,7,7,0,0,0,5.54.8c2.18-.7,4.68-1.58,7.51-2.52l41.76-14.08L89.93,273.2l22.28-7.47L152.44,389l-1.76-42.88c-8.1-24.13-16.85-50.22-26-77.45A6.82,6.82,0,0,0,120.79,264.51ZM69.45,327.88l-9.94-31.46,3.37-1.07,9.94,31.46Zm6.9-17.33-5.8-18.34,3.37-1.06,5.8,18.33Zm7.78,23.26-5.79-18.34,3.37-1.06,5.79,18.33Zm2,4.92,3.37-1.07,16,50.78-3.37,1.06Zm21,66.44-3.43-10.85,3.37-1.07,3.43,10.86ZM121,399.41l-3.37,1.06-21.17-67,3.37-1.06ZM98.1,326l-3.37,1.06L82.45,288.23l3.37-1.07Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 93.4469px 346.59px;" id="el47401wmeile"
                        class="animable"></path>
                    <g id="elg2jp6jlfbt7">
                        <path
                            d="M120.79,264.51a6.81,6.81,0,0,0-2.86-.47,10.07,10.07,0,0,0-2.86.7l-11.36,3.8L81.51,276l-42,14a7,7,0,0,0-4,3,6.73,6.73,0,0,0-.95,4.81,18.35,18.35,0,0,0,.72,2.43l.81,2.42c.54,1.61,1.07,3.2,1.61,4.79q3.16,9.49,6.16,18.43c4,11.9,7.68,23,11.07,33.09,6.74,20.23,12.21,36.61,16,47.93,1.88,5.66,3.33,10.05,4.33,13,.48,1.49.86,2.62,1.11,3.39s.36,1.16.36,1.16h0a6.25,6.25,0,0,0,.51,1.1,7,7,0,0,0,2.42,2.55,7,7,0,0,0,5.54.8c2.18-.7,4.68-1.58,7.51-2.52l41.76-14.08L89.93,273.2l22.28-7.47L152.44,389l-1.76-42.88c-8.1-24.13-16.85-50.22-26-77.45A6.82,6.82,0,0,0,120.79,264.51ZM69.45,327.88l-9.94-31.46,3.37-1.07,9.94,31.46Zm6.9-17.33-5.8-18.34,3.37-1.06,5.8,18.33Zm7.78,23.26-5.79-18.34,3.37-1.06,5.79,18.33Zm2,4.92,3.37-1.07,16,50.78-3.37,1.06Zm21,66.44-3.43-10.85,3.37-1.07,3.43,10.86ZM121,399.41l-3.37,1.06-21.17-67,3.37-1.06ZM98.1,326l-3.37,1.06L82.45,288.23l3.37-1.07Z"
                            style="isolation: isolate; opacity: 0.3; transform-origin: 93.4469px 346.59px;"
                            class="animable"></path>
                    </g>
                    <path
                        d="M134.5,412.49l-.05-.16L92.69,426.41c-2.83.94-5.33,1.82-7.51,2.52a7,7,0,0,1-5.54-.8,7,7,0,0,1-2.42-2.55c-.39-.7-.48-1.11-.51-1.1h0l.1.29a6.9,6.9,0,0,0,2.78,3.44,7,7,0,0,0,5.62.86c2.2-.69,4.7-1.55,7.54-2.49l47.93-16,11.37-3.8,1.1-.56Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 114.93px 417.768px;" id="els5xkfaq5np"
                        class="animable"></path>
                    <path
                        d="M76.35,423.31c-.25-.77-.63-1.9-1.11-3.39-1-3-2.45-7.38-4.33-13-3.77-11.32-9.24-27.7-16-47.93-3.39-10.11-7.09-21.19-11.07-33.09q-3-8.92-6.16-18.43c-.54-1.59-1.07-3.18-1.61-4.79l-.81-2.42a18.35,18.35,0,0,1-.72-2.43,6.73,6.73,0,0,1,1-4.81,7,7,0,0,1,4-3l42-14,22.2-7.44,11.36-3.8a10.07,10.07,0,0,1,2.86-.7,6.76,6.76,0,0,1,6.77,4.61c9.13,27.23,17.88,53.32,26,77.45l-.07-1.62c-7.94-23.72-16.52-49.3-25.45-76a7.3,7.3,0,0,0-4.19-4.44,7.14,7.14,0,0,0-3.07-.5,10.69,10.69,0,0,0-3,.72l-11.35,3.81-22.2,7.44-42,14.08a7.4,7.4,0,0,0-4.26,3.13,7.23,7.23,0,0,0-1,5.13,19.27,19.27,0,0,0,.74,2.49c.27.81.55,1.61.82,2.42.53,1.6,1.07,3.2,1.6,4.78q3.2,9.5,6.19,18.43L54.6,359.06l16.13,47.88c1.92,5.64,3.4,10,4.41,13,.51,1.48.9,2.61,1.16,3.38l.41,1.15h0S76.6,424.08,76.35,423.31Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 92.3783px 344.019px;" id="el03f1qpnduqi"
                        class="animable"></path>
                    <g id="elmfbora516lq">
                        <rect x="106.93" y="331.32" width="3.53" height="70.26"
                            style="fill: rgb(250, 250, 250); transform-origin: 108.695px 366.45px; transform: rotate(-17.54deg);"
                            class="animable"></rect>
                    </g>
                    <g id="elhzu0qd2tksc">
                        <rect x="88.51" y="286.74" width="3.53" height="40.75"
                            style="fill: rgb(250, 250, 250); transform-origin: 90.275px 307.115px; transform: rotate(-17.54deg);"
                            class="animable"></rect>
                    </g>
                    <g id="ellqlmufonnjp">
                        <rect x="73.37" y="291.23" width="3.53" height="19.23"
                            style="fill: rgb(250, 250, 250); transform-origin: 75.135px 300.845px; transform: rotate(-17.54deg);"
                            class="animable"></rect>
                    </g>
                    <g id="elp25ss6esr1">
                        <rect x="63.75" y="294.18" width="3.52" height="32.88"
                            style="fill: rgb(250, 250, 250); transform-origin: 65.51px 310.62px; transform: rotate(-17.53deg);"
                            class="animable"></rect>
                    </g>
                    <g id="elyckrpmzq3i">
                        <rect x="105.38" y="393.51" width="3.53" height="11.38"
                            style="fill: rgb(250, 250, 250); transform-origin: 107.145px 399.2px; transform: rotate(-17.54deg);"
                            class="animable"></rect>
                    </g>
                    <g id="elnh4g46zce4l">
                        <rect x="81.15" y="314.49" width="3.53" height="19.23"
                            style="fill: rgb(250, 250, 250); transform-origin: 82.915px 324.105px; transform: rotate(-17.54deg);"
                            class="animable"></rect>
                    </g>
                    <g id="el2f1aobs1xml">
                        <rect x="94.04" y="336.98" width="3.53" height="53.25"
                            style="fill: rgb(250, 250, 250); transform-origin: 95.805px 363.605px; transform: rotate(-17.54deg);"
                            class="animable"></rect>
                    </g>
                    <polygon
                        points="89.93 273.2 134.45 412.33 134.5 412.49 153.15 406.24 153.15 406.24 152.44 388.98 112.21 265.73 89.93 273.2"
                        style="fill: rgb(250, 250, 250); transform-origin: 121.54px 339.11px;" id="el8rwr2y2mdem"
                        class="animable"></polygon>
                    <polygon points="134.25 420.8 152.33 414.44 151.94 406.51 134.5 412.49 134.25 420.8"
                        style="fill: rgb(38, 50, 56); transform-origin: 143.29px 413.655px;" id="elhxkhwrnp7kj"
                        class="animable"></polygon>
                </g>
                <g id="freepik--Icon--inject-47" class="animable" style="transform-origin: 386.367px 115.713px;">
                    <path
                        d="M362.21,190.61c0,.14-.56.23-1.26.2s-1.24-.17-1.23-.32.57-.23,1.26-.2S362.22,190.46,362.21,190.61Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 360.965px 190.55px;" id="eljdsvjxggqf"
                        class="animable"></path>
                    <path d="M372,190.19a5.8,5.8,0,0,1-2.43.45,5.88,5.88,0,0,1-2.47-.07,11.77,11.77,0,0,1,4.9-.38Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 369.55px 190.412px;" id="elqc80pcw311f"
                        class="animable"></path>
                    <path d="M381.7,188.46a5.93,5.93,0,0,1-2.35.77,6.2,6.2,0,0,1-2.46.26,11.69,11.69,0,0,1,4.81-1Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 379.295px 188.989px;" id="el7frflm6nbl2"
                        class="animable"></path>
                    <path
                        d="M391.05,185.47a5.94,5.94,0,0,1-2.22,1.07,5.88,5.88,0,0,1-2.4.58,5.79,5.79,0,0,1,2.22-1.07A6.22,6.22,0,0,1,391.05,185.47Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 388.74px 186.295px;" id="el1crf6ip3u2k"
                        class="animable"></path>
                    <path d="M399.92,181.24a12,12,0,0,1-4.36,2.27,6.19,6.19,0,0,1,2.06-1.37A6,6,0,0,1,399.92,181.24Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 397.74px 182.375px;" id="eli691a8pjvig"
                        class="animable"></path>
                    <path
                        d="M408.09,175.79c.09.11-.73.85-1.84,1.65a6,6,0,0,1-2.14,1.23c-.08-.12.74-.86,1.84-1.66S408,175.67,408.09,175.79Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 406.101px 177.222px;" id="el2sj09kmmziw"
                        class="animable"></path>
                    <path
                        d="M415.31,169.13c.11.1-.59,1-1.55,1.92s-1.83,1.66-1.92,1.55.59-1,1.55-1.92S415.2,169,415.31,169.13Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 413.577px 170.863px;" id="el0p7oz0uftfxe"
                        class="animable"></path>
                    <path
                        d="M421.28,161.34c.13.07-.41,1-1.19,2.16s-1.51,2-1.62,1.87a6.23,6.23,0,0,1,1.19-2.17C420.44,162.1,421.16,161.26,421.28,161.34Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 419.885px 163.359px;" id="el60ofrv36w0o"
                        class="animable"></path>
                    <path d="M425.68,152.56a11.7,11.7,0,0,1-2,4.5,11,11,0,0,1,2-4.5Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 424.68px 154.81px;" id="elssbbzk42hlh"
                        class="animable"></path>
                    <path d="M428.28,143.1a6,6,0,0,1-.29,2.45,5.87,5.87,0,0,1-.8,2.34A11.65,11.65,0,0,1,428.28,143.1Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 427.747px 145.495px;" id="eljc8k74p76vi"
                        class="animable"></path>
                    <path d="M429.28,133.33a11.42,11.42,0,0,1-.31,4.9,6,6,0,0,1-.1-2.46A6.18,6.18,0,0,1,429.28,133.33Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 429.101px 135.78px;" id="elt40sfj3pr1r"
                        class="animable"></path>
                    <path
                        d="M428.79,123.53a11.41,11.41,0,0,1,.43,4.89,6.1,6.1,0,0,1-.47-2.42A6.22,6.22,0,0,1,428.79,123.53Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 428.98px 125.975px;" id="el49hftl8j0ud"
                        class="animable"></path>
                    <path
                        d="M426.8,113.91a6.08,6.08,0,0,1,.85,2.32,6,6,0,0,1,.34,2.45,6.08,6.08,0,0,1-.85-2.32A6.2,6.2,0,0,1,426.8,113.91Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 427.396px 116.295px;" id="el8xgvoq3auax"
                        class="animable"></path>
                    <path
                        d="M423.24,104.76a6,6,0,0,1,1.23,2.14,5.79,5.79,0,0,1,.75,2.36,6.24,6.24,0,0,1-1.23-2.15A6.06,6.06,0,0,1,423.24,104.76Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 424.23px 107.01px;" id="elzolzq2i5pb"
                        class="animable"></path>
                    <path
                        d="M418,96.45c.11-.09.83.74,1.62,1.86a6,6,0,0,1,1.19,2.16c-.12.08-.85-.76-1.62-1.86A6,6,0,0,1,418,96.45Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 419.405px 98.4593px;" id="elfoq4t7zi6s7"
                        class="animable"></path>
                    <path
                        d="M411.19,89.41c.09-.11,1,.49,2,1.42s1.68,1.81,1.58,1.91-.94-.61-1.93-1.53S411.1,89.52,411.19,89.41Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 412.981px 91.0732px;" id="elqwec64vq8t"
                        class="animable"></path>
                    <path d="M405.08,85.19c.07-.12.61.07,1.2.43s1,.75.93.87-.62-.07-1.2-.42S405,85.32,405.08,85.19Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 406.144px 85.84px;" id="elrf4dbflox9"
                        class="animable"></path>
                    <circle cx="377.96" cy="75.25" r="34.64"
                        style="fill: rgb(36, 106, 248); transform-origin: 377.96px 75.25px;" id="elb7so2vppdv"
                        class="animable"></circle>
                    <polygon
                        points="357.47 77.78 362.83 72.42 373.17 81.61 393.47 62.08 398.45 67.44 372.41 91.95 357.47 77.78"
                        style="fill: rgb(250, 250, 250); transform-origin: 377.96px 77.015px;" id="elk9amnk3dcfs"
                        class="animable"></polygon>
                </g>
                <g id="freepik--Character--inject-47" class="animable" style="transform-origin: 334.256px 298.862px;">
                    <path
                        d="M398.17,226.28l-5.1-18.69s-24,6.25-25.53,4.31c-8.71-10.77-13.11-25.57-14.48-30.88.19-.76.45-1.65.8-2.69a8.29,8.29,0,0,1,1.34-2.46,12.74,12.74,0,0,1,2.42-2.5,1.08,1.08,0,0,0,.41-1.47,1,1,0,0,0-.73-.53c-1-.07-3.52,1.45-5.41,4.34s-2.46-2.51-2.7-4.47-1.29-8-1.95-8.43c-1-.59-1.79.34-1.5,2.3s.74,7.9-.3,8-2.14-10-2.14-10,.11-2.18-1.1-2.13c-2.19.09-.22,10.67,0,11.68.15.69-1,.82-1.1.06s-.88-10-3.1-10c-1.71.06,1.53,8.72.62,10.73s-1.79-6.82-3.42-6.7c-.6,0-1.05.16.19,5.16a103,103,0,0,0,3.7,10.5H339s8.9,52.22,32,49.3C395.59,228.67,398.17,226.28,398.17,226.28Z"
                        style="fill: rgb(255, 190, 157); transform-origin: 366.386px 196.404px;" id="elha94w7z394p"
                        class="animable"></path>
                    <path
                        d="M363.32,278.09,216.75,267.42a7.54,7.54,0,0,1-7-8v0l6.56-90.05a7.54,7.54,0,0,1,8-7h0L371,173a7.55,7.55,0,0,1,7,8.06h0l-6.56,90.05a7.54,7.54,0,0,1-8.05,7Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 293.877px 220.242px;" id="elh5nnk5ustz"
                        class="animable"></path>
                    <path
                        d="M363.32,278.09c.45,0,.89,0,1.34,0a7.37,7.37,0,0,0,3.62-1.42,7.49,7.49,0,0,0,3-5.39c.18-2.54.39-5.47.62-8.76l4-55.77q.63-8.83,1.33-18.49c.12-1.6.23-3.23.35-4.86a12.45,12.45,0,0,0-.12-4.87,7.19,7.19,0,0,0-2.8-3.93,7.49,7.49,0,0,0-2.24-1.08,13.38,13.38,0,0,0-2.52-.33L325.69,170,224.4,162.59a7.28,7.28,0,0,0-5.85,2.29,7.19,7.19,0,0,0-1.62,2.77,13.17,13.17,0,0,0-.44,3.24q-.5,6.66-1,13.22-1,13.13-1.88,25.84c-1.24,16.94-2.44,33.29-3.58,48.85a7.46,7.46,0,0,0,1.32,5.36,7.27,7.27,0,0,0,4.58,2.92c3.73.37,7.51.57,11.19.87l21.45,1.57,38.52,2.84,55.76,4.14L358,277.66l4,.34,1.34.12s-.45,0-1.34-.07l-4-.26-15.16-1.05-55.78-4L248.57,270l-21.46-1.55c-3.69-.29-7.4-.48-11.24-.86a7.74,7.74,0,0,1-4.88-3.1,8,8,0,0,1-1.41-5.67c1.13-15.57,2.32-31.91,3.55-48.86q.92-12.71,1.87-25.84.48-6.57,1-13.22a14.17,14.17,0,0,1,.46-3.36,7.8,7.8,0,0,1,8-5.42l101.29,7.4,44.2,3.24a13.33,13.33,0,0,1,2.6.35,7.9,7.9,0,0,1,5.37,5.3,7.5,7.5,0,0,1,.29,2.54c0,.84-.11,1.65-.17,2.48-.12,1.63-.24,3.26-.36,4.86q-.71,9.65-1.36,18.48c-1.75,23.54-3.17,42.59-4.15,55.77-.25,3.29-.47,6.2-.66,8.75a7.57,7.57,0,0,1-3.12,5.46,7.28,7.28,0,0,1-3.67,1.39,5.57,5.57,0,0,1-1,0Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 293.867px 220.131px;" id="el4enej0hdi6r"
                        class="animable"></path>
                    <path d="M226.33,230l-.65,9-.92-.07.59-8.15-2.11-.15.06-.82Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 224.785px 234.405px;" id="elr6c0l42ena"
                        class="animable"></path>
                    <path
                        d="M235,238.85l-.07.82-6.29-.46v-.65l4-3.38c1.08-.93,1.32-1.51,1.36-2.13.08-1-.61-1.73-2-1.83a3,3,0,0,0-2.52.82l-.61-.61a4,4,0,0,1,3.27-1.05c1.82.13,2.91,1.14,2.8,2.64a3.75,3.75,0,0,1-1.68,2.7L230,238.49Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 231.82px 235.007px;" id="eliqx4mdb6i1"
                        class="animable"></path>
                    <path
                        d="M244.52,238l-1.79-.13-.18,2.36-.92-.07.17-2.36-5.06-.36v-.67l5.19-5.6,1,.07-5,5.46,3.9.29.15-2.08.9.06-.15,2.08,1.79.13Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 240.63px 235.7px;" id="elj52m72ozxtl"
                        class="animable"></path>
                    <path
                        d="M258.27,239l-1.79-.13-.18,2.36-.92-.07.17-2.35-5.06-.37v-.67l5.19-5.6,1,.08-5,5.45,3.9.29.15-2.08.9.07-.16,2.07,1.8.13Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 254.38px 236.7px;" id="elkmivw6x3ad"
                        class="animable"></path>
                    <path
                        d="M266.13,239.29c-.11,1.53-1.26,2.64-3.45,2.48a4.58,4.58,0,0,1-3.13-1.39l.5-.69a3.92,3.92,0,0,0,2.68,1.24c1.52.11,2.38-.58,2.46-1.67s-.58-1.92-2.86-2.09l-1.91-.14.79-4.46,4.91.36-.06.82-4.1-.3-.52,2.83,1.16.09C265.3,236.56,266.25,237.7,266.13,239.29Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 262.845px 237.178px;" id="el381lfnnx334"
                        class="animable"></path>
                    <path
                        d="M275,239.9a2.8,2.8,0,0,1-3,2.56l-.24,0c-2.39-.17-3.56-1.92-3.35-4.75.22-3.05,2-4.52,4.44-4.34a4.1,4.1,0,0,1,2.09.64l-.43.72a3.16,3.16,0,0,0-1.71-.55c-1.94-.14-3.27,1-3.45,3.44v.74a2.87,2.87,0,0,1,2.85-1.34A2.71,2.71,0,0,1,275,239.6,1.5,1.5,0,0,1,275,239.9Zm-.91,0c.09-1.18-.73-2-2.11-2.1a2.08,2.08,0,0,0-2.43,1.66s0,.09,0,.13c-.08,1,.68,2,2.23,2.1a2,2,0,0,0,2.31-1.64,1.23,1.23,0,0,0,0-.19Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 271.697px 237.912px;" id="elvetu6noovp"
                        class="animable"></path>
                    <path
                        d="M287.27,240.9c-.11,1.5-1.28,2.57-3.45,2.41a4.6,4.6,0,0,1-3.14-1.39l.5-.69a4,4,0,0,0,2.7,1.24c1.49.1,2.36-.53,2.44-1.64s-.63-1.84-2.29-2l-.64-.05.05-.68,2.71-2.93-4.59-.33.06-.82,5.77.42-.05.65-2.77,3C286.49,238.38,287.37,239.46,287.27,240.9Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 284.035px 238.673px;" id="elr85vpz68gw8"
                        class="animable"></path>
                    <path
                        d="M296.27,241.45a2.8,2.8,0,0,1-3,2.58,1.24,1.24,0,0,1-.27,0c-2.38-.17-3.56-1.92-3.35-4.75.22-3,2-4.52,4.44-4.34a4.1,4.1,0,0,1,2.09.64l-.43.72a3.08,3.08,0,0,0-1.71-.55c-1.94-.14-3.27,1-3.45,3.44v.74a2.87,2.87,0,0,1,2.85-1.34,2.72,2.72,0,0,1,2.83,2.6A1.41,1.41,0,0,1,296.27,241.45Zm-.91,0c.09-1.18-.73-2-2.11-2.1a2.08,2.08,0,0,0-2.43,1.66s0,.09,0,.13c-.08,1,.68,2,2.23,2.1a2,2,0,0,0,2.31-1.64,1.23,1.23,0,0,0,0-.19Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 292.951px 239.482px;" id="elo5jxzr6dgsj"
                        class="animable"></path>
                    <path d="M305,235.76l-.05.65-4.36,8-1-.07,4.29-7.88-4.61-.34-.13,1.68-.91-.06.19-2.5Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 301.615px 239.825px;" id="elv8v6e0wt3cn"
                        class="animable"></path>
                    <path d="M317.81,236.69l-.05.66-4.36,8-1-.07,4.28-7.88-4.61-.34-.12,1.68-.91-.07.18-2.5Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 314.425px 240.76px;" id="ely4v9z7nz81h"
                        class="animable"></path>
                    <path
                        d="M326.16,243.81c-.11,1.59-1.53,2.47-3.67,2.32s-3.39-1.24-3.27-2.83a2.26,2.26,0,0,1,1.89-2.08,2,2,0,0,1-1.27-2.07c.11-1.46,1.42-2.28,3.32-2.15s3.1,1.15,3,2.61a2,2,0,0,1-1.58,1.86A2.27,2.27,0,0,1,326.16,243.81Zm-.94-.08c.08-1.11-.82-1.87-2.41-2s-2.57.5-2.65,1.61.8,1.87,2.39,2S325.14,244.84,325.22,243.73ZM322.86,241c1.4.1,2.28-.47,2.35-1.44s-.77-1.7-2.11-1.79-2.26.45-2.33,1.45S321.47,240.91,322.86,241Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 322.689px 241.567px;" id="el1btibui26j2"
                        class="animable"></path>
                    <path
                        d="M335,242.38c-.22,3.05-2,4.52-4.44,4.34a4.3,4.3,0,0,1-2.09-.64l.42-.72a3.22,3.22,0,0,0,1.72.55c1.93.14,3.26-1,3.44-3.45v-.73a2.87,2.87,0,0,1-2.86,1.34,2.72,2.72,0,0,1-2.83-2.6,1.61,1.61,0,0,1,0-.31,2.81,2.81,0,0,1,3-2.56l.23,0C334.06,237.8,335.23,239.55,335,242.38Zm-1.14-1.88c.07-1-.68-2-2.23-2.09a2,2,0,0,0-2.31,1.63,1,1,0,0,0,0,.16c-.09,1.18.73,2,2.11,2.1a2.08,2.08,0,0,0,2.45-1.62l0-.18Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 331.69px 242.164px;" id="el73swgz32ucv"
                        class="animable"></path>
                    <g id="elx3i07nlpc7">
                        <rect x="325.47" y="219.04" width="3.91" height="72.05"
                            style="fill: rgb(250, 250, 250); transform-origin: 327.425px 255.065px; transform: rotate(-85.84deg);"
                            class="animable"></rect>
                    </g>
                    <g id="elj3jzhq4kujf">
                        <rect x="342.42" y="245.65" width="3.91" height="36.95"
                            style="fill: rgb(250, 250, 250); transform-origin: 344.375px 264.125px; transform: rotate(-85.84deg);"
                            class="animable"></rect>
                    </g>
                    <g id="elm3ir82vg1l">
                        <rect x="225.99" y="196.66" width="22.58" height="30.23" rx="4.96"
                            style="fill: rgb(69, 90, 100); transform-origin: 237.28px 211.775px; transform: rotate(-85.83deg);"
                            class="animable"></rect>
                    </g>
                    <path
                        d="M221.85,215.69l.11-1.44,15.52,1.13a3.26,3.26,0,1,0,.67-6.49H238l-15.52-1.13.1-1.45,15.53,1.13a4.71,4.71,0,0,1-.68,9.39Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 232.085px 211.572px;" id="elh9n0cc8kgkr"
                        class="animable"></path>
                    <g id="el9rdjxzdkca">
                        <rect x="246.29" y="207.46" width="1.45" height="10.68"
                            style="fill: rgb(36, 106, 248); transform-origin: 247.015px 212.8px; transform: rotate(-85.78deg);"
                            class="animable"></rect>
                    </g>
                    <g id="elvni9mh5oxmc">
                        <rect x="263.14" y="148.4" width="6.67" height="77.75"
                            style="fill: rgb(250, 250, 250); transform-origin: 266.475px 187.275px; transform: rotate(-85.83deg);"
                            class="animable"></rect>
                    </g>
                    <path
                        d="M407.48,163.6c-2.07,3.45-1.86,7.78-1.28,11.77s1.48,8.06.59,12c-.59,2.59-2,5.18-1.32,7.75.45,1.83,1.82,3.27,2.5,5,1,2.5.43,5.28.1,7.94s-.31,5.63,1.45,7.64c2.19,2.5,6.22,2.39,9.22,1s5.38-3.86,8.16-5.67,6.4-3,9.39-1.56c1.38.66,2.57,1.84,4.09,2,2.13.16,3.81-1.79,5.87-2.36,1.77-.48,3.66.11,5.48-.1,3.71-.41,6.45-4.41,5.93-8.1a9.08,9.08,0,0,0-7.52-7.29c-1.57-.26-3.46-.3-4.32-1.64-1.28-2,1-4.51.57-6.82-.28-1.66-1.86-2.77-3.41-3.45s-3.26-1.13-4.46-2.31c-2.15-2.1-1.91-5.54-2.57-8.48-1.09-4.84-5.62-14.75-15.48-15.72"
                        style="fill: rgb(38, 50, 56); transform-origin: 431.506px 186.439px;" id="elyzx4bzuvpx"
                        class="animable"></path>
                    <path
                        d="M402.91,439l.19-7.06,13.23.27-.17,10.33h-.82c-3.65.13-18.59.4-21-.39C391.62,441.3,402.91,439,402.91,439Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 405.124px 437.316px;" id="elvb686ct92js"
                        class="animable"></path>
                    <path d="M411.37,442.33a4.61,4.61,0,0,1,1.74-2.78,4.46,4.46,0,0,1,3.11-.9l-.07,3.69Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 413.795px 440.486px;" id="elywauqtv191e"
                        class="animable"></path>
                    <path
                        d="M397.39,440.31s-4,1.06-3.48,1.72,15.58,1,22.25.5v-.29l-17.61-.2S398.16,440.36,397.39,440.31Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 405.012px 441.54px;" id="elhaq54o08hm5"
                        class="animable"></path>
                    <path
                        d="M416.35,442.23h-.88l-2.4.06h-7.94c-3.1,0-5.91-.17-7.94-.28l-2.4-.15-.65-.05h.65l2.41.09c2,.08,4.83.18,7.93.24s5.9.07,7.93.06h3.29Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 405.245px 442.05px;" id="el1jc06ug0je9"
                        class="animable"></path>
                    <path d="M398.53,442.25a5.4,5.4,0,0,0-.43-1.16,5.53,5.53,0,0,0-.8-.94,2.15,2.15,0,0,1,1.23,2.1Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 397.918px 441.2px;" id="elr5s3l5o6ku"
                        class="animable"></path>
                    <path
                        d="M402.47,440.34a3,3,0,0,1-.41-.51c-.19-.3-.31-.58-.27-.6s.22.21.41.51S402.51,440.32,402.47,440.34Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 402.13px 439.784px;" id="elu585q9pqoq"
                        class="animable"></path>
                    <path
                        d="M403.55,439.8a2.13,2.13,0,0,1-.46-.32c-.23-.21-.38-.41-.35-.44s.24.11.46.32S403.58,439.77,403.55,439.8Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 403.145px 439.418px;" id="elyp5lpamso3"
                        class="animable"></path>
                    <path
                        d="M404.25,438.56c0,.05-.31.08-.69.08s-.69,0-.69-.09a1.47,1.47,0,0,1,.69-.07A1.62,1.62,0,0,1,404.25,438.56Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 403.56px 438.553px;" id="elwq26k79zmi"
                        class="animable"></path>
                    <path
                        d="M404.5,437.69a1.32,1.32,0,0,1-.77.21,1.27,1.27,0,0,1-.79-.13,5.08,5.08,0,0,1,.78,0A3,3,0,0,1,404.5,437.69Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 403.72px 437.802px;" id="elgx57omrlcpl"
                        class="animable"></path>
                    <path
                        d="M402,439.18a2.43,2.43,0,0,1-.85,0,5.38,5.38,0,0,1-.9-.22,2.91,2.91,0,0,1-.51-.22.51.51,0,0,1-.21-.27.35.35,0,0,1,.14-.34,1.57,1.57,0,0,1,1.92.5,1.35,1.35,0,0,1,.26.57v.23a2.29,2.29,0,0,0-.37-.73,1.55,1.55,0,0,0-.72-.49,1.29,1.29,0,0,0-1,.05c-.14.1-.09.26.06.35a4,4,0,0,0,.47.21,5.11,5.11,0,0,0,.87.25A7.79,7.79,0,0,1,402,439.18Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 400.763px 438.709px;" id="el6xafpxvgry"
                        class="animable"></path>
                    <path
                        d="M401.82,439.22a.81.81,0,0,1-.08-.59A1.3,1.3,0,0,1,402,438a.83.83,0,0,1,.72-.42.36.36,0,0,1,.25.4,1,1,0,0,1-.15.37,2.55,2.55,0,0,1-.41.51,1.31,1.31,0,0,1-.5.34,4.4,4.4,0,0,0,.42-.42,2.54,2.54,0,0,0,.36-.5c.12-.18.21-.5,0-.54s-.44.18-.57.35a1.25,1.25,0,0,0-.25.55A3.79,3.79,0,0,0,401.82,439.22Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 402.345px 438.4px;" id="ell6ejswesc9"
                        class="animable"></path>
                    <path
                        d="M416.15,438.61a5.19,5.19,0,0,0-1,0,4.14,4.14,0,0,0-3.52,2.7c-.21.56-.24.94-.27.94a1.22,1.22,0,0,1,0-.27,4,4,0,0,1,3.78-3.48,4.33,4.33,0,0,1,.72,0A1.27,1.27,0,0,1,416.15,438.61Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 413.751px 440.368px;" id="elsouxfyxmhv"
                        class="animable"></path>
                    <path
                        d="M414.89,433.08a20.55,20.55,0,0,1,.06,2.72,22.32,22.32,0,0,1-.1,2.71,46.13,46.13,0,0,1,0-5.43Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 414.87px 435.795px;" id="el1legki55tso"
                        class="animable"></path>
                    <path d="M409.73,441a7,7,0,0,1-1.94.15,7.81,7.81,0,0,1-1.93-.19s.87,0,1.94,0S409.72,441,409.73,441Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 407.795px 441.062px;" id="elifob5zlsxwj"
                        class="animable"></path>
                    <path
                        d="M412.32,441.06a4,4,0,0,1-.17.37c-.1.19-.14.38-.19.37s-.06-.21.05-.43S412.29,441,412.32,441.06Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 412.122px 441.424px;" id="elcqx9zjvl1ql"
                        class="animable"></path>
                    <path
                        d="M413.32,439.86a.84.84,0,0,1-.2.3c-.14.13-.27.22-.3.19s.05-.17.19-.3S413.29,439.83,413.32,439.86Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 413.067px 440.105px;" id="elmu48t5ki41"
                        class="animable"></path>
                    <path
                        d="M414.73,439.33c0,.05-.19,0-.38.11s-.34.16-.37.13.08-.21.32-.29S414.74,439.29,414.73,439.33Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 414.353px 439.413px;" id="el6h1im1aw0jh"
                        class="animable"></path>
                    <path
                        d="M415.73,439.09a.36.36,0,0,1-.17.15.4.4,0,0,1-.23,0,.31.31,0,0,1,.17-.15C415.61,439.05,415.71,439.05,415.73,439.09Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 415.53px 439.158px;" id="el69sekg34uz4"
                        class="animable"></path>
                    <path
                        d="M440.44,439l.19-7.06,13.22.27-.17,10.33h-.82c-3.65.13-18.58.4-21-.39C429.15,441.3,440.44,439,440.44,439Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 442.645px 437.316px;" id="elqxk2z7fzzz"
                        class="animable"></path>
                    <path d="M448.89,442.33a4.58,4.58,0,0,1,1.75-2.78,4.41,4.41,0,0,1,3.11-.9l-.08,3.69Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 451.32px 440.485px;" id="eldtyrh8sfnc6"
                        class="animable"></path>
                    <path
                        d="M434.92,440.31s-4,1.06-3.49,1.72,15.58,1,22.25.5v-.29l-17.62-.2S435.69,440.36,434.92,440.31Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 442.533px 441.54px;" id="el3tpd1if73qt"
                        class="animable"></path>
                    <path
                        d="M453.88,442.23H453l-2.41.06h-7.94c-3.1,0-5.91-.17-7.93-.28l-2.41-.15-.65-.05h.66l2.4.09c2,.08,4.83.18,7.93.24s5.91.07,7.94.06h3.29Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 442.77px 442.05px;" id="elu09q723b47o"
                        class="animable"></path>
                    <path
                        d="M436.05,442.25a5.37,5.37,0,0,0-.42-1.16,5.53,5.53,0,0,0-.8-.94A2.14,2.14,0,0,1,436.05,442.25Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 435.443px 441.2px;" id="elvs25jif1tf"
                        class="animable"></path>
                    <path
                        d="M440,440.34a2.71,2.71,0,0,1-.4-.51c-.18-.3-.31-.58-.27-.6s.22.21.4.51A2.53,2.53,0,0,1,440,440.34Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 439.661px 439.784px;" id="elrfy9pldao87"
                        class="animable"></path>
                    <path
                        d="M441.08,439.8a1.89,1.89,0,0,1-.46-.32c-.22-.21-.38-.41-.35-.44s.23.11.46.32S441.11,439.77,441.08,439.8Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 440.675px 439.418px;" id="el2lpat0asxa4"
                        class="animable"></path>
                    <path
                        d="M441.78,438.56c0,.05-.31.08-.69.08s-.69,0-.69-.09a1.47,1.47,0,0,1,.69-.07A1.62,1.62,0,0,1,441.78,438.56Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 441.09px 438.553px;" id="elyrz12p59qbb"
                        class="animable"></path>
                    <path
                        d="M442,437.69a1.43,1.43,0,0,1-.78.21,1.27,1.27,0,0,1-.79-.13,5.08,5.08,0,0,1,.78,0A3,3,0,0,1,442,437.69Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 441.215px 437.802px;" id="elugr20143mer"
                        class="animable"></path>
                    <path
                        d="M439.57,439.18a2.43,2.43,0,0,1-.85,0,5.38,5.38,0,0,1-.9-.22,2.39,2.39,0,0,1-.52-.22.45.45,0,0,1-.2-.27.36.36,0,0,1,.13-.34,1.57,1.57,0,0,1,1.92.5,1.5,1.5,0,0,1,.27.57.45.45,0,0,1,0,.23,2.32,2.32,0,0,0-.38-.73,1.47,1.47,0,0,0-.71-.49,1.33,1.33,0,0,0-1,.05c-.13.1-.08.26.06.35a2.06,2.06,0,0,0,.48.21,5.11,5.11,0,0,0,.87.25C439.24,439.15,439.57,439.15,439.57,439.18Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 438.333px 438.709px;" id="eledoh5xsuiol"
                        class="animable"></path>
                    <path
                        d="M439.35,439.22a.81.81,0,0,1-.09-.59,1.4,1.4,0,0,1,.25-.62.87.87,0,0,1,.71-.42.35.35,0,0,1,.26.4.87.87,0,0,1-.16.37,2.24,2.24,0,0,1-.41.51,1.21,1.21,0,0,1-.49.34,5.37,5.37,0,0,0,.41-.42,3.08,3.08,0,0,0,.37-.5c.12-.18.2-.5,0-.54s-.43.18-.57.35a1.61,1.61,0,0,0-.25.55A2.73,2.73,0,0,0,439.35,439.22Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 439.862px 438.405px;" id="el43vxaqmwu3a"
                        class="animable"></path>
                    <path
                        d="M453.68,438.61a5.24,5.24,0,0,0-1,0,4.15,4.15,0,0,0-3.52,2.7c-.21.56-.24.94-.27.94a.61.61,0,0,1,0-.27,3.47,3.47,0,0,1,.16-.71,4,4,0,0,1,3.61-2.77,4.45,4.45,0,0,1,.73,0A.79.79,0,0,1,453.68,438.61Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 451.277px 440.368px;" id="eln5ovekafdz"
                        class="animable"></path>
                    <path
                        d="M452.42,433.08a46.09,46.09,0,0,1,0,5.43,20.44,20.44,0,0,1-.06-2.71A22.41,22.41,0,0,1,452.42,433.08Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 452.42px 435.795px;" id="eld4lu78ts0fs"
                        class="animable"></path>
                    <path
                        d="M447.25,441a6.93,6.93,0,0,1-1.93.15,7.36,7.36,0,0,1-1.93-.19s.87,0,1.93,0S447.25,441,447.25,441Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 445.32px 441.062px;" id="elgpxdd5q3tqw"
                        class="animable"></path>
                    <path d="M449.84,441.06s-.07.18-.16.37-.15.38-.19.37-.06-.21,0-.43S449.82,441,449.84,441.06Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 449.646px 441.424px;" id="ely9kkpr490ui"
                        class="animable"></path>
                    <path
                        d="M450.85,439.86a.84.84,0,0,1-.2.3c-.14.13-.28.22-.31.19s.06-.17.2-.3S450.81,439.83,450.85,439.86Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 450.592px 440.105px;" id="elhzmj8ys9mk5"
                        class="animable"></path>
                    <path
                        d="M452.25,439.33c0,.05-.18,0-.38.11s-.33.16-.37.13.08-.21.32-.29S452.27,439.29,452.25,439.33Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 451.872px 439.413px;" id="elf2lj40wi4ic"
                        class="animable"></path>
                    <path
                        d="M453.25,439.09a.36.36,0,0,1-.17.15.41.41,0,0,1-.23,0s.07-.11.18-.15S453.24,439.05,453.25,439.09Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 453.05px 439.158px;" id="elnsx4byrjsh"
                        class="animable"></path>
                    <path
                        d="M400.24,257.55l-6.34,94.51v85.23h25.34s1.07-73.5.4-78.31c0,0,4.14-73.62,4.61-72.57,1,2.15.94,64.73,2.36,72.48s8,78.4,8,78.4H459l-8.2-81c-.17-9.76-2.68-95.47-2.68-95.47Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 426.45px 347.42px;" id="elcwut0gpry7e"
                        class="animable"></path>
                    <path
                        d="M458.45,432.45a1.78,1.78,0,0,1-.94.33,5.47,5.47,0,0,1-2.68-.44,17.11,17.11,0,0,0-3.67-1.32c-1.43-.21-2.92.54-4.34,1.49a10.51,10.51,0,0,1-4.47,2.06,9.38,9.38,0,0,1-4-.49,22.46,22.46,0,0,1-2.5-1,3.14,3.14,0,0,1-.85-.49c0-.09,1.31.52,3.45,1.16a9.59,9.59,0,0,0,3.84.36,10.22,10.22,0,0,0,4.25-2,13,13,0,0,1,2.26-1.22,4.88,4.88,0,0,1,2.42-.3A15.78,15.78,0,0,1,455,432a5.8,5.8,0,0,0,2.52.57C458.11,432.55,458.43,432.4,458.45,432.45Z"
                        style="fill: rgb(69, 90, 100); transform-origin: 446.725px 432.581px;" id="elezc12u9kmje"
                        class="animable"></path>
                    <path
                        d="M419.45,431.86a7.1,7.1,0,0,0-.8-.65,3.82,3.82,0,0,0-2.67-.4,11,11,0,0,0-3.72,1.87A13,13,0,0,1,410,433.9a5.22,5.22,0,0,1-2.79.33c-1.92-.33-3.44-1.33-5-1.67a8.14,8.14,0,0,0-4.1.18c-2.3.69-3.65,1.4-3.69,1.3a4,4,0,0,1,.92-.54,18.38,18.38,0,0,1,2.67-1.12,8.21,8.21,0,0,1,4.31-.29c1.63.35,3.17,1.34,4.93,1.63s3.37-.62,4.7-1.45a10.77,10.77,0,0,1,3.91-1.82,3.91,3.91,0,0,1,2.86.59A1.71,1.71,0,0,1,419.45,431.86Z"
                        style="fill: rgb(69, 90, 100); transform-origin: 406.935px 432.34px;" id="elcmdn9dlo3sb"
                        class="animable"></path>
                    <path
                        d="M446.41,277.15a3.11,3.11,0,0,1-1.48.5,9,9,0,0,1-7.11-2c-.74-.63-1.07-1.14-1-1.18a11.4,11.4,0,0,0,9.61,2.65Z"
                        style="fill: rgb(69, 90, 100); transform-origin: 441.62px 276.11px;" id="elq29eshgpmm9"
                        class="animable"></path>
                    <path
                        d="M404.34,273.46c.06,0,.06.51-.2,1.25a6.22,6.22,0,0,1-1.71,2.52,6.45,6.45,0,0,1-2.7,1.42c-.77.17-1.26.11-1.26.05a8.12,8.12,0,0,0,5.87-5.24Z"
                        style="fill: rgb(69, 90, 100); transform-origin: 401.421px 276.111px;" id="el1wbkgb8i2la"
                        class="animable"></path>
                    <path d="M344.45,238.63l-.66,9-.92-.06.59-8.15-2.11-.16.06-.82Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 342.9px 243.035px;" id="elqbfgwa2t82"
                        class="animable"></path>
                    <path
                        d="M353.08,247.45l-.06.82-6.29-.45v-.66l4-3.38c1.08-.92,1.32-1.51,1.37-2.13.07-1-.61-1.73-2-1.83a3.08,3.08,0,0,0-2.52.82L347,240a4,4,0,0,1,3.27-1.05c1.82.13,2.91,1.14,2.8,2.64-.06.86-.39,1.61-1.68,2.7l-3.26,2.78Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 349.905px 243.592px;" id="elusmb6ouosi"
                        class="animable"></path>
                    <path
                        d="M361.25,246.29c-.11,1.49-1.28,2.57-3.44,2.41a4.62,4.62,0,0,1-3.15-1.39l.5-.7a3.89,3.89,0,0,0,2.71,1.24c1.48.11,2.35-.52,2.44-1.63s-.63-1.84-2.3-2h-.64l.05-.68,2.72-2.93-4.59-.33.06-.82,5.76.42v.65l-2.77,3C360.47,243.77,361.36,244.85,361.25,246.29Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 358.015px 244.088px;" id="eli7npdbcp1k"
                        class="animable"></path>
                    <path d="M408.5,158.32a8.91,8.91,0,0,0-2.53,6.94,16,16,0,0,0,2.41,7.15"
                        style="fill: rgb(38, 50, 56); transform-origin: 407.222px 165.365px;" id="eleub11tkp8xl"
                        class="animable"></path>
                    <path
                        d="M430.33,197.41l1.36-31.33-12.57-9.52-11.42,5.58s-.38,14.34,0,20.56,6.65,6.88,6.65,6.88-.18,3.43-.38,7a8.21,8.21,0,0,0,7.61,8.61h0a8.19,8.19,0,0,0,8.74-7.6C430.32,197.53,430.33,197.47,430.33,197.41Z"
                        style="fill: rgb(255, 190, 157); transform-origin: 419.611px 180.885px;" id="elttiu8vdmgoo"
                        class="animable"></path>
                    <path d="M409.74,172.6a.8.8,0,1,0,.8-.8h0A.8.8,0,0,0,409.74,172.6Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 410.54px 172.6px;" id="el3adr6c1kuur"
                        class="animable"></path>
                    <path
                        d="M408.18,171.73c.1.1.69-.4,1.54-.45s1.5.37,1.59.26-.06-.24-.34-.44a2.07,2.07,0,0,0-1.28-.33,2,2,0,0,0-1.22.49C408.21,171.48,408.13,171.68,408.18,171.73Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 409.751px 171.254px;" id="el3p9dcyomds9"
                        class="animable"></path>
                    <path d="M419,172.6a.79.79,0,0,0,.79.79h0a.8.8,0,1,0-.79-.81Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 419.8px 172.59px;" id="elach6iie9w7r"
                        class="animable"></path>
                    <path
                        d="M417.68,171.73c.1.1.69-.4,1.54-.45s1.5.37,1.59.26-.06-.24-.34-.44a2.13,2.13,0,0,0-2.51.16C417.71,171.48,417.63,171.68,417.68,171.73Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 419.251px 171.254px;" id="elnal1di5dnuc"
                        class="animable"></path>
                    <path d="M417.41,179.78a16,16,0,0,1-4.14,1.42,2.42,2.42,0,0,0,2.84.81,1.75,1.75,0,0,0,1.33-2.1Z"
                        style="fill: rgb(250, 250, 250); transform-origin: 415.377px 180.981px;" id="el6ky1y6x4krp"
                        class="animable"></path>
                    <path d="M414.35,189.58a15.52,15.52,0,0,0,8.24-2.78s-1.87,4.57-8.1,4.31Z"
                        style="fill: rgb(235, 153, 110); transform-origin: 418.47px 188.96px;" id="elan462sc2aa7"
                        class="animable"></path>
                    <path
                        d="M414.58,179a6,6,0,0,0-1.4-.17c-.22,0-.43,0-.48-.2a1.22,1.22,0,0,1,.13-.7c.18-.56.38-1.15.58-1.77.41-1.27.76-2.41,1-3.25a5,5,0,0,0,.31-1.38,6.15,6.15,0,0,0-.54,1.3c-.3.82-.69,2-1.1,3.22-.19.63-.38,1.22-.56,1.79a1.43,1.43,0,0,0-.08.89.51.51,0,0,0,.36.31,1.15,1.15,0,0,0,.37,0A5.13,5.13,0,0,0,414.58,179Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 413.561px 175.3px;" id="elawyg87zl077"
                        class="animable"></path>
                    <path
                        d="M430.77,177.22a7.6,7.6,0,0,1,.34-3.07,2.86,2.86,0,0,1,2.23-1.93,2.44,2.44,0,0,1,2.53,2,3,3,0,0,1-1.54,3,4,4,0,0,1-3.46.09"
                        style="fill: rgb(255, 190, 157); transform-origin: 433.314px 174.938px;" id="elummxbwe7i1h"
                        class="animable"></path>
                    <path
                        d="M432.59,176.31c0-.07.33.09.77-.05a1.38,1.38,0,0,0,.93-1.32,1,1,0,0,0-.22-.83,1,1,0,0,0-.68-.2c-.46,0-.79.16-.82.09s.21-.29.77-.45a1.23,1.23,0,0,1,1,.2,1.44,1.44,0,0,1,.43,1.23,2,2,0,0,1-.46,1.16,1.46,1.46,0,0,1-.92.48C432.82,176.68,432.53,176.35,432.59,176.31Z"
                        style="fill: rgb(235, 153, 110); transform-origin: 433.675px 175.072px;" id="elyzwnxdlqpmo"
                        class="animable"></path>
                    <path
                        d="M407.79,158.93c-2.76,3.43.92,5.59,2.75,7,1.41,1.1,5.57,4,9.22,2.63-1.29-1.73-2.76-2.49-3.33-4.14,1.49,2.1,3.06,3.69,5.62,4-.51-1.49-1.23-4.52-.68-4.64.68,5.92,6.23,10.9,10.05,9a12.69,12.69,0,0,0-1.18-11.42,14.41,14.41,0,0,0-9.77-6.23,15.47,15.47,0,0,0-12.68,3.8"
                        style="fill: rgb(38, 50, 56); transform-origin: 419.53px 164.072px;" id="eli13gj0e8lmh"
                        class="animable"></path>
                    <path
                        d="M434,177.79c0-.06.47.39.28,1.24a1.69,1.69,0,0,1-.92,1.13,2,2,0,0,1-1.8-.07,2.12,2.12,0,0,1-1-1.51,2,2,0,0,1,.36-1.41c.5-.68,1.06-.75,1.06-.7a3.66,3.66,0,0,0-.75.9,1.74,1.74,0,0,0-.19,1.14,1.65,1.65,0,0,0,.75,1.13,1.57,1.57,0,0,0,1.34.09,1.37,1.37,0,0,0,.77-.81A2.88,2.88,0,0,0,434,177.79Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 432.435px 178.399px;" id="elebg52gjtq1m"
                        class="animable"></path>
                    <path
                        d="M390.77,229.31l9.38-1.95L403,243.14a253,253,0,0,0-6,24.58l22,13.73,3.39-6.44,5.43,5.16,23.41-12.45c-2.89-15-10.19-18.92-10.19-21.36,0-7-1-.2,4.87-23.39s-15.55-25.56-15.55-25.56.48,3.24-16.56.15c-6.24-1.13-31.15,11.95-31.15,11.95Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 416.94px 239.43px;" id="ell3pxe86oxo"
                        class="animable"></path>
                    <path d="M413.77,197.56s-.2,17.16,3.89,16,12.33-8.49,12.67-16.19Z"
                        style="fill: rgb(255, 190, 157); transform-origin: 422.049px 205.493px;" id="elfta5fsbgrkg"
                        class="animable"></path>
                    <path
                        d="M414.81,227.63a37.46,37.46,0,0,1,.35-6.08,34.74,34.74,0,0,1,.88-6,36.49,36.49,0,0,1-.36,6.09A35.6,35.6,0,0,1,414.81,227.63Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 415.425px 221.59px;" id="eltekksclvc8"
                        class="animable"></path>
                    <path
                        d="M417.42,226.24a23.38,23.38,0,0,1-.39-4.87,23.51,23.51,0,0,1,.13-4.89,23.47,23.47,0,0,1,.39,4.88A22.13,22.13,0,0,1,417.42,226.24Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 417.294px 221.36px;" id="elzxl7jt0hv7"
                        class="animable"></path>
                    <path
                        d="M413.75,229.31c-.14,0-.24-.44,0-.93s.63-.71.72-.6-.07.43-.24.81S413.9,229.32,413.75,229.31Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 414.051px 228.531px;" id="el1y63so6sq9y"
                        class="animable"></path>
                    <path
                        d="M414.31,229.31c-.14,0-.19-.36-.12-.75s.26-.67.4-.64.19.36.12.75S414.45,229.34,414.31,229.31Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 414.45px 228.615px;" id="elmth88ojkwc"
                        class="animable"></path>
                    <path d="M414.84,229.32c-.14,0-.29-.29-.33-.68s.05-.71.2-.72.29.29.32.67S415,229.3,414.84,229.32Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 414.769px 228.62px;" id="el21iz7al7z44"
                        class="animable"></path>
                    <path
                        d="M415.71,229.59c-.15,0-.26-.5-.52-1s-.56-.94-.46-1.06.63.18.94.84S415.85,229.6,415.71,229.59Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 415.285px 228.547px;" id="el7j45tf0omqn"
                        class="animable"></path>
                    <path d="M417.52,227.78c-.13.05-.4-.38-.4-1s.27-1,.4-1,.12.47.12,1S417.66,227.73,417.52,227.78Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 417.38px 226.782px;" id="elb2qej5h4g3q"
                        class="animable"></path>
                    <path d="M418.06,227.5c-.14,0-.29-.32-.33-.74s0-.78.19-.79.29.32.33.74S418.2,227.49,418.06,227.5Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 417.988px 226.735px;" id="elxgiozx1syma"
                        class="animable"></path>
                    <path
                        d="M418.91,227.36c-.11.09-.42-.12-.69-.47s-.4-.7-.28-.78.42.12.69.46S419,227.27,418.91,227.36Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 418.419px 226.737px;" id="elx95frs32k3r"
                        class="animable"></path>
                    <path d="M419.19,227.08c-.13.06-.38-.2-.7-.48s-.6-.49-.55-.63.5-.12.9.24S419.32,227,419.19,227.08Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 418.591px 226.489px;" id="elqbgn2tifhhn"
                        class="animable"></path>
                    <path
                        d="M412.52,199.45c0-.06.3-.21.65.11a.84.84,0,0,1-.09,1.18.82.82,0,0,1-1.18-.09.66.66,0,0,1-.12-.17.88.88,0,0,1,.11-.8c.29-.38.64-.29.62-.23a1.42,1.42,0,0,0-.3.42c-.1.27,0,.63.41.58s.44-.4.28-.65S412.53,199.53,412.52,199.45Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 412.55px 200.156px;" id="elkk8byz5nr5"
                        class="animable"></path>
                    <path
                        d="M412.92,202.68c-.09.11-.37,0-.64-.14s-.42-.44-.34-.56.37-.06.64.14S413,202.56,412.92,202.68Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 412.43px 202.322px;" id="elpw4l8asnbe"
                        class="animable"></path>
                    <path d="M413.18,203.36c.12.09,0,.44-.4.59s-.73,0-.7-.15.26-.23.51-.33S413.07,203.27,413.18,203.36Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 412.651px 203.669px;" id="el9qcjefivyas"
                        class="animable"></path>
                    <path d="M413.2,205.05c.11.09,0,.35-.15.58s-.44.35-.55.25-.05-.35.15-.58S413.08,205,413.2,205.05Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 412.845px 205.475px;" id="el9ru6mwllb2v"
                        class="animable"></path>
                    <path
                        d="M412.77,206.88c0-.06.4-.2.87.23a1,1,0,0,1,.27,1,1.14,1.14,0,0,1-1.06.82,1.11,1.11,0,0,1-1-.86.91.91,0,0,1,.45-1c.58-.32,1,0,.9.05a1.52,1.52,0,0,0-.69.25.52.52,0,0,0-.19.58.66.66,0,0,0,.58.45.68.68,0,0,0,.64-.73.73.73,0,0,0-.14-.38C413.1,207,412.76,207,412.77,206.88Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 412.888px 207.87px;" id="elm05yupsyt29"
                        class="animable"></path>
                    <path
                        d="M413.89,209.79c.07.13-.15.37-.39.64s-.44.52-.58.47-.12-.45.19-.81S413.83,209.66,413.89,209.79Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 413.37px 210.318px;" id="elsr5z5c98f5b"
                        class="animable"></path>
                    <path d="M414.45,211.6c.13.05.11.45-.2.81s-.71.43-.78.31.15-.38.39-.65S414.31,211.55,414.45,211.6Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 413.991px 212.184px;" id="el0auhip1mm0bl"
                        class="animable"></path>
                    <path d="M414.75,214.53c-.14,0-.29-.32-.32-.75s0-.77.19-.79.29.32.32.75S414.9,214.52,414.75,214.53Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 414.683px 213.76px;" id="elmcocoj5f3ml"
                        class="animable"></path>
                    <path d="M419.61,215c-.07.12-.35.1-.62,0s-.43-.38-.36-.51.35-.1.62,0S419.68,214.82,419.61,215Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 419.12px 214.743px;" id="el0r945naua58"
                        class="animable"></path>
                    <path d="M421.3,213c.1.1-.07.43-.37.74s-.64.48-.74.38.06-.43.37-.74S421.19,212.91,421.3,213Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 420.745px 213.562px;" id="elvexcym3flms"
                        class="animable"></path>
                    <path
                        d="M422.68,211.88c0-.08.26-.12.64-.11h.05l.07.06a.77.77,0,0,1,.21.69.73.73,0,0,1-.65.6.8.8,0,0,1-.81-.49.66.66,0,0,1,.16-.74c.33-.3.64-.15.6-.09s-.2.1-.31.32a.31.31,0,0,0,0,.32.36.36,0,0,0,.33.16c.21,0,.31-.37.2-.5l.12.06C422.9,212.06,422.67,212,422.68,211.88Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 422.901px 212.416px;" id="elwi3l7rlii5"
                        class="animable"></path>
                    <path
                        d="M424.11,211.61c-.14,0-.2-.37-.12-.75s.26-.67.4-.65.19.37.11.75S424.25,211.64,424.11,211.61Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 424.246px 210.911px;" id="eljh5etwg0k2i"
                        class="animable"></path>
                    <path
                        d="M426.3,210.07c-.05.13-.38.11-.73,0s-.58-.39-.52-.52.39-.11.73,0S426.36,209.94,426.3,210.07Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 425.675px 209.81px;" id="elc1k7ld8hgkv"
                        class="animable"></path>
                    <path
                        d="M426.55,208.17c.06,0,.05.18.17.31s.27.16.38,0,0-.28-.16-.34a.7.7,0,0,0-.36,0c-.06,0,0-.28.34-.35a.62.62,0,0,1,.58.2.65.65,0,0,1,.05.78.67.67,0,0,1-.72.32.6.6,0,0,1-.44-.42C426.29,208.29,426.5,208.12,426.55,208.17Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 427.01px 208.442px;" id="elm44n6clha1h"
                        class="animable"></path>
                    <path d="M428.08,206.59a.5.5,0,0,1-.29-.83c.1,0,.31.1.39.33S428.21,206.55,428.08,206.59Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 427.939px 206.175px;" id="elfbqjf1x08vw"
                        class="animable"></path>
                    <path
                        d="M429.51,205.19c-.07.12-.35.1-.62-.06s-.43-.38-.35-.5.34-.1.61.05S429.58,205.06,429.51,205.19Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 429.023px 204.91px;" id="eljlbjolobv2k"
                        class="animable"></path>
                    <path
                        d="M430.49,203.09c.06.14-.18.37-.52.52s-.68.17-.74,0,.18-.36.52-.51A.76.76,0,0,1,430.49,203.09Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 429.86px 203.364px;" id="elo9blth92uw"
                        class="animable"></path>
                    <path
                        d="M430.94,200.58c0-.05.19-.24.53-.06a.66.66,0,0,1,.34.55.73.73,0,0,1-1.27.49.65.65,0,0,1-.11-.64c.13-.35.41-.37.42-.3s-.08.18-.06.37.14.36.36.28.22-.28.09-.45S431,200.65,430.94,200.58Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 431.1px 201.121px;" id="el74iqs3ami1v"
                        class="animable"></path>
                    <path d="M432.31,198.39c0,.14-.22.32-.57.4s-.65,0-.68-.11.22-.32.57-.4S432.28,198.25,432.31,198.39Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 431.684px 198.532px;" id="el3qdvc6l8ahr"
                        class="animable"></path>
                    <path d="M430.91,197.66l.55-.42"
                        style="fill: rgb(38, 50, 56); transform-origin: 431.185px 197.45px;" id="eltc46y6wb89"
                        class="animable"></path>
                    <path d="M385.49,211.92c-.13,0-.18-.29-.09-.55s.26-.43.39-.39.18.29.1.55S385.63,212,385.49,211.92Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 385.641px 211.456px;" id="elizs75yoqfx"
                        class="animable"></path>
                    <path
                        d="M386.69,213.37c0-.06.18-.25.54-.09a.7.7,0,0,1,0,1.28.73.73,0,0,1-.84-.1.7.7,0,0,1-.2-.63c.07-.39.36-.45.38-.39s-.06.2,0,.4.2.38.45.26.2-.34,0-.51S386.72,213.44,386.69,213.37Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 386.912px 213.933px;" id="elk2qu0zanx1"
                        class="animable"></path>
                    <path
                        d="M388.18,216.64c-.06.13-.37.13-.7,0s-.54-.35-.49-.48.37-.13.7,0S388.23,216.51,388.18,216.64Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 387.585px 216.4px;" id="elz8kpavr1otp"
                        class="animable"></path>
                    <path
                        d="M388.55,218.64c-.05.14-.29.18-.55.1s-.43-.26-.39-.4.29-.18.55-.09S388.59,218.51,388.55,218.64Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 388.08px 218.491px;" id="el61u3ahl3krf"
                        class="animable"></path>
                    <path d="M389.16,220c.12.07.09.36-.08.64s-.4.46-.52.38-.09-.36.07-.64A.65.65,0,0,1,389.16,220Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 388.86px 220.52px;" id="el3w4bdiai8ee"
                        class="animable"></path>
                    <path
                        d="M389.52,221.39c-.07,0,.17-.37.68-.23a.92.92,0,0,1,.63.6.82.82,0,0,1-.52,1,1,1,0,0,1-1.07-.21.71.71,0,0,1,0-.93.44.44,0,0,1,.62,0h0c.11.13.06.23,0,.23a.17.17,0,0,1-.15-.06.15.15,0,0,0-.22.08.32.32,0,0,0,.09.36.55.55,0,0,0,.53.06c.41-.15.24-.61-.06-.76S389.57,221.45,389.52,221.39Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 389.964px 221.98px;" id="elsl4y46le1wa"
                        class="animable"></path>
                    <path d="M391,224c.1.1,0,.33-.18.51s-.43.22-.53.12,0-.34.18-.51S390.87,223.87,391,224Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 390.645px 224.31px;" id="elz245i3489pi"
                        class="animable"></path>
                    <path d="M391.54,225.72c.11.1,0,.35-.17.56s-.45.31-.56.21,0-.35.18-.56S391.44,225.62,391.54,225.72Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 391.175px 226.105px;" id="el90wytst4hga"
                        class="animable"></path>
                    <path
                        d="M401.75,270.25c-.12.07-.39-.16-.58-.52s-.26-.7-.14-.77.39.16.59.52S401.88,270.18,401.75,270.25Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 401.395px 269.605px;" id="elp59z2tii7m"
                        class="animable"></path>
                    <path
                        d="M402.62,270.25c-.13.06-.37-.18-.53-.54s-.18-.69,0-.75.37.18.53.54S402.75,270.19,402.62,270.25Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 402.346px 269.605px;" id="elfzu70t0yux5"
                        class="animable"></path>
                    <path
                        d="M403.85,270.9v.32c0,.15.15.21.29.13s.13-.19,0-.32-.23-.11-.27-.18.12-.25.44-.15a.6.6,0,0,1,.39.74.61.61,0,0,1-.3.35.63.63,0,0,1-.74,0,.61.61,0,0,1-.19-.54C403.58,270.88,403.83,270.83,403.85,270.9Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 404.094px 271.29px;" id="elur3zijz4f3t"
                        class="animable"></path>
                    <path d="M406.93,271.55c.09.11-.1.4-.42.64s-.64.34-.73.22.1-.4.42-.64S406.85,271.43,406.93,271.55Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 406.355px 271.98px;" id="el4qq7v7btrw"
                        class="animable"></path>
                    <path
                        d="M407.94,272.55c.06.13-.08.33-.31.45s-.49.11-.55,0,.07-.33.31-.45S407.88,272.43,407.94,272.55Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 407.51px 272.773px;" id="elknefqe1rnj"
                        class="animable"></path>
                    <path
                        d="M409.36,274.14c-.15,0-.29-.19-.34-.47s.05-.52.19-.54.29.19.33.47S409.5,274.12,409.36,274.14Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 409.279px 273.634px;" id="elmfkghasc2cs"
                        class="animable"></path>
                    <path
                        d="M411.65,274.11a.8.8,0,0,0,0,.39c.06.2.19.34.41.21s.16-.32,0-.46-.32-.1-.36-.16.12-.28.5-.18a.68.68,0,0,1,.47.46.73.73,0,0,1-.55.87.72.72,0,0,1-.62-.14.68.68,0,0,1-.21-.62C411.34,274.09,411.63,274,411.65,274.11Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 411.983px 274.572px;" id="eltkabh0e025"
                        class="animable"></path>
                    <path
                        d="M414.37,275.16c.1.11-.05.39-.33.63s-.58.35-.67.24.05-.39.33-.63S414.28,275.05,414.37,275.16Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 413.872px 275.595px;" id="el9f79mrrlq0p"
                        class="animable"></path>
                    <path
                        d="M416.17,276.23c.1.1-.06.41-.43.58s-.72.08-.73-.07.23-.28.51-.41S416.06,276.12,416.17,276.23Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 415.604px 276.54px;" id="el8crzzl2926e"
                        class="animable"></path>
                    <path d="M417.53,278.18c-.14.05-.32-.11-.4-.35s0-.47.1-.51.32.11.4.35S417.66,278.14,417.53,278.18Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 417.383px 277.751px;" id="el71wnefr4lab"
                        class="animable"></path>
                    <path
                        d="M419.07,277.26c-.06,0,.06-.3.44-.28a.62.62,0,0,1,.25,1.17.64.64,0,0,1-.84-.11.63.63,0,0,1-.05-.66c.19-.34.51-.27.48-.2a.69.69,0,0,0-.13.33c0,.18.08.3.27.19s.12-.25-.06-.36S419.13,277.31,419.07,277.26Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 419.448px 277.619px;" id="elojr550on4l"
                        class="animable"></path>
                    <path
                        d="M420.51,275.86c-.12.08-.33,0-.47-.21s-.15-.43,0-.51.33,0,.47.21S420.63,275.78,420.51,275.86Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 420.269px 275.5px;" id="eljdemfo0yr6h"
                        class="animable"></path>
                    <path
                        d="M421.22,274.71c-.1.1-.31.06-.47-.1s-.21-.37-.11-.47.32-.06.48.1S421.32,274.61,421.22,274.71Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 420.931px 274.425px;" id="elq1z0l1w06la"
                        class="animable"></path>
                    <path
                        d="M422,272.51c-.07,0,.08-.27.39-.16a.5.5,0,0,1,.33.44.59.59,0,0,1-.63.54.57.57,0,0,1-.45-.26.52.52,0,0,1,0-.51c.12-.26.34-.27.36-.21a1.46,1.46,0,0,1,0,.3.21.21,0,0,0,.07.15h.2v-.11S422.08,272.56,422,272.51Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 422.147px 272.826px;" id="el2yprthggfct"
                        class="animable"></path>
                    <path
                        d="M423.6,274.14a.32.32,0,0,1-.18-.39.29.29,0,0,1,.32-.26h0a.31.31,0,0,1,.18.38A.32.32,0,0,1,423.6,274.14Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 423.67px 273.814px;" id="elf0yo3gl9x68"
                        class="animable"></path>
                    <path
                        d="M424.33,275a.46.46,0,0,1-.12-.43.38.38,0,0,1,.26-.36c.14,0,.31.17.26.45S424.44,275.09,424.33,275Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 424.468px 274.618px;" id="el5vaqxfinc5s"
                        class="animable"></path>
                    <path
                        d="M425.34,276.16a.42.42,0,0,1-.44.12.38.38,0,0,1-.36-.27c0-.14.18-.3.46-.25S425.41,276,425.34,276.16Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 424.949px 276.025px;" id="elxmiue321x5r"
                        class="animable"></path>
                    <path
                        d="M426.16,277.14c-.05-.05.08-.25.39-.2a.6.6,0,0,1,.43.36.6.6,0,0,1-.41.74.61.61,0,0,1-.59-.15.5.5,0,0,1,0-.57c.16-.3.44-.22.41-.15a.48.48,0,0,0-.07.27c0,.13,0,.13.06.13h.1c.1,0,.07-.06.08-.09a.24.24,0,0,0-.09-.15C426.32,277.2,426.2,277.2,426.16,277.14Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 426.447px 277.497px;" id="el22mfs2sbxbu"
                        class="animable"></path>
                    <path
                        d="M427.44,279.12a.31.31,0,0,1-.22-.36.28.28,0,0,1,.29-.29.29.29,0,0,1,.23.34h0A.32.32,0,0,1,427.44,279.12Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 427.48px 278.795px;" id="el49bmv51jkz4"
                        class="animable"></path>
                    <path d="M429.38,278.09c0,.14-.28.21-.56.14s-.48-.23-.45-.37.29-.2.57-.14S429.41,278,429.38,278.09Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 428.875px 277.977px;" id="el646gw0pgpru"
                        class="animable"></path>
                    <path
                        d="M430.11,277.74a.33.33,0,0,1-.29-.33c0-.2.08-.38.23-.39s.27.14.29.34S430.26,277.73,430.11,277.74Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 430.081px 277.38px;" id="elo9tsm9ve8zm"
                        class="animable"></path>
                    <path
                        d="M431.47,276.66c-.14,0-.26-.16-.26-.36s.12-.36.26-.36.26.16.26.36S431.62,276.66,431.47,276.66Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 431.47px 276.3px;" id="el13sy2zguxjph"
                        class="animable"></path>
                    <path
                        d="M432.52,275.19c0-.05.18-.25.51-.05a.58.58,0,0,1,.27.58.61.61,0,0,1-.66.5.58.58,0,0,1-.28-1.11c.34-.17.55.06.49.11s-.18,0-.28.19a.27.27,0,0,0-.07.21.26.26,0,0,0,.16.08c.1,0,.15,0,.17-.07a.74.74,0,0,0,0-.21C432.83,275.35,432.55,275.25,432.52,275.19Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 432.659px 275.636px;" id="el4ta9lpv9w8s"
                        class="animable"></path>
                    <path
                        d="M435.23,274.35c-.11.11-.3.08-.49.06s-.39-.08-.45-.21.16-.37.53-.31S435.33,274.26,435.23,274.35Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 434.771px 274.155px;" id="ela951gu2i9m7"
                        class="animable"></path>
                    <path
                        d="M436.6,273.63c-.07.13-.35.12-.65.07s-.56-.14-.58-.29.29-.3.67-.23S436.67,273.51,436.6,273.63Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 435.99px 273.448px;" id="el4armbgqihzv"
                        class="animable"></path>
                    <path d="M437.38,273c-.14,0-.24-.19-.23-.39s.15-.35.3-.33.24.18.22.38A.34.34,0,0,1,437.38,273Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 437.411px 272.639px;" id="elrgk64fp8rb"
                        class="animable"></path>
                    <path
                        d="M438.56,271.15c-.05,0,.1-.27.46-.2a.58.58,0,0,1,.43.48.66.66,0,0,1-.41.7.64.64,0,0,1-.76-.32.51.51,0,0,1,.14-.65c.32-.23.55,0,.5,0s-.17.09-.24.23,0,.12,0,.15a.2.2,0,0,0,.16.07.25.25,0,0,0,.11-.17.19.19,0,0,0-.08-.17C438.76,271.19,438.6,271.21,438.56,271.15Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 438.837px 271.549px;" id="elxjlp86r5phe"
                        class="animable"></path>
                    <path
                        d="M440.27,271.1a.34.34,0,0,1-.19-.41.31.31,0,0,1,.33-.31c.14,0,.22.21.18.41S440.41,271.13,440.27,271.1Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 440.333px 270.742px;" id="eletr3gdqpyod"
                        class="animable"></path>
                    <path
                        d="M441.72,269.88a.31.31,0,0,1-.22-.36.26.26,0,0,1,.23-.3.27.27,0,0,1,.31.23.3.3,0,0,1,0,.13A.32.32,0,0,1,441.72,269.88Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 441.77px 269.548px;" id="elzj67p67w45f"
                        class="animable"></path>
                    <path
                        d="M443.76,268.7c-.08.12-.33.1-.59,0s-.49-.15-.51-.3.27-.29.63-.21S443.84,268.58,443.76,268.7Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 443.219px 268.475px;" id="elpywstkufwg9"
                        class="animable"></path>
                    <path
                        d="M444.74,268c-.13.06-.33-.13-.25-.39s.34-.31.42-.19a.45.45,0,0,1,.07.34A.41.41,0,0,1,444.74,268Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 444.73px 267.685px;" id="el8nsogga84gm"
                        class="animable"></path>
                    <path
                        d="M445.92,266.85a.31.31,0,0,1-.22-.36.29.29,0,0,1,.3-.29.3.3,0,0,1,.22.35A.32.32,0,0,1,445.92,266.85Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 445.96px 266.525px;" id="elsymfw07mftb"
                        class="animable"></path>
                    <path
                        d="M431.5,213.73l-6.63,6.67,16.06,15.79s3.27-9.52,5.55-17.9C448.09,212.37,431.5,213.73,431.5,213.73Z"
                        style="fill: rgb(36, 106, 248); transform-origin: 435.73px 224.893px;" id="elmlohuchzxd"
                        class="animable"></path>
                    <path d="M428.91,221c-.14,0-.29-.29-.33-.67s.05-.71.19-.72.29.28.33.67S429.05,221,428.91,221Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 428.84px 220.305px;" id="elcxmfuvfygtu"
                        class="animable"></path>
                    <path
                        d="M430.44,221.31c0,.14-.25.26-.56.26s-.55-.12-.55-.26.25-.26.55-.26S430.44,221.16,430.44,221.31Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 429.885px 221.31px;" id="elp2p75qdqv3f"
                        class="animable"></path>
                    <path d="M430.86,223.53c-.13-.08-.12-.31-.12-.56s0-.47.12-.55.4.14.4.55S431,223.62,430.86,223.53Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 431px 222.976px;" id="el4o04qd8515r"
                        class="animable"></path>
                    <path
                        d="M432.18,223.75c-.06,0,.17-.32.6-.18a.77.77,0,0,1,.52.58.78.78,0,0,1-1.47.44.72.72,0,0,1,.2-.77.57.57,0,0,1,.48-.16c.13,0,.17.1.15.12a.69.69,0,0,0-.35.28c-.13.22-.06.51.29.42s.26-.41,0-.57S432.22,223.81,432.18,223.75Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 432.548px 224.275px;" id="elw4lgq0hl3ys"
                        class="animable"></path>
                    <path
                        d="M433.91,226.45c-.13,0-.18-.27-.11-.5s.25-.38.39-.34.19.27.11.5S434.05,226.49,433.91,226.45Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 434.053px 226.03px;" id="elsxof99y1o2s"
                        class="animable"></path>
                    <path
                        d="M435.41,226.16c.14,0,.19.42.11.88s-.26.82-.4.79-.19-.42-.11-.88S435.27,226.14,435.41,226.16Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 435.265px 226.995px;" id="elrqwspzcmdzo"
                        class="animable"></path>
                    <path d="M437,228c0,.14-.25.29-.6.33s-.63-.05-.65-.19.25-.29.6-.33S437,227.83,437,228Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 436.374px 228.069px;" id="elli6o5tcr4j"
                        class="animable"></path>
                    <path
                        d="M437.65,228.76c0-.06.21-.22.59-.06a.81.81,0,0,1,.47.55.78.78,0,0,1-.41.85.71.71,0,0,1-.95-.21.64.64,0,0,1,.14-.77A.48.48,0,0,1,438,229c.12.05.14.12.12.14a.4.4,0,0,0-.32.24c-.11.24,0,.4.29.28s.19-.44,0-.62S437.66,228.84,437.65,228.76Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 438.002px 229.415px;" id="el01br0fwelz3q"
                        class="animable"></path>
                    <path
                        d="M439.33,232.29c-.14,0-.26-.38-.26-.84s.12-.83.26-.83.26.37.26.83S439.48,232.29,439.33,232.29Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 439.33px 231.455px;" id="elul1p2zxi1ms"
                        class="animable"></path>
                    <path
                        d="M436.91,206.89a9.4,9.4,0,0,1-1.44,2.15c-1,1.26-2.38,3-4,4.77s-3.1,3.44-4.19,4.6a13.68,13.68,0,0,1-1.85,1.8,13,13,0,0,1,1.57-2.05c1-1.21,2.48-2.87,4.08-4.69l4.1-4.67A18.41,18.41,0,0,1,436.91,206.89Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 431.17px 213.55px;" id="el21bo5c3pjne"
                        class="animable"></path>
                    <path
                        d="M448.14,266.73c0,.14-.3.19-.6.12s-.51-.25-.48-.39.31-.19.6-.12S448.17,266.59,448.14,266.73Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 447.6px 266.595px;" id="elktcyta7esao"
                        class="animable"></path>
                    <path
                        d="M448.9,265.51c0-.05.06-.21.35-.23a.48.48,0,0,1,.44.3.46.46,0,0,1-.21.63l-.1,0c-.5.13-.93-.36-.71-.74a.32.32,0,0,1,.33-.16.09.09,0,0,1,.09.12.22.22,0,0,0-.09.2s.15.11.24.08h0a.09.09,0,0,0-.06-.1C449.07,265.58,448.93,265.58,448.9,265.51Z"
                        style="fill: rgb(38, 50, 56); transform-origin: 449.177px 265.756px;" id="elfu0x7f6d9tp"
                        class="animable"></path>
                    <path
                        d="M363.79,230.06c-.57-1.89-7.74-5.77-6.66-6.82,1.4-1.38,7.3,4.38,7.83,4.83s1.18-.32.68-.7c-.72-.55-8.18-6.47-6.81-7.83.76-.76,2,.77,2,.77s6.58,6.07,7.21,5.4-3.12-4.37-4.47-5.52-1.34-2.26-.36-2.44c.66-.13,4.88,3.31,6.18,4.49s4.85,4.46,4.38,1.39v-.14c-.54-3,0-5.51.7-6.11a1,1,0,0,1,1.7.83,1.14,1.14,0,0,1,0,.45v.22a16.37,16.37,0,0,0,.21,3.13,8.32,8.32,0,0,0,.87,2.66c.51,1,1,1.76,1.4,2.43,4.79,2.64,18.58,9.61,32.39,10.67,2.5.19,15.15-16.17,15.15-16.17l12.41,12.19c-1.68,2.87-2.27,3.53-10.7,15.06-13.75,18.81-57-12.34-57-12.34h0l-.4-.2a96.17,96.17,0,0,1-9.56-5.36c-3.72-2.61-3.5-2.95-3.13-3.35C358.65,226.55,364.37,232,363.79,230.06Z"
                        style="fill: rgb(255, 190, 157); transform-origin: 397.81px 235.987px;" id="elbq8s5e065sb"
                        class="animable"></path>
                </g>
                <defs>
                    <filter id="active" height="200%">
                        <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2"></feMorphology>
                        <feFlood flood-color="#32DFEC" flood-opacity="1" result="PINK"></feFlood>
                        <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>
                        <feMerge>
                            <feMergeNode in="OUTLINE"></feMergeNode>
                            <feMergeNode in="SourceGraphic"></feMergeNode>
                        </feMerge>
                    </filter>
                    <filter id="hover" height="200%">
                        <feMorphology in="SourceAlpha" result="DILATED" operator="dilate" radius="2"></feMorphology>
                        <feFlood flood-color="#ff0000" flood-opacity="0.5" result="PINK"></feFlood>
                        <feComposite in="PINK" in2="DILATED" operator="in" result="OUTLINE"></feComposite>
                        <feMerge>
                            <feMergeNode in="OUTLINE"></feMergeNode>
                            <feMergeNode in="SourceGraphic"></feMergeNode>
                        </feMerge>
                        <feColorMatrix type="matrix"
                            values="0   0   0   0   0                0   1   0   0   0                0   0   0   0   0                0   0   0   1   0 ">
                        </feColorMatrix>
                    </filter>
                </defs>
            </svg>
        </div>
    </section>
    <script src="../../src/scripts/theme.js"></script>
</body>

</html>
