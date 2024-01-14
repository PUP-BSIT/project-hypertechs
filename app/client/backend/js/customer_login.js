import { 
        postData, saveRequest, destroyOTPSession 
} from "./common_new.js";

const ID_LOGIN_BUTTON = "#login_button";
const ID_EMAIL = "#account_email";
const ID_PASSWORD = "#account_password";
const ACCOUNT_URL = "./account/overview.html";

main();

function main() {
        let btnLogin, loginFeedback;
        btnLogin = document.querySelector(ID_LOGIN_BUTTON);
        btnLogin.addEventListener("click", validateLoginForm);
}

async function validateLoginForm() {
        let accountEmail, accountPassword;
    
        accountEmail = document.querySelector(ID_EMAIL).value;
        accountPassword = document.querySelector(ID_PASSWORD).value;
        
        if (!accountEmail || !accountPassword) {
            showAlert("Please fill all the required fields.");
            return;
        }
        if(!isPasswordValid(accountPassword)) {
            showAlert("Invalid password. Please enter a valid password.");
            return;
        }
    
        await destroyOTPSession();
        loginCustomer();
}
    
function showAlert(message) {
        window.alert(message);
}

async function loginCustomer() {
        let accountEmail, password, requestBody, url, data,
                response, requestURL;

        accountEmail = document.querySelector(ID_EMAIL).value;
        password = document.querySelector(ID_PASSWORD).value;
        requestBody = new FormData();
        requestBody.append("email", accountEmail);
        requestBody.append("password", password);
        requestBody.append("redirect_url", ACCOUNT_URL);
        console.log(accountEmail);
        //url = "../backend/php/customer-login.php";
        url = "../backend/php/customer-login-check.php";
        data = await postData(url, requestBody);
        if (!data.success) {
                showAlert(data.errorMessage);
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
