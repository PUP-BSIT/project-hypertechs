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

const dbAddress = "https://apexapp.tech/api_apex/register.php";

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
