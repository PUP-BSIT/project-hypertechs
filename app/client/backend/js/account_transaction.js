import {
        getData, postData
} from "./common_new.js";

const ID_TRANSAC_TYPE = "#transaction-type";
const ID_START_DATE = "#start-date";
const ID_END_DATE = "#end-date";
const ID_BTN_FILTER = "#btn_filter";
const ID_BTN_RESET = "#btn_reset";

main();

async function main() {
        let filterButton, resetButton;

        filterButton = document.querySelector(ID_BTN_FILTER);
        filterButton.addEventListener("click", filterResult);

        resetButton = document.querySelector(ID_BTN_RESET);
        resetButton.addEventListener("click", resetFilter); 

        filterResult();
}

async function filterResult() {
        let filterType, filterStartDate, filterEndDate, tableBody, tableRow, 
                tableCell, data, filterButton, url, response, requestBody,
                tableRows;

        filterType = document.querySelector(ID_TRANSAC_TYPE).value;
        filterStartDate = document.querySelector(ID_START_DATE).value;
        filterEndDate = document.querySelector(ID_END_DATE).value;
        console.log(filterType, filterStartDate, filterEndDate);

        url = "/app/client/backend/php/account-transaction.php";
        requestBody = new FormData();
        requestBody.append('start_date', filterStartDate);
        requestBody.append('end_date', filterEndDate);
        requestBody.append('transac_type', filterType);
        response = await postData(url, requestBody);
        console.log(response);
        tableBody = document.querySelector('#transaction_table tbody');
        if (response.data.length == 0) {
                tableBody.innerHTML = "No transaction found";
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

async function resetFilter() {
        document.querySelector(ID_TRANSAC_TYPE).value = "all";
        document.querySelector(ID_START_DATE).value = "";
        document.querySelector(ID_END_DATE).value = "";
        filterResult();
}
