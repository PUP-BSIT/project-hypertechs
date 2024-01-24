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

// Declare variables at a higher scope
let amount, recipient, source, description;

main();

async function main() {
    let url, loggedIn, btnTransfer, response;

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
    let url, requestBody, redirectURL;

    redirectURL = "https://apexapp.tech/app/client/pages/account/fund_transfer_result.php";

    amount = document.querySelector(ID_AMOUNT).value;
    recipient = document.querySelector(ID_RECIPIENT).value;
    description = document.querySelector(ID_DESCRIPTION).value;
    source = ACCOUNT_NUMBER;

    if (recipient === source) {
        alert("Invalid account number.");
        return;
    }
    if (!recipient || !amount) {
        alert("Please fill out all the required fields.");
        return;
    }
    if (parseFloat(amount) === 0) {
        alert("Transfer amount cannot be 0.");
        return;
    }
    if (!/^\d{12}$/.test(recipient)) {
        alert("Account number should contain exactly 12 digits.");
        return;
    }
    if (!/^\d{1,6}(\.\d{2})?$/.test(amount)) {
        alert("Amount should be up to six digits with exactly two decimal digits and no commas.");
        return;
    }

    // If all validations pass, show the confirmation popup
    showConfirmDetailsPopUp();
}

/* Confirm Details Modal settings */
function showConfirmDetailsPopUp() {
    document.getElementById('confirm_details_modal').style.display = 'block';
    let confirmTransferButton = document.getElementById("confirm_transfer_button");
    confirmTransferButton.addEventListener("click", handleConfirmTransfer);
}

async function handleConfirmTransfer() {
    try {
        // Rest of your code for handling the transfer request
        let requestBody = new FormData();
        let url = "https://apexapp.tech/app/client/backend/api/fund-transfer.php";
        /*
        url = "http://localhost/app/client/backend/api/fund-transfer.php";
        */
        requestBody.append('redirect_url', redirectURL);
        requestBody.append('transaction_amount', amount);
        requestBody.append('source_account_no', source);
        requestBody.append('recipient_account_no', recipient);
        requestBody.append('description', description);

        await postData(url, requestBody);
        
        // Close the confirmation popup after successful transfer
        closeConfirmationDetailsPopup();
    } catch (error) {
        // Handle errors if needed
        console.error(error);
    }
}

function closeConfirmationDetailsPopup() {
    document.getElementById('confirm_details_modal').style.display = 'none';
    let confirmationDetailsModal = document.getElementById("confirm_details_modal");
    let confirmDetailsModalContent = document.querySelector(".confirm-modal-content");

    confirmDetailsModalContent.classList.add("zoom-out-confirm");

    setTimeout(function () {
        confirmationDetailsModal.style.display = "none";
        confirmDetailsModalContent.classList.remove("zoom-out-confirm");
    }, 500);
}
