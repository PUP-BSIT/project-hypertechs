import {
        sendData,
        fetchData,
        showFeedback,
        getExtBankUrl,
        genErrorMessage,
        checkCustomerSession,
} from "./common.js";

let ACCOUNT_NUMBER;
const ID_SELECT_BANK = "#external-bank-code";
const ID_TRANSFER_BUTTON = "#submit_external";
const ID_AMOUNT = "#transfer-amount-external";
const ID_RECIPIENT = "#recipient-account-number-external";

main();

function main() {
        checkCustomerSession(startOperation);
}

function startOperation() {
        let btnTransfer, transferFeedback, chkExternal, bankSelect;

        fetchData("../../backend/php/customer-session.php", setAccountNumber);
}

function setAccountNumber(data) {
        let btnTransfer, url, requestBody;

        ACCOUNT_NUMBER = data.accountNumber;
        btnTransfer = document.querySelector(ID_TRANSFER_BUTTON);
        btnTransfer.addEventListener("click", requestTransfer);
}

function requestTransfer() {
        let amount, recipient, source, url, requestBody, redirectURL,
                message, bankCode, externalBankCode;

        console.log("WOKRS");
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        source = ACCOUNT_NUMBER;
        externalBankCode = document.querySelector(ID_SELECT_BANK).value;
        if (recipient === source) return;
        if (!recipient && !amount) return;
        if (!externalBankCode) return;
        url = "../../backend/php/bank-info.php";
        requestBody = new FormData();
        requestBody.append('recipient_bank_code', externalBankCode);  
        sendData(url, requestBody, requestExternal);

        function requestExternal(data) {
                if (!data.success) return;
                url = data.externalBankURL;
                bankCode = data.bankCode;
                requestBody.delete('recipient_bank_code');  
                requestBody.append('transaction_amount', amount);
                requestBody.append('source_account_no', source);
                requestBody.append('source_bank_code', bankCode);
                requestBody.append('recipient_account_no', recipient);
                console.log(requestBody, url);
                return;
                sendData(url, requestBody, requestInternal);
        }

        function requestInternal(data) {
                if (!data.fundTransferSuccess) {
                        showTransferFeedback(data);
                        return;
                }
                redirectURL = "./external_result.php";
                requestBody.append('redirect_url', redirectURL);
                //requestBody.append('transaction_id', data.transactionID);
                requestBody.append('recipient_bank_code', externalBankCode);
                requestBody.delete('source_bank_code'); 
                url = "../../backend/php/fund-transfer-external.php";
                sendData(url, requestBody, showTransferFeedback); 
        }
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
