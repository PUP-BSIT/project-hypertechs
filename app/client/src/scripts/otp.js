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
  // In verifyOTP() function
  const enteredOTP = document.getElementById("otpVerificationForm").elements;
  const userOTP =
    enteredOTP.otp1.value +
    enteredOTP.otp2.value +
    enteredOTP.otp3.value +
    enteredOTP.otp4.value +
    enteredOTP.otp5.value +
    enteredOTP.otp6.value;

  console.log("User OTP: " + userOTP);
  console.log("User Data:", userData);
  console.log("User OTP in Session:", userData["otp"]); // Add this line

  // Make an AJAX request to verify_otp.php
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "/app/client/src/php/verify_otp.php", true);
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

  // Include user data in the request
  xhr.send("otp=" + userOTP);
}
