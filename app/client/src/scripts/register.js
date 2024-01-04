// scripts for form validation

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
function validateForm() {
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

  // Validate phone number
  if (!isValidPhoneNumber(phoneNumberInput.value)) {
    showAlert("Please enter a valid phone number with 11 digits.");
    return false; // Prevent form submission
  }

  // Validate password
  if (!isValidPassword(passwordInput.value)) {
    showAlert(
      "Password must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters long."
    );
    return false; // Prevent form submission
  }

  // Confirm password match
  if (passwordInput.value !== confirmPasswordInput.value) {
    showAlert("Passwords do not match.");
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

// Check if the phone number contains exactly 11 digits and consists only of numeric characters
function isValidPhoneNumber(phoneNumber) {
  return /^\d{11}$/.test(phoneNumber);
}

// Checks if the password meets the following
function isValidPassword(password) {
  // Check for at least one number
  const hasNumber = /\d/.test(password);

  // Check for at least one uppercase letter
  const hasUppercase = /[A-Z]/.test(password);

  // Check for at least one lowercase letter
  const hasLowercase = /[a-z]/.test(password);

  // Check for at least 8 characters
  const hasMinLength = password.length >= 8;

  // Return true if all conditions are met
  return hasNumber && hasUppercase && hasLowercase && hasMinLength;
}

// Connect to register.php
document.addEventListener("DOMContentLoaded", function () {
  // Listen for the form submission
  document
    .getElementById("register_form")
    .addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent the default form submission

      // Get form data
      let formData = new FormData(this);

      // Make a POST request to the PHP script
      console.log("Before fetch");
      fetch("/app/client/src/php/register.php", {
        method: "POST",
        body: formData,
      })
        .then(() => {
          console.log("After fetch");
          // Redirect the user using JavaScript
          window.location.href = "/app/client/pages/otp.php";
        })

        .catch((error) => {
          console.error("Error:", error);
        });
    });
});

const dbAddress = "https://apexapp.tech/api/register.php";

function registerUser() {
  const surname = document.querySelector("#surname").value;
  const middleName = document.querySelector("#middle_name").value;
  const firstName = document.querySelector("#first_name").value;
  const suffix = document.querySelector("#suffix").value;
  const birthDate = document.querySelector("#dob").value;
  const residentialAddress = document.querySelector(
    "#residential_address"
  ).value;
  const email = document.querySelector("#email").value;
  const phoneNumber = document.querySelector("#phone_number").value;
  const password = document.querySelector("#password").value;

  fetch(dbAddress, {
    method: "POST",
    headers: {
      "Content-type": "application/x-www-form-urlencoded",
    },
    body: `surname=${surname}&middle_name=${middleName}
    &first_name=${firstName}&suffix=${suffix}&dob=${birthDate}
    &residential_address=${residentialAddress}&email=${email}
    &phone_number=${phoneNumber}&password=${password}`,
  })
    .then((response) => response.text())
    .then((responseText) => {
      alert(responseText);
    });

  const allInputs = document.querySelectorAll("input");
  allInputs.forEach((input) => {
    input.value = ""; // Set value to empty string
  });
}
