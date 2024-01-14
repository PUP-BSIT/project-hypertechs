const HOME_URL = "../home.html";

export async function postData(url, requestBody) {
  let statusCode, response, data;

  response = await fetch(url, {
    method: "POST",
    body: requestBody,
  });
  statusCode = await response.status;
  data = await response.json();
  console.log(data);
  if (statusCode === 302) {
    setTimeout(() => {
      window.location.href = data.url;
    }, 4000);
    return;
  }
  data.statusCode = statusCode;
  return data;
}

export async function getData(url) {
  let statusCode, response, data;

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
  return number.toLocaleString("en-US", {
    style: "decimal",
    minimumFractionDigits: 2,
  });
}

export function genErrorMessage(statusCode) {
  let message;

  switch (statusCode) {
    case 400:
      message =
        "The server couldn't understand your request. " +
        "Check your input if it is correct.";
      break;
    case 401:
      message =
        "Access denied. Please provide valid credentials " +
        "to access the requested resource.";
      break;
    case 403:
      message =
        "You don't have permission to access this resource. " +
        "Contact the administrator for access.";
      break;
    case 404:
      message =
        "The resource could not be found. Check your input " +
        "if it is correct.";
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

  url = "/app/admin/backend/php/admin-session.php";
  response = await getData(url);
  if (!response.success) return false;
  return true;
}

export async function saveRequest(requestURL, requestBody) {
  let data, url, saveURL, response, sessionURL;

  url = "/app/admin/backend/php/request-save.php";
  data = new FormData();
  data.append("request_url", requestURL);
  data.append("request_body", formToJSON(requestBody));
  response = await postData(url, data);
  console.log(response.success);
  if (!response.success) return false;
  startVerify();
}

async function startVerify() {
  let url, requestBody;

  url = "/app/admin/backend/php/otp-session.php";
  requestBody = new FormData();
  requestBody.append("start", true);
  await postData(url, requestBody);
  window.location.href = "/app/admin/pages/verify.html";
}

export async function sendRequest() {
  let url, response, data, requestBody;

  url = "/app/admin/backend/php/" + "request-retrieve.php";
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
  url = "/app/admin/backend/php/request-destroy.php";
  await getData(url);
  return true;
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

export async function destroyOTPSession(option) {
  let url, data, requestBody;

  console.log("destroySession");
  url = "../backend/php/otp-session.php";
  requestBody = new FormData();
  if (option === "OTPOnly") {
    requestBody.append("destroy_otp", true);
    await postData(url, requestBody);
    return;
  }
  requestBody.append("destroy", true);
  await postData(url, requestBody);
}
