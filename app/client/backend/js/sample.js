
/*
Javascript code for fetching APEX Bank APIs
*/

let variable1, variable2, variable3, variable4; // Example variables 
let url = "https://apexapp.tech/app/client/backend/api/fund-transfer.php";
/*
  URL for external transfer
let url = "https://apexapp.tech/app/client/backend/api/" +
        "fund-transfer-external.php";
*/
let requestBody = new FormData();

requestBody.append('redirect_url', variable1);
requestBody.append('transaction_amount', variable2);
requestBody.append('source_account_no', variable3);
requestBody.append('recipient_account_no', variable4);
/*
  Needed data for fund-transfer-external.php
requestBody.append('recipient_bank_code', "VRZN");
*/

APIResponse = await fetchAPI(url, requestBody);

async function fetchAPI(url, requestBody) {
        let statusCode, data, response;

        response = await fetch(url, {
                method: 'POST',
                body: requestBody  
        });
        statusCode = await response.status;
        data = await response.json();
        if (statusCode === 302) {
                window.location.href = data.location;
                return;
        }
        data.statusCode = statusCode;
        return data;
}

