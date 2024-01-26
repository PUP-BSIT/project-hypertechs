import { postData, getData, isLoggedIn } from "./common_new.js";

const URL_HOME = "/index.html";
const ID_ACCOUNT = "#withdraw_account";
const ID_AMOUNT = "#withdraw_amount";
const ID_BALANCE = "#account_balance_withdraw";
const ID_BTN_SUBMIT  = "#withdraw_submit";
const ID_CONFIRM_BUTTON ="#confirm_withdraw_button";
const ID_ERROR_DESC = "#transfer_error_desc";
const ID_CONFIRM_ACCOUNT = "#confirm_withdraw_acc_number";
const ID_CONFIRM_NAME = "#confirm_withdraw_acc_name";
const ID_CONFIRM_AMOUNT  = "#confirm_withdraw_amount";
const ID_SUCCESS = "#transaction_success_modal";
const ID_SUCCESS_TYPE = "#success_type";
const ID_SUCCESS_AMOUNT = "#success_amount";
const ID_SUCCESS_ACCOUNT = "#success_acc_number";
const ID_SUCCESS_NAME = "#success_acc_name";
let ACCOUNT_NUMBER;
let ACCOUNT_NAME;

main();

async function main() {
        let url, loggedIn, btnDeposit, response, confirmButton, account;

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
        btnDeposit.addEventListener("click", validateWithdraw);
        confirmButton = document.querySelector(ID_CONFIRM_BUTTON);
        confirmButton.addEventListener("click", requestWithdraw);
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
        url = "/app/admin/backend/php/withdraw-check.php";
        response = await postData(url, requestBody);
        console.log(response);
        if (!response.success) {
                balance.value = response.accountBalance;
                return;
        }       
        balance.value = response.accountBalance;
        btnDeposit.disabled = false;
}




async function validateWithdraw() {
        let account, amount, requestBody, url, response, errorMsg, 
                confirmAccount, confirmName, confirmAmount;

        // Validate Account Number
        account = document.querySelector(ID_ACCOUNT).value;
        if (!account.trim()) {
            document.getElementById('transfer_error_modal').hidden = false;
            errorMsg = document.querySelector(ID_ERROR_DESC);
            errorMsg.innerHTML = "Account number cannot be empty."
            return;
        }

        // 12 digits and no other characters
        if (!/^\d{12}$/.test(account)) {
            document.getElementById('transfer_error_modal').hidden = false;
            errorMsg = document.querySelector(ID_ERROR_DESC);
            errorMsg.innerHTML = "Invalid input. Please enter a valid " +
                "12-digit Apex account number.";
            return;
        }

        // Validate Amount
        amount = document.querySelector(ID_AMOUNT).value;
        if (!amount.trim()) {
            document.getElementById('transfer_error_modal').hidden = false;
            errorMsg = document.querySelector(ID_ERROR_DESC);
            errorMsg.innerHTML = "Amount cannot be empty.";
            return;
        }

        // Check if it's greater than zero
        if (parseFloat(amount) <= 0) {
            document.getElementById('transfer_error_modal').hidden = false;
            errorMsg = document.querySelector(ID_ERROR_DESC);
            errorMsg.innerHTML = "Amount must be at least 100 pesos.";
            return;
        }

        // Check if it's above 100 pesos and follows the format
        if (!/^\d{1,9}(\.\d{2})?$/.test(amount) || parseFloat(amount) < 100) {
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
        url = "/app/admin/backend/php/withdraw-check.php";
        response = await postData(url, requestBody);
        if (!response.success) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = response.errorMessage;
                return;
        }

        document.getElementById('confirm_withdraw_modal').hidden = false;
        confirmAccount = document.querySelector(ID_CONFIRM_ACCOUNT);
        confirmName = document.querySelector(ID_CONFIRM_NAME);
        confirmAmount = document.querySelector(ID_CONFIRM_AMOUNT);
        confirmAccount.innerHTML = account;
        confirmName.innerHTML = ACCOUNT_NAME = response.accountName;
        confirmAmount.innerHTML = amount;

}

async function requestWithdraw() {
        let account, amount, requestBody, url, response, confirmButton, 
                successType, successAccount, successName, successAmount;

        account = document.querySelector(ID_ACCOUNT).value;
        amount = document.querySelector(ID_AMOUNT).value;

        requestBody = new FormData();
        requestBody.append('account_number', account);
        requestBody.append('amount', amount);
        requestBody.append('admin_id', ACCOUNT_NUMBER);
        url = "/app/admin/backend/php/withdraw.php";

        // Send request if all validations pass
        response = await postData(url, requestBody);
        console.log(response);

        if (!response.success) {
            alert(response.errorMessage);
            return;
        }

        document.querySelector(ID_ACCOUNT).value = "";
        document.querySelector(ID_AMOUNT).value = "";
        document.querySelector(ID_BALANCE).value = "";
        document.getElementById('confirm_withdraw_modal').hidden = true;

        document.querySelector(ID_SUCCESS).hidden = false;
        successType = document.querySelector(ID_SUCCESS_TYPE);
        successAmount = document.querySelector(ID_SUCCESS_AMOUNT);
        successAccount = document.querySelector(ID_SUCCESS_ACCOUNT);
        successName = document.querySelector(ID_SUCCESS_NAME);
        successType.innerHTML = "withdraw";
        successAmount.innerHTML = amount;
        successAccount.innerHTML = account;
        successName.innerHTML = ACCOUNT_NAME;

}
