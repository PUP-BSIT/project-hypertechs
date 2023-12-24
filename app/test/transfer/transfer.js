// script to toggle between light and dark themes
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

/* script to switch from internal to external transfer form */
function showInternalTransferForm() {
  document.getElementById("internal-transfer-btn").classList.add("active");
  document.getElementById("external-transfer-btn").classList.remove("active");
  document.getElementById("internal-transfer-form").style.display = "block";
  document.getElementById("external-transfer-form").style.display = "none";
  document.querySelector(".internal-transfer-desc").style.display = "block";
  document.querySelector(".external-transfer-desc").style.display = "none";
}

function showExternalTransferForm() {
  document.getElementById("external-transfer-btn").classList.add("active");
  document.getElementById("internal-transfer-btn").classList.remove("active");
  document.getElementById("internal-transfer-form").style.display = "none";
  document.getElementById("external-transfer-form").style.display = "block";
  document.querySelector(".internal-transfer-desc").style.display = "none";
  document.querySelector(".external-transfer-desc").style.display = "block";
}

function setDefaultActiveButton() {
  // Invoke showInternalTransferForm directly to display the form by default
  showInternalTransferForm();
  // Add logic to display the default content for internal transfer
}

// Call the function when the page loads
window.onload = setDefaultActiveButton;
