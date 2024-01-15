import {
  sendData,
  fetchData,
  checkAdminSession,
  strToNum,
  logSend,
  logFetch,
} from "./common.js";

let ADMIN_ID;
const ID_LOGOUT_BUTTON = "#logout";
const ID_ADMIN_NAME = "#display_admin_holder";
const ID_ADMIN_NUMBER = "#display_admin_id";
const ID_BALANCE = "#display_admin_balance";

main();

function main() {
  checkAdminSession(startOperation);
  //startOperation();
}

function startOperation() {
  let adminName, adminId, balance, url;

  adminName = document.querySelector(ID_ADMIN_NAME);
  adminId = document.querySelector(ID_ADMIN_NUMBER);
  balance = document.querySelector(ID_BALANCE);
  adminName.innerHTML = "Loading...";
  adminId.innerHTML = "Loading...";
  balance.innerHTML = "Loading...";
  url = "../../backend/php/admin-session.php";
  fetchData(url, setadminId);
}

function setadminId(data) {
  if (!data.success) {
    console.log(data);
    return;
  }
  ADMIN_NUMBER = data.adminId;
  getAdminInfo();
}

function getAdminInfo() {
  let sessionadmin, url, requestBody;

  url = "../../backend/php/admin-info.php";
  sessionadmin = ADMIN_ID;
  requestBody = new FormData();
  requestBody.append("admin_number", sessionadmin);
  sendData(url, requestBody, showAdminData);
}
function showAdminData(data) {
  console.log(data);
  if (!data.success) return;
  let adminName, adminId, balance;

  adminName = document.querySelector(ID_ADMIN_NAME);
  adminId = document.querySelector(ID_ADMIN_NUMBER);
  balance = document.querySelector(ID_BALANCE);
  adminName.innerHTML = data.data.name;
  adminId.innerHTML = data.data.adminId;
  balance.innerHTML = strToNum(data.data.balance);
}
