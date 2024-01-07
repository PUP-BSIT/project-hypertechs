/* script for otp form validation */
document.addEventListener("DOMContentLoaded", function () {
  const otpInputs = document.querySelectorAll(".otp-input");

  otpInputs.forEach(function (input) {
    input.addEventListener("input", function (e) {
      const onlyNumbers = /^\d+$/;

      if (!onlyNumbers.test(e.data)) {
        // Remove non-numeric characters
        input.value = input.value.replace(/\D/g, "");
      }

      moveToNext(input);
    });
  });
});

/* script to automatically proceed to next otp field */
function moveToNext(currentInput, nextInputId) {
  const maxLength = parseInt(currentInput.maxLength, 10);
  const currentLength = currentInput.value.length;
  const inputValue = currentInput.value.trim();

  // Validate if the input contains only numbers
  const containsOnlyNumbers = /^\d+$/.test(inputValue);

  if (currentLength === maxLength && inputValue !== "" && containsOnlyNumbers) {
    const nextInput = document.getElementById(nextInputId);

    if (nextInput) {
      nextInput.focus();
    }
  }
}

// verify otp
function verifyOTP() {
  // Retrieve the entered OTP
  const enteredOTP = document.getElementById("otpVerificationForm").elements;
  const userOTP =
    enteredOTP.otp1.value +
    enteredOTP.otp2.value +
    enteredOTP.otp3.value +
    enteredOTP.otp4.value +
    enteredOTP.otp5.value +
    enteredOTP.otp6.value;

  // Create FormData object to send data via AJAX
  const formData = new FormData();
  formData.append("otp", userOTP);

  // Make an AJAX request to verify_otp.php
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/app/client/src/php/verify_otp.php", true);

  // Set up the callback function to handle the response
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        console.log(xhr.responseText);
        // Handle the response here (e.g., show a message to the user)
        alert("Verification successful! Data inserted successfully.");
      } else {
        console.error("Error: " + xhr.status);
        // Handle the error response here (e.g., show an error message to the user)
        alert("Verification failed. Please try again.");
      }
    }
  };
  // Send the FormData object with the OTP
  xhr.send(formData);
}
