import {
        sendData,
        clearFeedback,
} from "./common.js";
const ID_LOGIN_BUTTON = "#login_button";
const ID_LOGIN_FEEDBACK = "#feedback_test";
const ID_ACCOUNT_NUMBER = "#account_number"; 
const ID_PASSWORD = "#account_password";
const ACCOUNT_URL = "./account/overview.html";

main();

function main() {
        let btnLogin, loginFeedback;

        btnLogin = document.querySelector(ID_LOGIN_BUTTON);
        btnLogin.addEventListener("click", loginCustomer);
}

function loginCustomer() {
        let accountNumber, password, loginFeedback, requestBody, url;

        loginFeedback = document.querySelector(ID_LOGIN_FEEDBACK);
        loginFeedback.innerHTML = "Logging in...";
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER).value;
        password = document.querySelector(ID_PASSWORD).value;
        if (!accountNumber || !password) {
                loginFeedback.innerHTML = "Please fill the blanks";
                clearFeedback(loginFeedback);
                return;
        }
        requestBody = new FormData();
        requestBody.append('account_number', accountNumber);
        requestBody.append('password', password);
        url = "../backend/php/customer-login.php";
        sendData(url, requestBody, showLoginFeedback);  
}

function showLoginFeedback(data) {
        let loginFeedback;

        loginFeedback = document.querySelector(ID_LOGIN_FEEDBACK);
        if (!data.success) {
                loginFeedback.innerHTML = data.errorMessage;
                clearFeedback(loginFeedback);
                return;
        }
        window.location.href = ACCOUNT_URL;
}
