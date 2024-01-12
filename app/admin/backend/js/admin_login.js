import { postData, saveRequest, destroyOTPSession } from "./common_new.js";

const ID_LOGIN_BUTTON = "#login_button";
const ID_ADMIN_NUMBER = "#admin_number";
const ID_PASSWORD = "#admin_password";
const ADMIN_URL = "./admin_account/overview.html";

main();

function main() {
  let btnLogin, loginFeedback;
  btnLogin = document.querySelector(ID_LOGIN_BUTTON);
  btnLogin.addEventListener("click", validateLoginForm);
}

async function validateLoginForm() {
  let adminNumber, adminPassword;

  adminNumber = document.getElementById("admin_number").value;
  adminPassword = document.getElementById("admin_password").value;

  if (!adminNumber || !adminPassword) {
    showAlert("Please fill all the required fields.");
    return;
  }

  if (!/^1899\d{8}$/.test(adminNumber)) {
    showAlert(
      "Invalid admin number. Please enter your 12-digit valid" +
        " Apex admin number."
    );
    return;
  }

  if (!isPasswordValid(adminPassword)) {
    showAlert("Invalid password. Please enter a valid password.");
    return;
  }

  await destroyOTPSession();
  loginAdmin();
}

function showAlert(message) {
  window.alert(message);
}

async function loginAdmin() {
  let adminNumber, password, requestBody, url, data, response, requestURL;

  adminNumber = document.querySelector(ID_ADMIN_NUMBER).value;
  password = document.querySelector(ID_PASSWORD).value;
  requestBody = new FormData();
  requestBody.append("admin_number", adminNumber);
  requestBody.append("password", password);
  requestBody.append("redirect_url", ADMIN_URL);
  console.log(adminNumber);

  url = "../backend/php/admin-login-check.php";
  data = await postData(url, requestBody);
  if (!data.success) {
    showAlert(data.errorMessage);
    return;
  }
  requestURL = "../backend/php/admin-login.php";
  await saveRequest(requestURL, requestBody);
}

function isPasswordValid(password) {
  // Check for at least one number
  if (!/\d/.test(password)) return false;

  // Check for at least one uppercase letter
  if (!/[A-Z]/.test(password)) return false;

  // Check for at least one lowercase letter
  if (!/[a-z]/.test(password)) return false;

  // Check for at least 8 characters
  if (!password.length >= 8) return false;

  // Return true if all conditions are met
  return true;
}
