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

  // Validate the form on submission
  function validateForm(event) {
    // Get references to the input fields
    let surnameInput = document.getElementById("surname");
    let firstNameInput = document.getElementById("first_name");
    let dobInput = document.getElementById("dob");
    let residentialAddressInput = document.getElementById(
      "residential_address"
    );
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

      // Prevent default form submission and event propagation
      event.preventDefault();
      event.stopPropagation();
      return false;
    }

    // Validate phone number
    if (!isValidPhoneNumber(phoneNumberInput.value)) {
      showAlert("Please enter a valid phone number with 11 digits.");

      // Prevent default form submission and event propagation
      event.preventDefault();
      event.stopPropagation();
      return false;
    }

    // Validate password
    if (!isValidPassword(passwordInput.value)) {
      showAlert(
        "Password must contain at least one number, one uppercase letter, one lowercase letter, and be at least 8 characters long."
      );

      // Prevent default form submission and event propagation
      event.preventDefault();
      event.stopPropagation();
      return false;
    }

    // Confirm password match
    if (passwordInput.value !== confirmPasswordInput.value) {
      showAlert("Passwords do not match.");

      // Prevent default form submission and event propagation
      event.preventDefault();
      event.stopPropagation();
      return false;
    }

    // If all validations pass, proceed with form submission
    submitForm();

    // Prevent default form submission and event propagation
    event.preventDefault();
    event.stopPropagation();
    return false;
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
});