import { 
        postData, getData, isLoggedIn, strToNum
} from "./common_new.js";

let ACCOUNT_NUMBER;
const ID_LOGOUT_BUTTON = "#logout";
const ID_ACCOUNT_NAME = "#display_account_holder";
const ID_ACCOUNT_NUMBER = "#display_account_number";
const ID_BALANCE = "#display_account_balance";
const ID_FIRST_NAME = "#account_first_name";
const HOME_URL = "/index.html";

main();

async function main() {
        let response, loggedIn, accountName, accountNumber, balance, url;

        loggedIn = await isLoggedIn();
        if (!loggedIn) {
                window.location.href = HOME_URL;
                return;
        }
        url = "/app/client/backend/php/customer-session.php";
        response = await getData(url);
        if (!response.success) {
                return;
        }
        ACCOUNT_NUMBER = response.accountNumber;
        getCustomerInfo();
}

async function getCustomerInfo() {
        let sessionAccount, url, requestBody, response;

        url = "/app/client/backend/php/customer-info.php";
        sessionAccount = ACCOUNT_NUMBER;
        requestBody = new FormData();
        requestBody.append('account_number', sessionAccount);
        response = await postData(url, requestBody);
        if (!response.success) return;
        showCustomerData(response);
}

function showCustomerData(data) {
        let accountName, accountNumber, balance, firstName, name;

        firstName = document.querySelector(ID_FIRST_NAME);
        firstName.innerHTML = data.data.firstName + "!";
        accountName = document.querySelector(ID_ACCOUNT_NAME);
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER);
        balance = document.querySelector(ID_BALANCE); 
        if (!accountName || !accountNumber || !balance) return;
        accountName.innerHTML = data.data.name;
        accountNumber.innerHTML = data.data.accountNumber;
        balance.innerHTML = strToNum(data.data.balance); 
}
