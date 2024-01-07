import { 
        postData, clearFeedback, saveRequest 
} from "./common_new.js";

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

async function loginCustomer() {
        let accountNumber, password, loginFeedback, requestBody, url, 
                data, response, requestURL;

        loginFeedback = document.querySelector(ID_LOGIN_FEEDBACK);
        loginFeedback.innerHTML = "Please wait.";
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER).value;
        password = document.querySelector(ID_PASSWORD).value;
        if (!accountNumber || !password) {
                loginFeedback.innerHTML = "Please fill the required fields";
                clearFeedback(loginFeedback);
                return;
        }
        requestBody = new FormData();
        requestBody.append('account_number', accountNumber);
        requestBody.append('password', password);
        requestBody.append('redirect_url', ACCOUNT_URL); 
        console.log(accountNumber);
        //url = "../backend/php/customer-login.php";
        url = "../backend/php/customer-login-check.php";
        data =  await postData(url, requestBody);
        if (!data.success) {
                loginFeedback.innerHTML = data.errorMessage;
                clearFeedback(loginFeedback);
                return;
        }
        requestURL = "../backend/php/customer-login.php";
        await saveRequest(requestURL, requestBody);
}
