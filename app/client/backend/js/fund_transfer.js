import { 
        postData, getData, getExtBankUrl, genErrorMessage,
        isLoggedIn, saveRequest 
} from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_RECIPIENT = "#recipient-account-number";
const ID_AMOUNT = "#transfer-amount";
const ID_TRANSFER_BUTTON = "#submit_fund_transfer";
const ID_DESCRIPTION = "#transfer-description";
const ID_CONFIRM_BUTTON = "#confirm_transfer_button";
const ID_ERROR_DESC = "#transfer_error_desc";

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
        btnTransfer.addEventListener("click", requestTransfer);
}

async function requestTransfer() {
        let amount, recipient, source, url, bankCode, chkExternal, bankSelect,
                requestBody, redirectURL, description, confirmButton, errorMsg,
                modalResize;
        
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
        console.log(source, recipient);
        if (recipient === source) {
                document.getElementById('transfer_error_modal').style.display = 'block';
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "You have entered an invalid Apex Account"
                + " number.";
                return;
        }
        if (!recipient || !amount) {
                document.getElementById('transfer_error_modal').style.display = 'block';
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "Please fill out all the required fields"
                + " to proceed.";
                return;
        }
        if (parseFloat(amount) === 0) {
                document.getElementById('transfer_error_modal').style.display = 'block';
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The transfer amount cannot be zero."
                + " Please try again.";
                return;
        }
        if (!/^\d{12}$/.test(recipient)) {
                document.getElementById('transfer_error_modal').style.display = 'block';
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The recipient account number must be"
                + " exactly 12-digit Apex account number.";
                return;
        }
        if (!/^\d{1,6}(\.\d{2})?$/.test(amount)) {
                document.getElementById('transfer_error_modal').style.display = 'block';
                modalResize = document.querySelector('.transfer-error-modal-content');
                errorMsg = document.querySelector(ID_ERROR_DESC);
                errorMsg.innerHTML = "The transfer amount must be up to six"
                + " whole digits only, two decimals (if present), and no commas.";
                
                modalResize.style.height = '45vh';

                return;
        }

        document.getElementById('confirm_details_modal').style.display = 'block';
        confirmButton = document.querySelector(ID_CONFIRM_BUTTON);
        confirmButton.addEventListener("click", async () => {
                requestBody = new FormData();
                url = "https://apexapp.tech/app/client/backend/api/fund-transfer.php";
                /*
                url = "http://localhost/app/client/backend/api/fund-transfer.php";
                */
                requestBody.append('redirect_url', redirectURL); 
                requestBody.append('transaction_amount', amount);
                requestBody.append('source_account_no', source);
                requestBody.append('recipient_account_no', recipient);
                requestBody.append('description', description);
                await postData(url, requestBody);
        });
}