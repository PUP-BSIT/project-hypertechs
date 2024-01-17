import { postData, getData, isLoggedIn } from "./common_new.js";

const ID_BTN_LOGIN = "#button_login";
const URL_ACCOUNT = "./app/admin/pages/admin_account/admin_overview.html";
const URL_LOGIN = "./app/admin/pages/login.html";

main();

function main() {
  let btnLogin;

  btnLogin = document.querySelector(ID_BTN_LOGIN);
  btnLogin.addEventListener("click", checkSession);
}

async function checkSession() {
  let loggedIn;

  loggedIn = await isLoggedIn();
  console.log(loggedIn);
  if (loggedIn) {
    window.location.href = URL_ACCOUNT;
    return;
  }
  window.location.href = URL_LOGIN;
}
