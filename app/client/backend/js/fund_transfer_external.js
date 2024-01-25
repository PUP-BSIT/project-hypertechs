import { 
        postData, getData, getExtBankUrl, genErrorMessage,
        isLoggedIn, saveRequest, strToNum 
} from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_RECIPIENT = "#recipient-account-number-external";
const ID_AMOUNT = "#transfer-amount-external";
const ID_BANK_CODE= "#external-bank-code";
const ID_TRANSFER_BUTTON = "#submit_external";
const ID_CONFIRM_BUTTON = "#confirm_external_button";
const ID_ERROR_DESC = "#transfer_error_desc";
const ID_CONFIRM_ACCOUNT = "#display_modal_acc_number";
const ID_CONFIRM_NAME = "#display_modal_acc_name";
const ID_CONFIRM_AMOUNT = "#display_modal_transfer_amount";


main();

async function main() {
        let url, loggedIn, btnTransfer, chkExternal, 
                bankSelect, response;

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
        let amount, recipient, source, url, bankCode, bankSelect,
                requestBody, redirectURL, data, confirmButton,  errorMsg,
                modalResize, response, confirmAccount, confirmName, 
                confirmAmount;
        
        redirectURL = "https://apexapp.tech/app/client/pages/account/" +
                "fund_transfer_result.php";
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        source = ACCOUNT_NUMBER;
        bankCode = document.querySelector(ID_BANK_CODE).value;
        console.log(source, recipient);
        if (recipient === source) {
                document.querySelector('#transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "You have entered an invalid account"
                + " number.";
                return;
        }
        if (!recipient || !amount || !bankCode) {
                document.querySelector('#transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "Please fill out all the required fields"
                + " to proceed.";
                return;
        }
        if (parseFloat(amount) === 0) {
                document.querySelector('#transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The transfer amount cannot be zero.";
                return;
        }
        if (!/^\d{1,6}(\.\d{2})?$/.test(amount)) {
                document.querySelector('#transfer_error_modal').hidden = false;
                modalResize = document.querySelector('.transfer-error-modal-content');
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The transfer amount must be up to six"
                + " whole digits only, two decimals (if present), and no commas.";
                
                //modalResize.style.height = '45vh';

                return;
        }

        requestBody = new FormData();
        url = "https://apexapp.tech/app/client/backend/php/" +
                "fund-transfer-external-check.php";
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        requestBody.append('recipient_bank_code', bankCode);
        response = await postData(url, requestBody);
        if (!response.success) {
                document.querySelector('#transfer_error_modal').hidden = false;
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = response.errorMessage;
                return;
        }

        document.querySelector('#external_details_modal').hidden = false;
        confirmAccount = document.querySelector(ID_CONFIRM_ACCOUNT);
        confirmName = document.querySelector(ID_CONFIRM_NAME);
        confirmAmount = document.querySelector(ID_CONFIRM_AMOUNT);
        confirmAccount.innerHTML = recipient;
        confirmName.innerHTML = response.accountName;
        confirmAmount.innerHTML = "&#8369 " + strToNum(amount);
}
async function requestTransfer() {
        let amount, recipient, source, url, bankCode, chkExternal, bankSelect,
                requestBody, redirectURL, data; 
        /*
        redirectURL = "http://localhost/app/client/pages/account/" +
                "fund_transfer_result.php";
        */
        redirectURL = "https://apexapp.tech/app/client/pages/account/" +
                "fund_transfer_result.php";
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        source = ACCOUNT_NUMBER;
        bankCode = document.querySelector(ID_BANK_CODE).value;
        console.log(source, recipient);
        requestBody = new FormData();
        /*
        url = "http://localhost/app/client/backend/api/" +
                "fund-transfer-external.php";
        */
        url = "https://apexapp.tech/app/client/backend/api/" +
                "fund-transfer-external.php";
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        requestBody.append('recipient_bank_code', bankCode);
        data = await postData(url, requestBody);
        console.log(data);
}
