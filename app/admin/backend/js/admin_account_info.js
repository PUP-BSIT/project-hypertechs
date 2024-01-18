import { postData, getData, isLoggedIn, strToNum } from "./common_new.js";

let ADMIN_ID;
const ID_LOGOUT_BUTTON = "#logout";
//const ID_ADMIN_NAME = "#admin_name";
const ID_ADMIN_NUMBER = "#display_admin_id";
const ID_FIRST_NAME = "#admin_first_name";
const HOME_URL = "/index.html";
const ID_ADMIN_NAME = "#display_admin_name";
const ID_ADMIN_CONTACT = "#display_admin_contact";
const ID_TOTAL_USER = "#display_total_users";
const ID_TOTAL_ADMIN = "#display_total_admin";
const ID_TOTAL_DEPOSIT = "display_total_deposit";

main();

async function main() {
  let response, loggedIn, adminName, adminId, balance, url;

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
  ADMIN_ID = response.adminId;
  getAdminInfo();
}

async function getAdminInfo() {
  let sessionAdmin, url, requestBody, response;

  url = "/app/admin/backend/php/admin-info.php";
  sessionAdmin = ADMIN_ID;
  requestBody = new FormData();
  requestBody.append("admin_id", sessionAdmin);
  response = await postData(url, requestBody);
  if (!response.success) return;
  showAdminData(response);
}

function showAdminData(data) {
  let adminName,
    adminId,
    phone,
    firstName,
    name,
    totalUser,
    totalAdmin,
    totalDeposit;

  firstName = document.querySelector(ID_FIRST_NAME);
  adminName = document.querySelector(ID_ADMIN_NAME);
  adminId = document.querySelector(ID_ADMIN_NUMBER);
  phone = document.querySelector(ID_ADMIN_CONTACT);
  totalUser = document.querySelector(ID_TOTAL_USER);
  totalAdmin = document.querySelector(ID_TOTAL_ADMIN);
  totalDeposit = document.querySelector(ID_TOTAL_DEPOSIT);

  if (firstName) {
    firstName.innerHTML = data.data.firstName + "!";
  }
  if (adminName) {
    adminName.innerHTML = data.data.name;
  }
  if (adminId) {
    adminId.innerHTML = data.data.adminId;
  }
  if (phone) {
    phone.innerHTML = data.data.phone;
  }
  if (totalUser) {
    totalUser.innerHTML = data.data.totalUser;
  }
  if (totalAdmin) {
    totalAdmin.innerHTML = data.data.totalAdmin;
  }
  if (totalDeposit) {
    totalDeposit.innerHTML = data.data.totalDeposit;
  }
}
