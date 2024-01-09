import { postData, clearFeedback, saveRequest } from "./common_new.js";

const ID_LOGIN_BUTTON = "#login_button";
const ID_LOGIN_FEEDBACK = "#feedback_test";
const ID_ACCOUNT_NUMBER = "#account_number";
const ID_PASSWORD = "#account_password";
const ACCOUNT_URL = "./account/overview.html";

main();

function main() {
  let btnLogin, loginFeedback;
  btnLogin = document.querySelector(ID_LOGIN_BUTTON);
  btnLogin.addEventListener("click", validateLoginForm);
}

function validateLoginForm() {
  // Get the input values
  let accountNumber = document.getElementById("account_number").value;
  let accountPassword = document.getElementById("account_password").value;

  // Validate account number
  if (!/^1899\d{8}$/.test(accountNumber)) {
    showFeedback(
      "Invalid account number. Please enter a valid account number."
    );
    return;
  }

  // Validate password
  if (!/^[0-9A-Za-z]{8}$/.test(accountPassword)) {
    showFeedback(
      "Invalid password. Please enter a valid password with at least 8 characters."
    );
    return;
  }
  loginCustomer();
}

function showFeedback(message) {
  // Display the feedback message
  let feedback = document.getElementById("feedback_test");
  feedback.innerHTML = message;
}

async function loginCustomer() {
  let accountNumber,
    password,
    loginFeedback,
    requestBody,
    url,
    data,
    response,
    requestURL;

  loginFeedback = document.querySelector(ID_LOGIN_FEEDBACK);
  loginFeedback.innerHTML = "Please wait.";
  accountNumber = document.querySelector(ID_ACCOUNT_NUMBER).value;
  password = document.querySelector(ID_PASSWORD).value;

  if (!accountNumber || !password) {
    loginFeedback.innerHTML = "Please fill the required fields";
    clearFeedback(loginFeedback);
    return;
  }

  requestBody = new FormData();
  requestBody.append("account_number", accountNumber);
  requestBody.append("password", password);
  requestBody.append("redirect_url", ACCOUNT_URL);

  //url = "../backend/php/customer-login.php";
  url = "../backend/php/customer-login-check.php";
  data = await postData(url, requestBody);

  if (!data.success) {
    loginFeedback.innerHTML = data.errorMessage;
    clearFeedback(loginFeedback);
    return;
  }

  // Redirect to the specified URL after successful login
  window.location.href = ACCOUNT_URL;

  // Optionally, you can also use the following line to open the URL in a new tab:
  // window.open(ACCOUNT_URL, '_blank');

  requestURL = "../backend/php/customer-login.php";
  await saveRequest(requestURL, requestBody);
}
