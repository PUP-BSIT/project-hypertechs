import { 
        postData, getData, saveRequest, destroyOTPSession 
} from "./common_new.js";

const ID_LASTNAME = "#surname";
const ID_MIDDLENAME = "#middle_name";
const ID_FIRSTNAME = "#first_name";
const ID_SUFFIX = "#suffix";
const ID_PHONE = "#phone_number";
const ID_PASSWORD = "#password";
const ID_PASSWORD_CONFIRM = "#confirm_password";
const ID_BTN_REGISTER = "#btn_register";
const ID_ADDRESS = "#residential_address";
const ID_EMAIL = "#email";
const ID_BIRTH = "#dob";

main();

function main() {
        let btnRegister;

        btnRegister = document.querySelector(ID_BTN_REGISTER);
        btnRegister.addEventListener("click", validateForm);
}

async function validateForm() {
        let url, requestBody, response;

        if (!isValidated()) {
                return;
        }
        await destroyOTPSession();
        registerUser();
}

async function registerUser() {
        let url, requestBody, response;

        requestBody = getFormData();
        url = "../backend/php/registration-check.php";
        response = await postData(url, requestBody);
        if (!response.success) {
                alert(response.errorMessage);
                return;
        }
        url = "../backend/php/registration.php";
        await saveRequest(url, requestBody);
}

function getFormData() {
        let phone, password, firstName, surname, formData, address, email,
                suffix, middleName, birth;

        phone = document.querySelector(ID_PHONE).value;
        password = document.querySelector(ID_PASSWORD).value;
        firstName = document.querySelector(ID_FIRSTNAME).value;
        surname = document.querySelector(ID_LASTNAME).value;
        address = document.querySelector(ID_ADDRESS).value;
        email = document.querySelector(ID_EMAIL).value;
        suffix = document.querySelector(ID_SUFFIX).value;
        middleName = document.querySelector(ID_MIDDLENAME).value;
        birth = document.querySelector(ID_BIRTH).value;
        formData = new FormData();
        formData.append("phone_number", phone);
        formData.append("password", password);
        formData.append("first_name", firstName);
        formData.append("surname", surname);
        formData.append("address", address);
        formData.append("email", email);
        formData.append("suffix", suffix);
        formData.append("middle_name", middleName);
        formData.append("birth_date", birth);
        return formData;
}

function isPasswordMatched() {
        let password, passwordConfirm;

        password = document.querySelector(ID_PASSWORD).value;
        passwordConfirm = document.querySelector(ID_PASSWORD_CONFIRM).value;
        if (password !== passwordConfirm) return false;
        return true;
}

/* form validation */

        // Prevents the user from typing any non-numeric character
        // or exceeding 11 digits in the field
document.addEventListener("DOMContentLoaded", function () {
        // Get reference to the phone number input
        let phoneNumberInput = document.getElementById("phone_number");

        // Attach an input event listener to actively validate the phone number input
        phoneNumberInput.addEventListener("input", function () {
                // Remove non-numeric characters
                let cleanedInput = this.value.replace(/\D/g, "");

                // Limit the phone number length to 11 digits
                this.value = cleanedInput.slice(0, 11);
        });
});

// Validate the form on submission
function isValidated() {
        // Get references to the input fields
        let surnameInput = document.getElementById("surname");
        let firstNameInput = document.getElementById("first_name");
        let dobInput = document.getElementById("dob");
        let residentialAddressInput = document.getElementById("residential_address");
        let emailInput = document.getElementById("email");
        let phoneNumberInput = document.getElementById("phone_number");
        let passwordInput = document.getElementById("password");
        let confirmPasswordInput = document.getElementById("confirm_password");

        // Check if any of the required fields contain only spaces
        if (
                isEmpty(surnameInput) ||
                isEmpty(firstNameInput) ||
                isEmpty(dobInput) ||
                isEmpty(residentialAddressInput) ||
                isEmpty(emailInput) ||
                isEmpty(passwordInput) ||
                isEmpty(confirmPasswordInput)
        ) {
                showAlert("The fields must not contain spaces only.");
                return false; // Prevent form submission
        }

        // Validate email address
        if (!isValidEmail(emailInput.value)) {
                showAlert("Please enter a valid email address.");
                return false; // Prevent form submission
        }

        // Validate phone number
        if (!isValidPhoneNumber(phoneNumberInput.value)) {
                showAlert("Please enter a valid phone number with 11 digits.");
                return false; // Prevent form submission
        }

        // Validate password
        if (!isValidPassword(passwordInput.value)) {
                showAlert("Password must contain at least one number, one " + 
                        "uppercase letter, one lowercase letter, and be at " + 
                        "least 8 characters long."
                );
                return false; // Prevent form submission
        }

        // Confirm password match
        if (passwordInput.value !== confirmPasswordInput.value) {
                showAlert("Warning: Passwords do not match.");
                return false; // Prevent form submission
        }

        return true; // Allow form submission
}

// Check if an input field is empty or contains only spaces
function isEmpty(input) {
        if (isOnlySpaces(input.value)) {
                showAlert("Please fill out all required fields.");
                return true;
        }
        return false;
}

// Show an alert with a specific message
function showAlert(message) {
        alert(message);
}

// Check if the string contains only spaces
function isOnlySpaces(value) {
        return /^\s*$/.test(value);
}

// Check if the phone number contains exactly 11 digits
// and consists only of numeric characters
function isValidPhoneNumber(phoneNumber) {
        return /^\d{11}$/.test(phoneNumber);
}

// Checks if the password meets the following
function isValidPassword(password) {
        // Check for at least one number
        if (!/\d/.test(password)) return false;;

        // Check for at least one uppercase letter
        if (!/[A-Z]/.test(password)) return false;

        // Check for at least one lowercase letter
        if (!/[a-z]/.test(password)) return false;

        // Check for at least 8 characters
        if (!password.length >= 8) return false;

        // Return true if all conditions are met
        return true;
}

function isValidEmail(email) {
        // Regular expression for validating an Email
        const emailRegex = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]{2,}$/;
        return emailRegex.test(email);
    }
