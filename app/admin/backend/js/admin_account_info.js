import { postData, getData, isLoggedIn, strToNum } from "./common_new.js";

let ADMIN_NUMBER;
const ID_LOGOUT_BUTTON = "#logout";
const ID_ADMIN_NAME = "#admin_name";
const ID_ADMIN_NUMBER = "#admin_number";
const ID_FIRST_NAME = "#admin_first_name";
const HOME_URL = "/index.html";

main();

async function main() {
  let response, loggedIn, adminName, adminNumber, url;

  loggedIn = await isLoggedIn();
  if (!loggedIn) {
    window.location.href = HOME_URL;
    return;
  }
  url = "/app/admin/backend/php/admin-session.php";
  response = await getData(url);
  if (!response.success) {
    return;
  }
  ADMIN_NUMBER = response.adminNumber;
  getAdminInfo();
}

async function getAdminInfo() {
  let sessionAdmin, url, requestBody, response;

  url = "/app/admin/backend/php/admin-info.php";
  sessionAdmin = ADMIN_NUMBER;
  requestBody = new FormData();
  requestBody.append("admin_number", sessionAdmin);
  response = await postData(url, requestBody);
  if (!response.success) return;
  showAdminData(response);
}

function showAdminData(data) {
  let adminName, adminNumber, firstName, name;

  firstName = document.querySelector(ID_FIRST_NAME);
  firstName.innerHTML = data.data.firstName;
  adminName = document.querySelector(ID_ADMIN_NAME);
  adminNumber = document.querySelector(ID_ADMIN_NUMBER);

  if (!adminName || !adminNumber) return;
  adminName.innerHTML = data.data.name.toUpperCase();
  adminNumber.innerHTML = data.data.adminNumber;
}
