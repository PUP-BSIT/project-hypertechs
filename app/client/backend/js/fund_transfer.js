import { 
        postData, getData, getExtBankUrl, genErrorMessage,
        isLoggedIn, saveRequest 
} from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_RECIPIENT = "#recipient-account-number";
const ID_AMOUNT = "#transfer-amount";
const ID_TRANSFER_BUTTON = "#submit_fund_transfer";

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
        
        redirectURL = "https://apexapp.tech/app/client/pages/account/" +
                "fund_transfer_result.php";
/*
        redirectURL = "http://localhost/app/client/pages/account/" +
                "fund_transfer_result.php";
*/
        amount = document.querySelector(ID_AMOUNT).value;
        recipient = document.querySelector(ID_RECIPIENT).value;
        source = ACCOUNT_NUMBER;
        console.log(source, recipient);
        if (recipient === source) {
                alert("Invalid account number.");
                return;
        }
        if (!recipient || !amount) {
                alert("Please fill out all the required fields.");
                return;
        }
        if (!/^\d{12}$/.test(recipient)) {
                alert("Account number should contain exactly 12 digits.");
                return;
        }
        if (!/^\d{1,6}(\.\d{2})?$/.test(amount)) {
                alert("Amount should be up to six digits " +
                        "with exactly two decimal places.");
                return;
        }
        requestBody = new FormData();
        url = "https://apexapp.tech/app/client/backend/api/fund-transfer.php";
/*
        url = "http://localhost/app/client/backend/api/fund-transfer.php";
*/
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        await postData(url, requestBody);
}
