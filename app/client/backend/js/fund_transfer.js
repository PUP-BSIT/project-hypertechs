import { 
        postData, getData, getExtBankUrl, genErrorMessage, isLoggedIn, 
        saveRequest, strToNum 
} from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_RECIPIENT = "#recipient-account-number";
const ID_AMOUNT = "#transfer-amount";
const ID_TRANSFER_BUTTON = "#submit_fund_transfer";
const ID_DESCRIPTION = "#transfer-description";
const ID_CONFIRM_BUTTON = "#confirm_internal_button";
const ID_ERROR_DESC = "#transfer_error_desc";
const ID_CONFIRM_ACCOUNT = "#display_modal_acc_number";
const ID_CONFIRM_NAME = "#display_modal_acc_name";
const ID_CONFIRM_AMOUNT = "#display_modal_transfer_amount";

main();

async function main() {
        let url, loggedIn, btnTransfer, bankSelect, response, confirmButton;

        loggedIn = await isLoggedIn();
        if (!loggedIn) {
                window.location.href = URL_HOME;
        }
        url = "../../backend/php/customer-session.php"; 
        response = await getData(url);
        ACCOUNT_NUMBER = response.accountNumber;
        btnTransfer = document.querySelector(ID_TRANSFER_BUTTON);
        btnTransfer.addEventListener("click", validateTransfer);
        confirmButton = document.querySelector(ID_CONFIRM_BUTTON);
        confirmButton.addEventListener("click", requestTransfer);
}

async function validateTransfer() {
        let amount, recipient, source, url, bankCode, chkExternal, bankSelect,
                requestBody, redirectURL, description, confirmButton, errorMsg,
                modalResize, response, confirmAccount, confirmName,
                confirmAmount;
        
        redirectURL = "https://apexapp.tech/app/client/pages/account/" +
                "fund_transfer_result.php";
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        description = document.querySelector(ID_DESCRIPTION).value;
        source = ACCOUNT_NUMBER;
        if (recipient === source) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "You have entered an invalid Apex Account"
                        + " number.";
                return;
        }
        if (!recipient || !amount) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "Please fill out all the required fields"
                        + " to proceed.";
                return;
        }
        if (parseFloat(amount) === 0) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The transfer amount cannot be zero.";
                return;
        }
        if (!/^\d{12}$/.test(recipient)) {
                document.getElementById('transfer_error_modal').hidden = false;
                modalResize = document
                        .querySelector('.transfer-error-modal-content');
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The recipient account number must be"
                        + " exactly a valid 12-digit Apex account number.";
                return;
        }
        if (!/^\d{1,6}(\.\d{2})?$/.test(amount)) {
                document.getElementById('transfer_error_modal').hidden = false;
                modalResize = document
                        .querySelector('.transfer-error-modal-content');
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The transfer amount must be up to six" + 
                        " whole digits only, two decimals (if present), " +
                        "and no commas.";
                return;
        }

        requestBody = new FormData();
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        requestBody.append('description', description);
        url = "/app/client/backend/php/fund-transfer-check.php";
        response = await postData(url, requestBody);
        if(!response.success) {
                document.getElementById('transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = response.errorMessage;
                return;
        }

        document.querySelector('#confirm_details_modal').hidden = false;
        confirmAccount = document.querySelector(ID_CONFIRM_ACCOUNT);
        confirmName = document.querySelector(ID_CONFIRM_NAME);
        confirmAmount = document.querySelector(ID_CONFIRM_AMOUNT);
        confirmAccount.innerHTML = recipient;
        confirmName.innerHTML = response.accountName;
        confirmAmount.innerHTML = "&#8369 " + strToNum(amount);

}

async function requestTransfer() {
        let amount, recipient, source, url, bankCode, bankSelect,
                requestBody, redirectURL, description;

        redirectURL = "https://apexapp.tech/app/client/pages/account/" +
                "fund_transfer_result.php";
        /*
        redirectURL = "http://localhost/app/client/pages/account/" +
                "fund_transfer_result.php";
        */
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        description = document.querySelector(ID_DESCRIPTION).value;
        source = ACCOUNT_NUMBER;
        requestBody = new FormData();
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        requestBody.append('description', description);
        url = "https://apexapp.tech/app/client/backend/api/" +
                "fund-transfer.php";
        /*
        url = "http://localhost/app/client/backend/api/" +
                "fund-transfer.php";
        */
        await postData(url, requestBody);
}
