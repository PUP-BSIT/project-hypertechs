import { 
        postData, getData, isLoggedIn, strToNum
} from "./common_new.js";
    
let ACCOUNT_NUMBER;
let customerData; // Declare a global variable to store customer data
const ID_LOGOUT_BUTTON = "#logout";
const ID_ACCOUNT_NAME = "#display_account_holder";
const ID_ACCOUNT_NUMBER = "#display_account_number";
const ID_BALANCE = "#display_account_balance";
const ID_FIRST_NAME = "#account_first_name";
const ID_MINI_NAME = "#display_mini_account_text";
const ID_LAST_TRANSAC = "#account_last_access";
const HOME_URL = "/index.html";

console.log("Hello");
main();
    
async function main() {
        let response, loggedIn, accountName, accountNumber, balance, url;

        loggedIn = await isLoggedIn();
        if (!loggedIn) {
                window.location.href = HOME_URL;
                return;
        }
        url = "/app/client/backend/php/customer-session.php";
        response = await getData(url);
        if (!response.success) {
                return;
        }
        ACCOUNT_NUMBER = response.accountNumber;
        getCustomerInfo();
}
    
async function getCustomerInfo() {
        let sessionAccount, url, requestBody, response;

        url = "/app/client/backend/php/customer-info.php";
        sessionAccount = ACCOUNT_NUMBER;
        requestBody = new FormData();
        requestBody.append('account_number', sessionAccount);
        response = await postData(url, requestBody);
        console.log(response);
        if (!response.success) return;
                customerData = response; // Store customer data globally
                showCustomerData(customerData);
        }
    
function showCustomerData(data) {
        let accountName, accountNumber, balance, firstName, name, miniName,
                lastTransac;

        console.log(data);
        firstName = document.querySelector(ID_FIRST_NAME);
        miniName = document.querySelector(ID_MINI_NAME);
        accountName = document.querySelector(ID_ACCOUNT_NAME);
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER);
        balance = document.querySelector(ID_BALANCE);
        lastTransac = document.querySelector(ID_LAST_TRANSAC);

        if (firstName) {
                firstName.innerHTML = data.data.firstName + "!";
        }
        if (miniName) {
                miniName.innerHTML = data.data.name;
        }
        if (accountName || accountNumber || balance || lastTransac) {
                accountName.innerHTML = data.data.name;
                accountNumber.innerHTML = data.data.accountNumber;
                balance.innerHTML = strToNum(data.data.balance);
                if (data.data.lastTransac) {
                        lastTransac.innerHTML = data.data.lastTransac;
                }

                // Add event listener to toggle between partial and full display
                document.getElementById("account_number")
                        .addEventListener("click", toggleAccountNumberDisplay);

                // Show the first four characters immediately
                const partialDisplayElement = document
                        .querySelector("#display_account_number");
                const partialAccountNumber = data.data.accountNumber
                        .substring(0, 4) + "••••••••";
                partialDisplayElement.innerHTML = partialAccountNumber;
        }
}
    
    
function toggleAccountNumberDisplay() {
        const accountNumberElement = document.querySelector(ID_ACCOUNT_NUMBER);
        const partialDisplayElement = document
                .querySelector("#display_account_number");

        if (accountNumberElement && partialDisplayElement) {
                const fullAccountNumber = customerData.data.accountNumber;
                const maskedPart = fullAccountNumber.substring(4)
                        .replace(/./g, "•");

                if (accountNumberElement.innerHTML === fullAccountNumber) {
                        partialDisplayElement.innerHTML = 
                                partialDisplayElement
                                .innerHTML.substring(0, 4) + maskedPart;
                } else {
                        partialDisplayElement.innerHTML = fullAccountNumber;
                }
        }
}
