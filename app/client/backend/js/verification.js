import { 
        getData, postData, sendRequest, destroyOTPSession
} from "./common_new.js";

const JS_SECOND = 1000;
const MINUTE = 60;
const URL_HOME = "/index.html";
const ID_OTP_1 = "#otp1";
const ID_OTP_2 = "#otp2";
const ID_OTP_3 = "#otp3";
const ID_OTP_4 = "#otp4";
const ID_OTP_5 = "#otp5";
const ID_OTP_6 = "#otp6";
const ID_BTN_SUBMIT = "#button_submit";
const ID_BTN_START = "#btn_start";
const ID_BTN_RENEW = "#btn_renew";
const ID_TIMER_MINUTE = "#timer_minute";
const ID_TIMER_SECOND = "#timer_second";
const ID_EXPIRED = "#expired";
const ID_VERIFY = "#otp_container";
const ID_GET_OTP = "#get_otp";
const ID_OTP_CORRECT = "#otp_correct";
const ID_LOADING_EXPIRED = "#loading_expired";
const ID_LOADING_GET = "#loading_get";
const ID_CODE_RESEND = "#resend_code";
const ID_BTN_BACK = "#btn_back";
let TIMEOUT_ID;
let INTERVAL_ID;
let OTP;

main();

async function main() {
        let otpTest, expired, otp1, otp2, otp3, otp4, otp5, otp6,
                codeResend, btnGet, btnVerify, btnRetry, btnBack;

        console.log("main");
        showText();
        checkSession(); 
        btnBack = document.querySelector(ID_BTN_BACK);
        btnBack.addEventListener("click", () => {
                history.back()
        });
        otp1 = document.querySelector(ID_OTP_1);
        otp2 = document.querySelector(ID_OTP_2);
        otp3 = document.querySelector(ID_OTP_3);
        otp4 = document.querySelector(ID_OTP_4);
        otp5 = document.querySelector(ID_OTP_5);
        otp6 = document.querySelector(ID_OTP_6);
        otp1.addEventListener("input", () => {
                moveToNext(otp1, 'otp2'); 
        });
        otp2.addEventListener("input", () => {
                moveToNext(otp2, 'otp3'); 
        });
        otp3.addEventListener("input", () => {
                moveToNext(otp3, 'otp4'); 
        });
        otp4.addEventListener("input", () => {
                moveToNext(otp4, 'otp5'); 
        });
        otp5.addEventListener("input", () => {
                moveToNext(otp5, 'otp6'); 
        });
        const otpInputs = document.querySelectorAll(".otp-input");
        otpInputs.forEach(function (input) {
                input.addEventListener("input", function (e) {
                        const onlyNumbers = /^\d+$/;

                        if (!onlyNumbers.test(e.data)) {
                                // Remove non-numeric characters
                                input.value = input.value.replace(/\D/g, "");
                        }
                        moveToNext(input);
                });
        });
        codeResend = document.querySelector(ID_CODE_RESEND);
        codeResend.addEventListener("click", resendCode); 
        btnGet = document.querySelector(ID_BTN_START);
        btnGet.addEventListener("click", () => {
                getOTP();
        });
        btnVerify = document.querySelector(ID_BTN_SUBMIT);
        btnVerify.addEventListener("click", () => {
                checkOTPInput(); 
        }); 
        btnRetry = document.querySelector(ID_BTN_RENEW);
        btnRetry.addEventListener("click", () => {
                getOTP(); 
        }); 
}

async function resendCode() {
        setTimer(0);
        await destroyOTPSession("OTPOnly");
        showText("OTP_GET");
}

async function checkSession() {
        let url, startButton, otpTest, expired, data;

        console.log("checkSession");
        url = "../backend/php/otp-session.php";
        data = await getData(url);
        console.log(data);
        if (!data.hasSession) {
                window.location.href = URL_HOME;
        }
        if (!data.hasExpired) {
                startVerify();
                return;
        }
        setTimer(0);
        await destroyOTPSession("OTPOnly");
        showText("OTP_EXPIRED");
}

function startVerify() {
        let btnStart;

        console.log("start");
        showText("OTP_GET");
}

function renewOTP() {
        let expired, btnStart;

        console.log("renewOTP");
        showText("OTP_EXPIRED");
        btnStart = document.querySelector(ID_BTN_RENEW);
        btnStart.addEventListener("click", (event) => {
                event.stopPropagation();
                console.log("Hello");
                getOTP();
        });
}

async function getOTP() {
        let url, data, OTPInput;

        console.log("getOTP");
        url = "../backend/php/otp.php";
        data = await getData(url);
        console.log(data);
        showText("OTP_VERIFY");
        OTP = data.otp;
        setTimer(data.time);
        OTPInput = getOTPInput();
}

async function checkOTPInput() {
        let OTPInput;

        OTPInput = getOTPInput();
        console.log(OTPInput, OTP);
        if(OTPInput !== OTP) {
                alert("You have entered an incorrect OTP. Please try again.");
                return;
        }
        setTimer(0);
        await destroyOTPSession();
        showText("OTP_SUCCESS");
        await sendRequest();
}

function getOTPInput() {
        let num1, num2, num3, num4, num5, num6, otp;

        num1 = document.querySelector(ID_OTP_1).value;
        num2 = document.querySelector(ID_OTP_2).value;
        num3 = document.querySelector(ID_OTP_3).value;
        num4 = document.querySelector(ID_OTP_4).value;
        num5 = document.querySelector(ID_OTP_5).value;
        num6 = document.querySelector(ID_OTP_6).value;

        otp = "" + num1 + num2 + num3 + num4 + num5 + num6
        return Number(otp);
}

function setTimer(remainTime) {
        let timerMinute, timerSecond, minute, second;

        if (!remainTime) {
                console.log("Cancelled");
                console.log(TIMEOUT_ID, INTERVAL_ID);
                clearTimeout(TIMEOUT_ID);
                clearInterval(INTERVAL_ID);
                return;
        }
        timerMinute = document.querySelector(ID_TIMER_MINUTE);
        timerSecond = document.querySelector(ID_TIMER_SECOND);
        minute = parseInt(remainTime / 60);
        second = remainTime - (minute * 60); 
        timerMinute.innerHTML = numToTime(minute);
        timerSecond.innerHTML = numToTime(second);
        TIMEOUT_ID = setTimeout(checkSession, remainTime * JS_SECOND);
        INTERVAL_ID = setInterval(() => {
                //if (--timer.innerHTML === 0) clearInterval(INTERVAL_ID);
                if (--second === -1) {
                        second = MINUTE - 1;
                        --minute;
                }
                if (minute === -1) {
                        clearInterval(INTERVAL_ID);
                        return;
                }
                timerMinute.innerHTML = numToTime(minute);
                timerSecond.innerHTML = numToTime(second);
        }, JS_SECOND);
        console.log(TIMEOUT_ID, INTERVAL_ID);
}

function numToTime(num) {
        return num.toString().padStart(2, '0');
}

function showText(textCode) {
        let startOTP, verifyOTP, expiredOTP, successOTP;

        startOTP = document.querySelector(ID_GET_OTP);
        expiredOTP = document.querySelector(ID_EXPIRED);
        verifyOTP = document.querySelector(ID_VERIFY);
        successOTP = document.querySelector(ID_OTP_CORRECT);
        switch (textCode) {
        case "OTP_EXPIRED":
                verifyOTP.hidden = successOTP.hidden = startOTP.hidden = true;
                expiredOTP.hidden = false;
                break;
        case "OTP_GET":
                verifyOTP.hidden = successOTP.hidden = expiredOTP.hidden = true;
                startOTP.hidden = false;
                break;
        case "OTP_VERIFY":
                startOTP.hidden = successOTP.hidden = expiredOTP.hidden = true;
                verifyOTP.hidden = false;
                break;
        case "OTP_SUCCESS":
                startOTP.hidden = verifyOTP.hidden = expiredOTP.hidden = true;
                successOTP.hidden = false;
                break;
        default:
                startOTP.hidden = verifyOTP.hidden = expiredOTP.hidden = 
                        successOTP.hidden = true;
        }
}
/* script for otp form validation */

/* script to automatically proceed to next otp field */
function moveToNext(currentInput, nextInputId) {
        const maxLength = parseInt(currentInput.maxLength, 10);
        const currentLength = currentInput.value.length;
        const inputValue = currentInput.value.trim();

        // Validate if the input contains only numbers
        const containsOnlyNumbers = /^\d+$/.test(inputValue);

        if (currentLength === maxLength && inputValue !== "" && 
                containsOnlyNumbers) {
                const nextInput = document.getElementById(nextInputId);
                if (nextInput) {
                        nextInput.focus();
                }
        }
}

