import { 
        postData, getData, showFeedback, getExtBankUrl, genErrorMessage,
        isLoggedIn, clearFeedback, saveRequest 
} from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_RECIPIENT = "#recipient-account-number";
const ID_AMOUNT = "#transfer-amount";
const ID_TRANSFER_BUTTON = "#submit_fund_transfer";
const ID_FEEDBACK = "#feedback_transfer";

main();

async function main() {
        let url, loggedIn, btnTransfer, transferFeedback, chkExternal, 
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
                requestBody, redirectURL, feedback;
        
        redirectURL = "./account/result.php";
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
        url = "../backend/php/fund-transfer.php";
        requestBody.append('redirect_url', redirectURL); 
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        await saveRequest(url, requestBody);
}
