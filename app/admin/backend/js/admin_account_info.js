import { postData, getData, isLoggedIn, strToNum } from "./common_new.js";

let ADMIN_ID;
const ID_LOGOUT_BUTTON = "#logout";
//const ID_ADMIN_NAME = "#admin_name";
const ID_ADMIN_NUMBER = "#display_admin_id";
const ID_FIRST_NAME = "#display_admin_name";
const HOME_URL = "/index.html";
const ID_MINI_NAME = "#display_mini_admin_text";

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
  let adminName, adminId, balance, firstName, name, miniName;

  firstName = document.querySelector(ID_FIRST_NAME);
  miniName = document.querySelector(ID_MINI_NAME);
  //adminName = document.querySelector(ID_ADMIN_NAME);
  adminId = document.querySelector(ID_ADMIN_NUMBER);
  //balance = document.querySelector(ID_BALANCE);
  // if (firstName) {
  firstName.innerHTML = data.data.firstName;
  // }
  // if (miniName) {
  //   miniName.innerHTML = data.data.name;
  // }
  if (adminId) {
    //adminName.innerHTML = data.data.name;
    adminId.innerHTML = data.data.adminId;
    //balance.innerHTML = strToNum(data.data.balance);
  }
}
