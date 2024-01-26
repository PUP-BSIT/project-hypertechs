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
const ID_MINI_BALANCE = "#display_mini_account_balance";
const ID_LAST_TRANSAC = "#account_last_access";
const ID_TOTAL_TRANSAC = "#display_times_transactions";
const ID_TOTAL_TRANSFERRED  = "#display_transfer_transactions";
const ID_TOTAL_RECEIVED  = "#display_received_transactions";
const ID_AVERAGE_TRANSFERRED  = "#display_average_transferred";
const ID_CARD_NUMBER = "#display_card_number";
const ID_CARD_EXPIRATION = "#display_card_expiration";
const ID_CVV = "#display_cvv";
const HOME_URL = "/index.html";

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
        if (!response.success) return;
                customerData = response; // Store customer data globally
                showCustomerData(customerData);
        }
    
function showCustomerData(data) {
        let accountName, accountNumber, balance, firstName, name, miniName,
                miniBalance,
                lastTransac, totalTransac, totalTransferred,
                totalReceived, averageTransferred, cardNumber, cardExpiration,
                cvv;

        firstName = document.querySelector(ID_FIRST_NAME);
        miniName = document.querySelector(ID_MINI_NAME);
        miniBalance = document.querySelector(ID_MINI_BALANCE);
        accountName = document.querySelector(ID_ACCOUNT_NAME);
        accountNumber = document.querySelector(ID_ACCOUNT_NUMBER);
        balance = document.querySelector(ID_BALANCE);
        lastTransac = document.querySelector(ID_LAST_TRANSAC);
        totalTransac = document.querySelector(ID_TOTAL_TRANSAC);
        totalTransferred = document.querySelector(ID_TOTAL_TRANSFERRED);
        totalReceived = document.querySelector(ID_TOTAL_RECEIVED);
        averageTransferred = document.querySelector(ID_AVERAGE_TRANSFERRED);
        cardNumber = document.querySelector(ID_CARD_NUMBER);
        cardExpiration = document.querySelector(ID_CARD_EXPIRATION);
        cvv = document.querySelector(ID_CVV);

        if (firstName) {
                firstName.innerHTML = data.data.firstName + "!";
        }
        if (miniName) {
                miniName.innerHTML = data.data.name;
        }
        if (miniBalance) {
                miniBalance.innerHTML = strToNum(data.data.balance);
        }
        if (accountName || accountNumber || balance || lastTransac) {
                accountName.innerHTML = data.data.name;
                accountNumber.innerHTML = data.data.accountNumber;
                balance.innerHTML = strToNum(data.data.balance);
                totalTransac.innerHTML = data.data.totalTransac;
                totalTransferred.innerHTML =
                strToNum(data.data.totalTransferred);
                totalReceived.innerHTML = strToNum(data.data.totalReceived);
                averageTransferred.innerHTML =
                strToNum(data.data.averageTransferred);
                cardNumber.innerHTML = formatCardNumber(data.data.cardNumber);
                cardExpiration.innerHTML = data.data.cardExpiration;
                cvv.innerHTML = data.data.cvv;
                if (data.data.lastTransac) {
                lastTransac.innerHTML = data.data.lastTransac;
                }

                // Add event listener to toggle between partial and full display
                document.getElementById("account_number")
                .addEventListener("click", toggleAccountNumberDisplay);

                document.getElementById("card_number")
                .addEventListener("click", toggleCardNumberDisplay);

                // Show the first four characters immediately
                const partialDisplayElementAccount = document
                .querySelector("#display_account_number");
                const partialAccountNumber = data.data.accountNumber
                .substring(0, 4) + "••••••••";
                partialDisplayElementAccount.innerHTML = partialAccountNumber;

                const partialDisplayElementCard = document
                .querySelector("#display_card_number");
                const partialCardNumber = formatPartialCardNumber(data.data.cardNumber);
                partialDisplayElementCard.innerHTML = partialCardNumber;
        }
}

function formatCardNumber(number) {
        let result, segment;

        result = "";
        for (let i = 0; i < number.length; i += 4) {
                segment = number.substring(i, i + 4);
                result += segment + " ";
        }
        return result.trim();
}

function formatPartialCardNumber(number) {
        return number.substring(0, 4) + " •••• •••• " + number.substring(number.length - 4);
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

function toggleCardNumberDisplay() {
        const fullCardNumber = customerData.data.cardNumber;
        const partialDisplayElement = document.querySelector("#display_card_number");
    
        if (partialDisplayElement) {
            const maskedPart = formatPartialCardNumber(fullCardNumber).substring(5);
            if (partialDisplayElement.innerHTML === formatCardNumber(fullCardNumber)) {
                partialDisplayElement.innerHTML = partialDisplayElement.innerHTML.substring(0, 4) + " " + maskedPart;
            } else {
                partialDisplayElement.innerHTML = formatCardNumber(fullCardNumber);
            }
        }
    }
    
