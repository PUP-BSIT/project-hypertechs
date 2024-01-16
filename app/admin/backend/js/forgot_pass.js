import { postData, getData, saveRequest } from "./common_new.js";

const ID_PHONE_NUMBER = "#admin_phone";
const ID_SUBMIT = "#forgot_button";

main();

function main() {
  let btnSubmit;

  btnSubmit = document.querySelector(ID_SUBMIT);
  btnSubmit.addEventListener("click", requestChangePass);
}

async function requestChangePass() {
  let phoneNumber, requestBody, url, response;

  phoneNumber = document.querySelector(ID_PHONE_NUMBER).value;
  requestBody = new FormData();
  requestBody.append("phone_number", phoneNumber);
  url = "/app/admin/backend/php/forgot-pass-check.php";
  response = await postData(url, requestBody);
  if (!response.success) {
    alert("Account does not exist");
    return;
  }
  url = "/app/admin/backend/php/forgot-pass.php";
  await saveRequest(url, requestBody);
}
