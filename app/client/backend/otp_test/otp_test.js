main();

function main() {
        console.log("main");
        let startButton, otpTest, expired;

        startButton = document.querySelector("#btn_test");
        startButton.disabled = false;
        startButton.addEventListener("click", checkSession);
        otpTest = document.querySelector("#otp_test");
        expired = document.querySelector("#expired");
        otpTest.hidden = true;
        expired.hidden = true;
}

function checkSession() {
        console.log("checkSession");
        let url, startButton, otpTest, expired, result;

        result = document.querySelector("#result");
        result.innerHTML = "";
        otpTest = document.querySelector("#otp_test");
        expired = document.querySelector("#expired");
        otpTest.hidden = true;
        expired.hidden = true;
        startButton = document.querySelector("#btn_test");
        startButton.disabled = true;
        url = "./otp-session.php";
        fetch(url).then((response) => response.json()).then((data) => {
                getSession(data);
        });
}

function getSession(data) {
        console.log("getSession");
        console.log(data);
        if (!data.hasExpired) {
                getOTP();
                return;
        }
        destroyOTP(renewOTP);
}

function renewOTP() {
        let expired, btnStart;

        console.log("renewOTP");
        expired = document.querySelector("#expired");
        expired.hidden = false;
        btnStart = document.querySelector("#btn_start");
        btnStart.addEventListener("click", getOTP);
/*
        let otpTest, expired, url, requestBody;

        url = "./otp-test.php";
        requestBody = new FormData();
        requestBody.append('renew', true);
        fetch(url, {
                method: 'POST',
                body: requestBody
        }).then((response) => response.json()).then((data) => {
                testOTP(data);
        });
*/
}

function getOTP() {
        console.log("getOTP");
        let url;

        url = "./otp-test.php";
        fetch(url).then((response) => response.json()).then((data) => {
                testOTP(data);
        });
}

function testOTP(data) {
        console.log("testOTP");
        let otp, remainingTime, otpTest, expired, otpInput, btnSubmit, 
                otpReveal, time, intervalID, timeoutID, redirectURL, feedback,
                result;

        console.log(data);
        otp = data.otp;
        otpTest = document.querySelector("#otp_test");
        expired = document.querySelector("#expired");
        otpTest.hidden = false;
        expired.hidden = true;
        time = document.querySelector("#time");
        time.innerHTML = remainingTime = data.time;
        timeoutID = setTimeout(checkSession, remainingTime * 1000);
        intervalID = setInterval(() => {
                if(--time.innerHTML === 0) clearInterval(intervalID);
        }, 1000);
        otpInput = document.querySelector("#otp");
        otpInput.value = "";
        feedback = document.querySelector("#feedback");
        feedback.innerHTML = "";
        btnSubmit = document.querySelector("#btn_submit");
        btnSubmit.addEventListener("click", () => {
                if(Number(otpInput.value) !== otp) {
                        feedback.innerHTML = "OTP is invalid";
                        return;
                }
                console.log(timeoutID, intervalID);
                clearTimeout(timeoutID);
                clearInterval(intervalID);
                result = document.querySelector("#result");
                result.innerHTML = "Success";
                destroyOTP(main);
        }); 
        otpReveal = document.querySelector("#otp_reveal");
        otpReveal.innerHTML = otp;
}

function destroyOTP(next) {
        console.log("destroyOTP");
        let url, requestBody; 

        url = "./otp-destroy.php";
        fetch(url).then((response) => response.json()).then((data) => {
                console.log(data);
                setTimeout(next);
        });
}
