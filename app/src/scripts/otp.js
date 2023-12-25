// JavaScript code to toggle between light and dark themes
document.addEventListener("DOMContentLoaded", function () {
  const root = document.documentElement;
  const currentTheme = localStorage.getItem("theme") || "light";

  root.setAttribute("data-theme", currentTheme);

  function toggleTheme() {
    const newTheme =
      root.getAttribute("data-theme") === "light" ? "dark" : "light";
    root.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);
  }

  const themeToggle = document.getElementById("theme_mode");
  themeToggle.checked = currentTheme === "dark";

  themeToggle.addEventListener("change", toggleTheme);
});

/* prevents color flickering when loading */
const theme = localStorage.getItem("theme") || "light";
document.documentElement.dataset.theme = theme;


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
