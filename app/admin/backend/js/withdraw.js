import { postData, getData, isLoggedIn } from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_ACCOUNT = "#withdraw_account";
const ID_AMOUNT = "#withdraw_amount";
const ID_BTN_SUBMIT  = "#withdraw_submit";
const ID_SUCCESS_DESC = "#success_details_text";

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
        let account, amount, requestBody, url, response, successMsg;
        const ID_CONFIRM_BUTTON = "#confirm_transaction_button";
    
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

        document.getElementById('confirm_details_modal').style.display = 'block';
        const confirmButton = document.querySelector(ID_CONFIRM_BUTTON);
        confirmButton.addEventListener("click", async () => { 
    
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
            
            document.getElementById('confirm_details_modal').style.display = 'none';
            let confirmationDetailsModal = document.getElementById("confirm_details_modal");
            let confirmDetailsModalContent = document.querySelector(".confirm-modal-content");

            confirmDetailsModalContent.classList.add("zoom-out-confirm");

            setTimeout(function () {
            confirmationDetailsModal.style.display = "none";
            confirmDetailsModalContent.classList.remove("zoom-out-confirm");
            }, 500);

            document.getElementById('transaction_success_modal').style.display = 'block';
            successMsg = document.querySelector(ID_SUCCESS_DESC);
            successMsg.innerHTML = "Withdraw Successful!";

        });
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

    // Check if it's greater than zero
    if (parseFloat(amount) <= 0) {
        alert("Amount must be at least 100 pesos.");
        return false;
    }

    // Check if it's above 100 pesos and follows the format
    if (!/^\d{1,9}(\.\d{2})?$/.test(amount) || parseFloat(amount) < 100) {
        alert("Invalid amount. Please enter a valid numeric amount with " +
            "the following criteria:\n\n" +
            "• Up to 10 figures only\n" +
            "• Two decimal places (optional), if present\n" +
            "• No commas are allowed\n");
        return false;
    }

    return true;
}
