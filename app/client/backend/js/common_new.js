export const BANK_CODE = "goodgghh7788";
const HOME_URL = "../home.html";

export async function postData(url, requestBody) {
        let statusCode, response, data ;

        response = await fetch(url, {
                method: 'POST',
                body: requestBody 
        });
        statusCode = await response.status;
        data = await response.json();
        if (statusCode === 302) {
                window.location.href = data.url;
                return;
        }
        data.statusCode = statusCode;
        return data;
}

export async function getData(url) {
        let statusCode, response, data ;

        response = await fetch(url);
        statusCode = await response.status;
        data = await response.json();
        if (statusCode === 302) {
                window.location.href = data.url;
                return;
        }
        data.statusCode = statusCode;
        return data;
}

export function showFeedback(message, errMessage, result, area) {
        if (!result) {
                area.innerHTML = errMessage;
                return;
        }
        area.innerHTML = message;
        setTimeout(() => {
                area.innerHTML = "";
        }, 3000);
}

export function strToNum(number) {
        number = parseFloat(number);
        return number.toLocaleString('en-US', {
                style: 'decimal',
                minimumFractionDigits: 2
        });
}

export function getExtBankUrl(bankCode) {
        let url;

        switch (bankCode) {
        case "greenaabb1122":
                url = "http://localhost/greenbank/api/" +
                        "receive-external-transfer.php";
                break;
        case "newccdd3344":
                url = "http://localhost/newbank/api/" +
                        "receive-external-transfer.php";
                break;
        case "happyeeff5566":
                url = "http://localhost/happybank/api/" +
                        "receive-external-transfer.php";
                break;
        }
        return url;
}

export function genErrorMessage(statusCode) {
        let message;

        switch (statusCode) {
        case 400:
                message = "The server couldn't understand your request. " 
                        + "Check your input if it is correct.";
                break;
        case 401:
                message = "Access denied. Please provide valid credentials "
                        + "to access the requested resource.";
                break;
        case 403:
                message = "You don't have permission to access this resource. "
                        + "Contact the administrator for access.";
                break;
        case 404:
                message = "The resource could not be found. Check your input "
                        + "if it is correct.";
                break;
        default:
                message = "There was an error. Try reloading the page.";
        }
        return message;
}

export function clearFeedback(area) {
        setTimeout(() => {
                area.innerHTML = "&nbsp";
        }, 3000);
}

export async function isLoggedIn() {
        let url, response;

        url = "/app/client/backend/php/customer-session.php";
        response = await getData(url);
        if (!response.success) return false;
        return true;
}

export async function saveRequest(requestURL, requestBody) {
        let data, url, saveURL, response, sessionURL;

        url = "/app/client/backend/php/request-save.php";
        data = new FormData();
        data.append('request_url', requestURL);
        data.append('request_body', formToJSON(requestBody));
        response = await postData(url, data)
        console.log(response.success);
        if (!response.success) return false;
        startVerify();
}

async function startVerify() {
        let url, requestBody;

        url = "/app/client/backend/php/otp-session.php"
        requestBody = new FormData();
        requestBody.append('start', true);
        await postData(url, requestBody);
        window.location.href = "/app/client/pages/otp_test.html";
}

export async function sendRequest() {
        let url, response, data, requestBody;

        url = "/app/client/backend/php/" +
                "request-retrieve.php";
        response = await getData(url);
        console.log(response);
        if (!response.success) return false;
        console.log(response.requestBody);
        data = JSON.parse(response.requestBody);
        console.log(data);
        requestBody = new FormData();
        for (let key in data) {
                requestBody.append(key, data[key]);
        }
        await postData(response.requestURL, requestBody);
        url = "/app/client/backend/php/request-destroy.php";
        await getData(url);
        return true;
}

function checkValue(value) {
        if (isNaN(value)) return value;
        return Number(value);
}

export function formToJSON(formData) {
        let form;

        form = {};
        formData.forEach((value, key) => {
                form[key] = value;
        });
        console.log(JSON.stringify(form));
        return JSON.stringify(form);
}
