<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../src/css/otp.css">
    <link rel="icon" href="../assets/img/apex_brand.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Apex Bank – Verify</title>
</head>

<body>
    <script src="../src/scripts/preload.js"></script>
    <section id="otp_grid_container">
        <div id="header_container">
            <div id="apex_logo">
                <img src="../assets/img/apex_brand.png" alt="apex logo">
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
        <div id="back_container">
            <a href="./login.html">
                <i class=" fa-solid fa-chevron-left"></i></i><span>Back</span>
            </a>
        </div>
        <div id="otp_container">
            <div id="otp_text">
                <h1><i class="fa-solid fa-shield-halved"></i>Verify your identity</h1>
                <p>We've sent you a secure, <strong>One-Time Password (OTP)</strong> to verify your
                    identity. Enter the six-digit code
                    below to complete the process.</p>
            </div>
            <div class="otp-form-container">
                <form action="../src/php/verify_otp.php" method="POST" id="otpVerificationForm">
                    <div class="otp-fields">
                        <input type="text" class="otp-input" id="otp1" name="otp1" maxlength="1" pattern="[0-9]" oninput="moveToNext(this, 'otp2')" required>
                        <input type="text" class="otp-input" id="otp2" name="otp2" maxlength="1" pattern="[0-9]" oninput="moveToNext(this, 'otp3')" required>
                        <input type="text" class="otp-input" id="otp3" name="otp3" maxlength="1" pattern="[0-9]" oninput="moveToNext(this, 'otp4')" required>
                        <input type="text" class="otp-input" id="otp4" name="otp4" maxlength="1" pattern="[0-9]" oninput="moveToNext(this, 'otp5')" required>
                        <input type="text" class="otp-input" id="otp5" name="otp5" maxlength="1" pattern="[0-9]" oninput="moveToNext(this, 'otp6')" required>
                        <input type="text" class="otp-input" id="otp6" name="otp6" maxlength="1" pattern="[0-9]" required>
                    </div>

                    <div class="verify-section">
                        <button type="button" class="verify-button" onclick="verifyOTP()">Submit</button>
                    </div>
                </form>

                <p class="resend-code">Didn't receive a code? <a href="#">Resend code</a></p>
            </div>

        </div>
        <div id="otp_image_container">
            <img src="../assets/img/two-fa.svg">
        </div>
    </section>
    <script src="../src/scripts/theme.js"></script>
    <script src="../src/scripts/otp.js"></script>
</body>

</html>