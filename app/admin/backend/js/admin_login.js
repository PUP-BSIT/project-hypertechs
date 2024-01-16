import { postData, saveRequest, destroyOTPSession } from "./common_new.js";

const ID_LOGIN_BUTTON = "#login_button";
const ID_EMAIL = "#admin_email";
const ID_PASSWORD = "#admin_password";
const ADMIN_URL = "/app/admin/pages/admin_account/overview.html";

main();

function main() {
  let btnLogin, loginFeedback;
  btnLogin = document.querySelector(ID_LOGIN_BUTTON);
  btnLogin.addEventListener("click", validateLoginForm);
}

async function validateLoginForm() {
  let adminEmail, adminPassword;

  adminEmail = document.querySelector(ID_EMAIL).value;
  adminPassword = document.querySelector(ID_PASSWORD).value;

  if (!adminEmail || !adminPassword) {
    showAlert("Please fill all the required fields.");
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
  let adminEmail, password, requestBody, url, data, requestURL;

  adminEmail = document.querySelector(ID_EMAIL).value;
  password = document.querySelector(ID_PASSWORD).value;
  requestBody = new FormData();
  requestBody.append("email", adminEmail);
  requestBody.append("password", password);
  requestBody.append("redirect_url", ADMIN_URL);

  // Use try-catch to handle potential errors during the async operation
  try {
    url = "../backend/php/admin-login-check.php";
    data = await postData(url, requestBody);

    if (!data.success) {
      showAlert(data.errorMessage);
      return;
    }

    // If login is successful, save the request and perform the redirect
    requestURL = "../backend/php/admin-login.php";
    await saveRequest(requestURL, requestBody);
    window.location.href = ADMIN_URL;

  } catch (error) {
    console.error("Error during login:", error);
    showAlert("An error occurred during the login process.");
  }
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
