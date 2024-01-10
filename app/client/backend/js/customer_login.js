import { 
        postData, clearFeedback, saveRequest, destroyOTPSession 
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
        btnLogin.addEventListener("click", validateLoginForm);
}

async function validateLoginForm() {
        let accountNumber, accountPassword;

        accountNumber = document.getElementById("account_number").value;
        accountPassword = document.getElementById("account_password").value;
        if (!accountNumber || !accountPassword) {
                showFeedback("Please fill the required fields.");
                return;
        }
        if (!/^1899\d{8}$/.test(accountNumber)) {
                showFeedback("Invalid account number. Please enter a valid " + 
                        "account number.");
                return;
        }
        if(!isPasswordValid(accountPassword)) {
                showFeedback("Invalid password. Please enter a valid " + 
                        "password with at least 8 characters.");
                return;
        }
        await destroyOTPSession();
        loginCustomer();
}

function showFeedback(message) {
        let feedback;

        feedback = document.getElementById("feedback_test");
        feedback.innerHTML = message;
        clearFeedback(feedback);
}

async function loginCustomer() {
        let accountNumber, password, loginFeedback, requestBody, url, data,
                response, requestURL;

        loginFeedback = document.querySelector(ID_LOGIN_FEEDBACK);
        loginFeedback.innerHTML = "Please wait.";
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER).value;
        password = document.querySelector(ID_PASSWORD).value;
        requestBody = new FormData();
        requestBody.append("account_number", accountNumber);
        requestBody.append("password", password);
        requestBody.append("redirect_url", ACCOUNT_URL);
        console.log(accountNumber);
        //url = "../backend/php/customer-login.php";
        url = "../backend/php/customer-login-check.php";
        data = await postData(url, requestBody);
        if (!data.success) {
                loginFeedback.innerHTML = data.errorMessage;
                clearFeedback(loginFeedback);
                return;
        }
        requestURL = "../backend/php/customer-login.php";
        await saveRequest(requestURL, requestBody);
}

function isPasswordValid(password) {
        // Check for at least one number
        if (!/\d/.test(password)) return false;;

        // Check for at least one uppercase letter
        if (!/[A-Z]/.test(password)) return false;

        // Check for at least one lowercase letter
        if (!/[a-z]/.test(password)) return false;

        // Check for at least 8 characters
        if (!password.length >= 8) return false;

        // Return true if all conditions are met
        return true;
}
