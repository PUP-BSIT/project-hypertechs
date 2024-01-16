import { postData, getData, isLoggedIn } from "./common_new.js";

let ACCOUNT_NUMBER;
const URL_HOME = "/index.html";
const ID_CLIENT = "#recipient-account-number";
const ID_DEPOSIT_AMOUNT = "#transfe-amount";
const ID_DEPOSIT_BUTTON = "#submit";

main();

async function main() {
  let url, loggedIn, btnDeposit, response;

  loggedIn = await isLoggedIn();
  if (!loggedIn) {
    window.location.href = URL_HOME;
  }
  url = "../../backend/php/admin-session.php";
  response = await getData(url);
  ACCOUNT_NUMBER = response.accountNumber;
  btnDeposit = document.querySelector(ID_DEPOSIT_BUTTON);
  btnDeposit.addEventListener("click", requestDeposit);
}

async function requestDeposit() {
  let amount, recipient, source;

  amount = document.querySelector(ID_DEPOSIT_AMOUNT).value;
  recipient = document.querySelector(ID_CLIENT).value;
  source = ACCOUNT_NUMBER;
  console.log(source, recipient);
  if (recipient === source) {
    alert("Invalid account number.");
    return;
  }
  if (!recipient || !amount) {
    alert("Please fill out all the required fields.");
    return;
  }
  if (!/^\d{12}$/.test(recipient)) {
    alert("Account number should contain exactly 12 digits.");
    return;
  }
  if (!/^\d{1,6}$/.test(amount)) {
    alert("Amount should be limited to six digits only.");
    return;
  }
}
