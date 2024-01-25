// script to toggle between light and dark themes
document.addEventListener("DOMContentLoaded", function () {
  const root = document.documentElement;
  const currentTheme = localStorage.getItem("theme") || "light";

  root.setAttribute("data-theme", currentTheme);

  function toggleTheme() {
    const newTheme = root.getAttribute("data-theme") === "light" ? "dark" : "light";
    root.setAttribute("data-theme", newTheme);
    localStorage.setItem("theme", newTheme);
  }

  const themeToggle = document.getElementById("theme_mode");
  themeToggle.checked = currentTheme === "dark";

  themeToggle.addEventListener("change", toggleTheme);
});

/* script to switch from deposit to withdraw transaction */
function showDepositTab() {
  document.getElementById("deposit-btn").classList.add("active");
  document.getElementById("withdraw-btn").classList.remove("active");
  document.getElementById("deposit-form").style.display = "block";
  document.getElementById("withdraw-form").style.display = "none";
  document.querySelector(".deposit-desc").style.display = "block";
  document.querySelector(".withdraw-desc").style.display = "none";
  switchForm("deposit-form");
}

function showWithdrawTab() {
  document.getElementById("withdraw-btn").classList.add("active");
  document.getElementById("deposit-btn").classList.remove("active");
  document.getElementById("deposit-form").style.display = "none";
  document.getElementById("withdraw-form").style.display = "block";
  document.querySelector(".deposit-desc").style.display = "none";
  document.querySelector(".withdraw-desc").style.display = "block";
  switchForm("withdraw-form");
}

function setDefaultActiveButton() {
  // Invoke showDepositTab directly to display the form by default
  showDepositTab();
  // Add logic to display the default content for internal transfer
}

// Call the function when the page loads
window.onload = setDefaultActiveButton;

/* smooth transition for transaction options selection */
function switchForm(formId) {
  // Hide all forms
  let forms = document.querySelectorAll(".transaction-form-wrapper");
  forms.forEach(function (form) {
    form.classList.remove("show-form");
  });

  // Show the selected form after a small delay for the fade-out effect
  setTimeout(function () {
    let selectedForm = document.getElementById(formId);
    selectedForm.classList.add("show-form");
  }, 50);
}

document.addEventListener("DOMContentLoaded", function () {
  let transferContainer = document.querySelector(".apex-transaction-container");
  transferContainer.classList.add("fade-in");
});

/* Modal settings */
function openConfirmationPopup() {
  // Display the modal
  document.getElementById('confirmationModal').style.display = 'block';
}

function closeConfirmationPopup() {
  // Close the modal
  document.getElementById('confirmationModal').style.display = 'none';
}

function closeConfirmationPopup() {
  var confirmationModal = document.getElementById("confirmationModal");
  var modalContent = document.querySelector(".modal-content");

  // Add the zoom-out class
  modalContent.classList.add("zoom-out");

  // Wait for the animation to finish before hiding the modal
  setTimeout(function () {
    confirmationModal.style.display = "none";
    // Remove the zoom-out class to reset for the next time
    modalContent.classList.remove("zoom-out");
  }, 500); // 500ms should match the animation duration
}

/* Close Confirmation Modal */

function closeConfirmationDetailsPopup() {
  document.getElementById('confirm_details_modal').style.display = 'none';
}

function closeConfirmationDetailsPopup() {
  let confirmationDetailsModal = document.getElementById("confirm_details_modal");
  let confirmDetailsModalContent = document.querySelector(".confirm-modal-content");

  confirmDetailsModalContent.classList.add("zoom-out-confirm");

  setTimeout(function () {
    confirmationDetailsModal.style.display = "none";
    confirmDetailsModalContent.classList.remove("zoom-out-confirm");
  }, 500);
}

/* Close Success Modal */

function closeSuccessPopup() {
  document.getElementById('transaction_success_modal').style.display = 'none';
}

function closeSuccessPopup() {
  let transactionSuccessModal = document.getElementById("transaction_success_modal");
  let transactionSuccessModalContent = document.querySelector(".success-modal-content");

  transactionSuccessModalContent.classList.add("zoom-out-confirm");

  setTimeout(function () {
    transactionSuccessModal.style.display = "none";
    transactionSuccessModalContent.classList.remove("zoom-out-confirm");
  }, 500);
}