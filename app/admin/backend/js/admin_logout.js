import { fetchData, checkAdminSession } from "./common.js";

const ID_LOGOUT_BUTTON = "#logout";

main();

function main() {
  let btnLogOut;

  btnLogOut = document.querySelector(ID_LOGOUT_BUTTON);
  btnLogOut.addEventListener("click", logOut);
}

function logOut() {
  let url;

  url = "../../backend/php/admin-logout.php";
  fetchData(url, processLogOut);
}

function processLogOut(data) {
  checkAdminSession();
}
