import {
        postData, getData
} from "./common_new.js";

const ID_PASSWORD = "#new_password";
const ID_PASSWORD_CONFIRM = "#confirm_password";
const ID_SUBMIT = "#reset_button";

main();

function main() {
        let btnSubmit;
        
        btnSubmit = document.querySelector(ID_SUBMIT);
        btnSubmit.addEventListener("click", changePassword);
}

async function changePassword() {
        let url, requestBody, password, passwordConfirm, response;

        password = document.querySelector(ID_PASSWORD).value; 
        passwordConfirm = document.querySelector(ID_PASSWORD_CONFIRM).value; 
        if (password !== passwordConfirm) {
                alert("Passwords does not match");
                return;
        }
        requestBody = new FormData();
        requestBody.append('password', password);
        url = "/app/client/backend/php/forgot-pass.php";
        response = await postData(url, requestBody);
        if (response.expired) {
                alert(response.errorMessage);
                window.location.href = "/index.html";
                return;
        }
        if (!response.success) {
                alert(response.errorMessage);
                return;
        }
        window.location.href = "/app/client/pages/success_pass.html";        
}