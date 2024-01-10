import {
  sendData,
  fetchData,
  checkAdminSession,
  strToNum,
  logSend,
  logFetch,
} from "./common.js";

let ADMIN_NUMBER;
const ID_LOGOUT_BUTTON = "#logout";
const ID_ADMIN_NAME = "#admin_name";
const ID_ADMIN_NUMBER = "#admin_number";

main();

function main() {
  checkAdminSession(startOperation);
}

function startOperation() {
  let adminName, adminNumber, url;

  adminName = document.querySelector(ID_ADMIN_NAME);
  adminNumber = document.querySelector(ID_ADMIN_NUMBER);
  adminName.innerHTML = "Loading...";
  adminNumber.innerHTML = "Loading...";
  url = "../../backend/php/admin-session.php";
  fetchData(url, setAdminNumber);
}

function setAdminNumber(data) {
  if (!data.success) {
    console.log(data);
    return;
  }
  ADMIN_NUMBER = data.adminNumber;
  getAdminInfo();
}

function getAdminInfo() {
  let sessionAdmin, url, requestBody;

  url = "../../backend/php/admin-info.php";
  sessionAdmin = ADMIN_NUMBER;
  requestBody = new FormData();
  requestBody.append("admin_number", sessionAdmin);
  sendData(url, requestBody, showAdminData);
}
function showAdminData(data) {
  if (!data.success) return;
  console.log(data);
  let adminName, adminNumber;

  adminName = document.querySelector(ID_ADMIN_NAME);
  adminNumber = document.querySelector(ID_ADMIN_NUMBER);
  adminName.innerHTML = data.data.name.toUpperCase();
  adminNumber.innerHTML = data.data.adminNumber;
}
