import { postData, getData, isLoggedIn } from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_ACCOUNT = "#withdraw_account";
const ID_AMOUNT = "#withdraw_amount";
const ID_BTN_SUBMIT  = "#withdraw_submit";

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
        btnDeposit.addEventListener("click", requestWithdraw);
}

async function requestWithdraw() {
        let account, amount, requestBody, url, response;
    
        // Validate Account Number
        account = document.querySelector(ID_ACCOUNT).value;
        if (!validateAccountNumber(account)) {
            return;
        }
    
        // Validate Amount
        amount = document.querySelector(ID_AMOUNT).value;
        if (!validateAmount(amount)) {
            return;
        }
    
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
    
function validateAccountNumber(account) {
        // Check if it's not empty
        if (!account.trim()) {
            alert("Account number cannot be empty.");
            return false;
        }
    
        // 12 digits and no other characters
        if (!/^\d{12}$/.test(account)) {
            alert("Invalid input. Please enter a valid" +
            " 12-digit Apex account number.");
            return false;
        }
    
        return true;
}
    
    
function validateAmount(amount) {
        // Check if it's not empty
        if (!amount.trim()) {
            alert("Amount cannot be empty.");
            return false;
        }
    
        // 10 digits and exactly two decimal places
        if (!/^\d{1,10}(\.\d{2})?$/.test(amount)) {
                alert("Invalid amount. Please enter a valid numeric amount" +
                " with the following criteria:\n" +
                "- Up to 10 whole digits\n" +
                "- Two decimal places (optional)\n" +
                "- No commas are allowed");
          
            return false;
        }
    
        return true;
}