import { 
        sendData, fetchData, showFeedback, getExtBankUrl, genErrorMessage,
        checkCustomerSession, BANK_CODE, clearFeedback
} from "./common.js";

let ACCOUNT_NUMBER;
const ID_RECIPIENT = "#recipient-account-number";
const ID_AMOUNT = "#transfer-amount";
const ID_TRANSFER_BUTTON = "#submit_fund_transfer";
const ID_FEEDBACK = "#feedback_transfer";

main();

function main() {
        checkCustomerSession(startOperation, ACCOUNT_NUMBER);
}

function startOperation() {
        let btnTransfer, transferFeedback, chkExternal, bankSelect;

        fetchData("../../backend/php/customer-session.php", setAccountNumber);
}

function setAccountNumber(data) {
        ACCOUNT_NUMBER = data.accountNumber;
        setupSendButton();
}

function setupSendButton() {
        let btnTransfer;

        btnTransfer = document.querySelector(ID_TRANSFER_BUTTON);
        btnTransfer.addEventListener("click", requestTransfer);
}

function requestTransfer() {
        let amount, recipient, source, url, bankCode, chkExternal, bankSelect,
                requestBody, redirectURL, feedback;
        
        redirectURL = "./result.php";
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        source = ACCOUNT_NUMBER;
        feedback = document.querySelector(ID_FEEDBACK);
        console.log(source, recipient);
        if (recipient === source) {
                feedback.innerHTML = "Account number is not valid";
                clearFeedback(feedback);
                return;
        }
        if (!recipient || !amount) {
                feedback.innerHTML = "Please fill the required fields";
                clearFeedback(feedback);
                return;
        } 
        requestBody = new FormData();
        url = "../../backend/php/fund-transfer.php";
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        sendData(url, requestBody, showTransferFeedback);
}

function showTransferFeedback(data) {
        if (!data) return;
        let message;
        console.log(data);

        if (!data.fundTransferSuccess) {
                message = genErrorMessage(data.statusCode);
                window.location.href = "./result.php?error_message=" +
                        message;
                return;
        }
        return;
}
