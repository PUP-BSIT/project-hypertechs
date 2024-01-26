import { postData, getData, isLoggedIn } from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_ACCOUNT = "#withdraw_account";
const ID_AMOUNT = "#withdraw_amount";
const ID_BTN_SUBMIT  = "#withdraw_submit";
const ID_CONFIRM_BUTTON ="#confirm_withdraw_button";
const ID_ERROR_DESC = "#transfer_error_desc";

main();

async function main() {
        let url, loggedIn, btnDeposit, response, confirmButton;

        loggedIn = await isLoggedIn();
        if (!loggedIn) {
            window.location.href = URL_HOME;
        }
        url = "../../backend/php/admin-session.php";
        response = await getData(url);
        ACCOUNT_NUMBER = response.adminId;
        console.log(ACCOUNT_NUMBER);
        btnDeposit = document.querySelector(ID_BTN_SUBMIT);
        btnDeposit.addEventListener("click", validateWithdraw);

        confirmButton = document.querySelector(ID_CONFIRM_BUTTON);
        confirmButton.addEventListener("click", requestWithdraw);
}

function validateWithdraw() {
        let account, amount, requestBody, url, response, errorMsg;

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
            errorMsg.innerHTML = "Invalid input. Please enter a valid 12-digit Apex account number.";
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

        document.getElementById('confirm_withdraw_modal').style.display = 'block';
}

async function requestWithdraw() {
        let account, amount, requestBody, url, response, confirmButton;

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

        alert("Withdraw successful!");
}
