import {
        sendData,
        fetchData,
        checkCustomerSession,
        strToNum,
        logSend,
        logFetch
} from "./common.js";

let ACCOUNT_NUMBER;
const ID_LOGOUT_BUTTON = "#logout";
const ID_ACCOUNT_NAME = "#account_name";
const ID_ACCOUNT_NUMBER = "#account_number";
const ID_BALANCE = "#display_account_balance";

main();

function main() {
        checkCustomerSession(startOperation);
        //startOperation();
}

function startOperation() {
        let accountName, accountNumber, balance, url;

        
        accountName = document.querySelector(ID_ACCOUNT_NAME);
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER);
        balance = document.querySelector(ID_BALANCE); 
        accountName.innerHTML = "Loading...";
        accountNumber.innerHTML = "Loading...";
        balance.innerHTML = "Loading...";
        url = "../../backend/php/customer-session.php";
        fetchData(url, setAccountNumber);
}

function setAccountNumber(data) {
        if (!data.success) {
                console.log(data);
                return;
        }
        ACCOUNT_NUMBER = data.accountNumber;
        getCustomerInfo();
}

function getCustomerInfo() {
        let sessionAccount, url, requestBody;

        url = "../../backend/php/customer-info.php";
        sessionAccount = ACCOUNT_NUMBER;
        requestBody = new FormData();
        requestBody.append('account_number', sessionAccount);
        sendData(url, requestBody, showCustomerData);
}
function showCustomerData(data) {
        console.log(data);
        if (!data.success) return;
        let accountName, accountNumber, balance;

        accountName = document.querySelector(ID_ACCOUNT_NAME);
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER);
        balance = document.querySelector(ID_BALANCE); 
        accountName.innerHTML = data.data.name.toUpperCase();;
        accountNumber.innerHTML = data.data.accountNumber;
        balance.innerHTML = strToNum(data.data.balance); 
}
