import {
        postData, getData, saveRequest, clearFeedback
} from "./common_new.js";

const ID_LASTNAME = "#surname";
const ID_MIDDLENAME = "#middle_name";
const ID_FIRSTNAME = "#first_name";
const ID_SUFFIX = "#suffix";
const ID_PHONE = "#phone_number";
const ID_PASSWORD = "#password";
const ID_PASSWORD_CONFIRM = "#confirm_password";
const ID_BTN_REGISTER = "#btn_register";
const ID_FEEDBACK = "#feedback_test";

main();

function main() {
        let btnRegister;

        btnRegister = document.querySelector(ID_BTN_REGISTER);
        btnRegister.addEventListener("click", validateForm);
}

async function validateForm() {
        let url, requestBody, response, feedback;
        
        feedback = document.querySelector(ID_FEEDBACK);
        feedback.innerHTML = "Please wait.";
        requestBody = await getFormData();
        url = "../backend/php/registration-check.php";
        response = await postData(url, requestBody);
        if(!response.success) {
                feedback.innerHTML = response.errorMessage;
                clearFeedback(feedback);
                return;
        }
        if (!isPasswordMatched()) {
        console.log("hello");
                feedback.innerHTML = "Passwords do not match.";
                return;
        }
        registerUser();
}

async function registerUser() {
        let url, requestBody, feedback;

        feedback = document.querySelector(ID_FEEDBACK);
        clearFeedback(feedback);
        url = "../backend/php/registration.php";
        requestBody = await getFormData();
        await saveRequest(url, requestBody);
        feedback.innerHTML = "Signing up...";
}

function getFormData() {
        let phone, password, firstName, lastName, formData;

        phone = document.querySelector(ID_PHONE).value;
        password = document.querySelector(ID_PASSWORD).value;
        firstName = document.querySelector(ID_FIRSTNAME).value;
        lastName = document.querySelector(ID_LASTNAME).value;
        formData = new FormData();
        formData.append('phone_number', phone);
        formData.append('password', password);
        formData.append('first_name', firstName);
        formData.append('last_name', lastName);
        return formData;
}

function isPasswordMatched() {
        let password, passwordConfirm;

        password = document.querySelector(ID_PASSWORD).value;
        passwordConfirm = document.querySelector(ID_PASSWORD_CONFIRM).value;
        if (password !== passwordConfirm) return false;
        return true;
}
