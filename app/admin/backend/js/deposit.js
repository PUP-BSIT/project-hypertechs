import { postData, getData, isLoggedIn } from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_ACCOUNT = "#deposit_account";
const ID_AMOUNT = "#deposit_amount";
const ID_BTN_SUBMIT  = "#deposit_submit";

main();

async function main() {
        let url, loggedIn, btnDeposit, response;

        loggedIn = await isLoggedIn();
        if (!loggedIn) {
                window.location.href = URL_HOME;
        }
        url = "../../backend/php/admin-session.php";
        response = await getData(url);
        ACCOUNT_NUMBER = response.adminId;
        console.log(ACCOUNT_NUMBER);
        btnDeposit = document.querySelector(ID_BTN_SUBMIT);
        btnDeposit.addEventListener("click", requestDeposit);
}

async function requestDeposit() {
        let account, amount, requestBody, url, response;
    
        account = document.querySelector(ID_ACCOUNT).value;
        if (!isValidAccountNumber(account)) {
                alert("Invalid input. Please enter a valid " +
                " 12-digit Apex account number.");
                return;
        }

        amount = document.querySelector(ID_AMOUNT).value;
        if (!isValidAmount(amount)) {
                alert("Invalid amount. Please enter a valid numeric amount" +
                " with the following criteria:\n" +
                "- Up to 10 whole digits\n" +
                "- Two decimal places (optional)\n" +
                "- No commas are allowed");
                return;
        }
    
        // Prepare request body
        requestBody = new FormData();
        requestBody.append('account_number', account);
        requestBody.append('amount', amount);
        requestBody.append('admin_id', ACCOUNT_NUMBER);
    
        // Make deposit request
        url = "/app/admin/backend/php/deposit.php";
        response = await postData(url, requestBody);
        console.log(response);
    
        // Handle response
        if (!response.success) {
            alert(response.errorMessage);
            return;
        }
        alert("Deposit successful!");
}
    
function isValidAccountNumber(account) {
        // 12 digits with no spaces or non-numeric characters
        return /^\d{12}$/.test(account);
}
    
function isValidAmount(amount) {
        // 10 digits and exactly two decimal places
        const amountRegex = /^\d{1,10}(?:\.\d{2})?$/;
    
        // Check if the amount is not zero and is at least 100
        const isNonZero = parseFloat(amount) !== 0;
        const isAtLeast100 = parseFloat(amount) >= 100;
    
        return amountRegex.test(amount) && isNonZero && isAtLeast100;
}