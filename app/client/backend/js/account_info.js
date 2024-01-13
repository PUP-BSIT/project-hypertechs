import { 
        postData, getData, isLoggedIn, strToNum
} from "./common_new.js";

let ACCOUNT_NUMBER;
const ID_LOGOUT_BUTTON = "#logout";
const ID_ACCOUNT_NAME = "#account_name";
const ID_ACCOUNT_NUMBER = "#account_number";
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
        url = "../backend/php/customer-session.php";
        response = await getData(url);
        if (!response.success) {
                return;
        }
        ACCOUNT_NUMBER = response.accountNumber;
        getCustomerInfo();
}

async function getCustomerInfo() {
        let sessionAccount, url, requestBody, response;

        url = "../backend/php/customer-info.php";
        sessionAccount = ACCOUNT_NUMBER;
        requestBody = new FormData();
        requestBody.append('account_number', sessionAccount);
        response = await postData(url, requestBody);
        if (!response.success) return;
        showCustomerData(response);
}

function showCustomerData(data) {
        let accountName, accountNumber, balance, firstName;

        firstName = document.querySelector(ID_FIRST_NAME);
        firstName.innerHTML = data.data.firstName;
/*
        accountName = document.querySelector(ID_ACCOUNT_NAME);
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER);
        balance = document.querySelector(ID_BALANCE); 
        accountName.innerHTML = data.data.name.toUpperCase();;
        accountNumber.innerHTML = data.data.accountNumber;
        balance.innerHTML = strToNum(data.data.balance); 
*/
}