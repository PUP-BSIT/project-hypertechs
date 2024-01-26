import { postData, getData, isLoggedIn } from "./common_new.js";

const URL_HOME = "/index.html";
const ID_ACCOUNT = "#deposit_account";
const ID_AMOUNT = "#deposit_amount";
const ID_BALANCE = "#account_balance_deposit";
const ID_BTN_SUBMIT  = "#deposit_submit";
const ID_CONFIRM_BUTTON ="#confirm_deposit_button";
const ID_ERROR_DESC = "#transfer_error_desc";
const ID_CONFIRM_ACCOUNT = "#confirm_deposit_acc_number";
const ID_CONFIRM_NAME = "#confirm_deposit_acc_name";
const ID_CONFIRM_AMOUNT  = "#confirm_deposit_amount";
const ID_SUCCESS = "#transaction_success_modal";
const ID_SUCCESS_TYPE = "#success_type";
const ID_SUCCESS_AMOUNT = "#success_amount";
const ID_SUCCESS_ACCOUNT = "#success_acc_number";
const ID_SUCCESS_NAME = "#success_acc_name";
const ID_SUCCESS_DETAILS = "#success_details_text";
let ACCOUNT_NUMBER;
let ACCOUNT_NAME;

main();

async function main() {
        let url, loggedIn, btnDeposit, response, confirmButton, account, balance;

        loggedIn = await isLoggedIn();
        if (!loggedIn) {
                window.location.href = URL_HOME;
        }
        url = "../../backend/php/admin-session.php";
        response = await getData(url);
        ACCOUNT_NUMBER = response.adminId;
        console.log(ACCOUNT_NUMBER);
        account = document.querySelector(ID_ACCOUNT);
        account.addEventListener("input", getBalance);
        btnDeposit = document.querySelector(ID_BTN_SUBMIT);
        btnDeposit.addEventListener("click", validateDeposit);
        confirmButton = document.querySelector(ID_CONFIRM_BUTTON);
        confirmButton.addEventListener("click", requestDeposit);
}

async function getBalance() {
        let account, balance, requestBody, url, btnDeposit, amount, response; 

        btnDeposit = document.querySelector(ID_BTN_SUBMIT);
        btnDeposit.disabled = false;
        balance = document.querySelector(ID_BALANCE);
        balance.value = "";
        account = document.querySelector(ID_ACCOUNT).value;
        account = document.querySelector(ID_ACCOUNT).value;
        amount = document.querySelector(ID_AMOUNT).value;
        if (account.length != 12) return;
        btnDeposit.disabled = true;
        requestBody = new FormData();
        requestBody.append('account_number', account);
        requestBody.append('amount', amount);
        requestBody.append('admin_id', ACCOUNT_NUMBER);
        url = "/app/admin/backend/php/deposit-check.php";
        response = await postData(url, requestBody);
        console.log(response);
        if (!response.success) {
                balance.value = response.accountBalance;
                return;
        }
        balance.value = response.accountBalance;
        btnDeposit.disabled = false;
}

async function validateDeposit() {
        let account, amount, requestBody, url, response, confirmButton, 
        errorMsg, confirmAccount, confirmName, confirmAmount;

        account = document.querySelector(ID_ACCOUNT).value;
        if (!account.trim()) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "Account number cannot be empty."
                return;
        }

        if (!isValidAccountNumber(account)) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "Invalid input. Please enter a valid " +
                " 12-digit Apex account number to proceed.";

                return;
        }

        amount = document.querySelector(ID_AMOUNT).value;
        if (!isValidAmount(amount)) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "Invalid input. The amount must be at " + 
                "least &#8369;100 up to 9 digits maximum with no commas.";
                return;
        }

        requestBody = new FormData();
        requestBody.append('account_number', account);
        requestBody.append('amount', amount);
        requestBody.append('admin_id', ACCOUNT_NUMBER);
        url = "/app/admin/backend/php/deposit-check.php";
        response = await postData(url, requestBody);
        if (!response.success) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = response.errorMessage;
                return;
        }

        document.getElementById('confirm_details_modal').hidden = false;
        confirmAccount = document.querySelector(ID_CONFIRM_ACCOUNT);
        confirmName = document.querySelector(ID_CONFIRM_NAME);
        confirmAmount = document.querySelector(ID_CONFIRM_AMOUNT);
        confirmAccount.innerHTML = account;
        confirmName.innerHTML = ACCOUNT_NAME = response.accountName;
        confirmAmount.innerHTML = amount;
}

async function requestDeposit() {
        let account, amount, requestBody, url, response, confirmButton, 
                successType, successAmount, successAccount, successName, 
                successDetails;

        account = document.querySelector(ID_ACCOUNT).value;
        amount = document.querySelector(ID_AMOUNT).value;
        requestBody = new FormData();
        requestBody.append('account_number', account);
        requestBody.append('amount', amount);
        requestBody.append('admin_id', ACCOUNT_NUMBER);
        url = "/app/admin/backend/php/deposit.php";
        response = await postData(url, requestBody);
        console.log(response);
        if (!response.success) {
                alert(response.errorMessage);
                return;
        }
        document.querySelector(ID_ACCOUNT).value = "";
        document.querySelector(ID_AMOUNT).value = "";
        document.querySelector(ID_BALANCE).value = "";
        document.getElementById('confirm_details_modal').hidden = true;

        document.querySelector(ID_SUCCESS).hidden = false;
        successType = document.querySelector(ID_SUCCESS_TYPE);
        successAmount = document.querySelector(ID_SUCCESS_AMOUNT);
        successAccount = document.querySelector(ID_SUCCESS_ACCOUNT);
        successName = document.querySelector(ID_SUCCESS_NAME);
        successDetails = document.querySelector(ID_SUCCESS_DETAILS);
        successType.innerHTML = "deposit";
        successAmount.innerHTML = amount;
        successAccount.innerHTML = account;
        successName.innerHTML = ACCOUNT_NAME;
        successDetails.innerHTML = "Deposit Successful!"
}
 
function isValidAccountNumber(account) {
        // 12 digits with no spaces or non-numeric characters
        return /^\d{12}$/.test(account);
}
    
function isValidAmount(amount) {
        // 9 digits and exactly two decimal places
        const amountRegex = /^\d{1,9}(?:\.\d{2})?$/;
    
        // Check if the amount is not zero and is at least 100
        const isNonZero = parseFloat(amount) !== 0;
        const isAtLeast100 = parseFloat(amount) >= 100;
    
        return amountRegex.test(amount) && isNonZero && isAtLeast100;
}
