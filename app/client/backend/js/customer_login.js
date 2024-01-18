import { 
        postData, saveRequest, destroyOTPSession 
} from "./common_new.js";

const ID_LOGIN_BUTTON = "#login_button";
const ID_PHONE = "#account_phone";
const ID_PASSWORD = "#account_password";
const ACCOUNT_URL = "/app/client/pages/account/overview.html";

main();

function main() {
        let btnLogin, loginFeedback;
        btnLogin = document.querySelector(ID_LOGIN_BUTTON);
        btnLogin.addEventListener("click", validateLoginForm);
}

async function validateLoginForm() {
        let accountPhone, accountPassword;
    
        accountPhone = document.querySelector(ID_PHONE).value;
        accountPassword = document.querySelector(ID_PASSWORD).value;
        
        if (!accountPhone || !accountPassword) {
            alert("Please fill all the required fields.");
            return;
        }
        if(!isPasswordValid(accountPassword)) {
            alert("Invalid password. Please enter a valid password.");
            return;
        }
    
        await destroyOTPSession();
        loginCustomer();
}
    
async function loginCustomer() {
        let accountPhone, password, requestBody, url, data,
                response, requestURL;

        accountPhone = document.querySelector(ID_PHONE).value;
        password = document.querySelector(ID_PASSWORD).value;
        requestBody = new FormData();
        requestBody.append("phone_number", accountPhone);
        requestBody.append("password", password);
        requestBody.append("redirect_url", ACCOUNT_URL);
        url = "../backend/php/customer-login-check.php";
        data = await postData(url, requestBody);
        if (!data.success) {
                alert(data.errorMessage);
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
