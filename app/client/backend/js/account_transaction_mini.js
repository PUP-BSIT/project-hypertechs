import { postData } from "./common_new.js";

const TABLE_BODY_SELECTOR = '#recent_transactions_table tbody';

// Wait for the HTML document to fully load
document.addEventListener('DOMContentLoaded', () => {
    loadTransactions();
});

async function loadTransactions() {
    let tableBody, tableRow, tableCell, url, response, requestBody;

    url = "/app/client/backend/php/account-transaction-mini.php";
    requestBody = new FormData();

    response = await postData(url, requestBody);
    tableBody = document.querySelector(TABLE_BODY_SELECTOR);

    if (response.data.length === 0) {
        tableBody.innerHTML = "No transactions found";
        return;
    }

    tableBody.innerHTML = "";
    for (let transaction of response.data) {
        tableRow = tableBody.insertRow();
        for (let key in transaction) {
            tableCell = tableRow.insertCell();
            tableCell.innerHTML = transaction[key];
        }
    }
}