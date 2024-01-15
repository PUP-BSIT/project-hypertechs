import { 
        postData, getData, getExtBankUrl, genErrorMessage,
        isLoggedIn, saveRequest 
} from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_RECIPIENT = "#recipient-account-number-external";
const ID_AMOUNT = "#transfer-amount-external";
const ID_BANK_CODE= "#external-bank-code";
const ID_TRANSFER_BUTTON = "#submit_external";

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
                requestBody, redirectURL;
        
        redirectURL = "/app/client/pages/account/fund_transfer_result.php";
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        source = ACCOUNT_NUMBER;
        bankCode = document.querySelector(ID_BANK_CODE).value;
        console.log(source, recipient);
        if (recipient === source) {
                alert("Invalid account number.");
                return;
        }
        if (!recipient || !amount || !bankCode) {
                alert("Please fill out all the required fields.");
                return;
        }
        if (!/^\d{1,6}$/.test(amount)) {
                alert("Amount should be limited to six digits only.");
                return;
        }
        requestBody = new FormData();
        url = "/app/client/backend/api/fund-transfer-external.php";
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        requestBody.append('recipient_bank_code', bankCode);
        await postData(url, requestBody);
}
