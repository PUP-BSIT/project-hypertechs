import { postData, getData, isLoggedIn } from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_ACCOUNT = "#deposit_account";
const ID_AMOUNT = "#deposit_amount";
const ID_BTN_SUBMIT  = "#deposit_submit";

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
        btnDeposit.addEventListener("click", requestDeposit);
}

async function requestDeposit() {
        let account, amount, requestBody, url, response;
       
        account = document.querySelector(ID_ACCOUNT).value; 
        amount = document.querySelector(ID_AMOUNT).value; 
        requestBody = new FormData();
        requestBody.append('account_number', account);
        requestBody.append('amount', amount);
        requestBody.append('admin_id', ACCOUNT_NUMBER);
        url = "/app/admin/backend/php/deposit.php";
        response = await postData(url, requestBody);
        console.log(response);
        if (!response.success) {
                alert(response.errorMessage);
                return;
        }
        alert("Deposit successful!");
}
