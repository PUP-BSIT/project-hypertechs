/* script to switch from internal to external transfer form */
function showInternalTransferForm() {
  document.getElementById("internal-transfer-btn").classList.add("active");
  document.getElementById("external-transfer-btn").classList.remove("active");
  document.getElementById("internal-transfer-form").style.display = "block";
  document.getElementById("external-transfer-form").style.display = "none";
  document.querySelector(".internal-transfer-desc").style.display = "block";
  document.querySelector(".external-transfer-desc").style.display = "none";
  switchForm("internal-transfer-form");
}

function showExternalTransferForm() {
  document.getElementById("external-transfer-btn").classList.add("active");
  document.getElementById("internal-transfer-btn").classList.remove("active");
  document.getElementById("internal-transfer-form").style.display = "none";
  document.getElementById("external-transfer-form").style.display = "block";
  document.querySelector(".internal-transfer-desc").style.display = "none";
  document.querySelector(".external-transfer-desc").style.display = "block";
  switchForm("external-transfer-form");
}

function setDefaultActiveButton() {
  // Invoke showInternalTransferForm directly to display the form by default
  showInternalTransferForm();
  // Add logic to display the default content for internal transfer
}

// Call the function when the page loads
window.onload = setDefaultActiveButton;

/* smooth transition for transfer options selection */
function switchForm(formId) {
  // Hide all forms
  let forms = document.querySelectorAll(".transfer-form-wrapper");
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
  let transferContainer = document.querySelector(".apex-transfer-container");
  transferContainer.classList.add("fade-in");
});

/* Logout Modal settings */
function openConfirmationPopup() {
  // Display the modal
  document.getElementById('confirmationModal').style.display = 'block';
}

function closeConfirmationPopup() {
  // Close the modal
  document.getElementById('confirmationModal').style.display = 'none';
}

function closeConfirmationPopup() {
  let confirmationModal = document.getElementById("confirmationModal");
  let modalContent = document.querySelector(".modal-content");

  // Add the zoom-out class
  modalContent.classList.add("zoom-out");

  // Wait for the animation to finish before hiding the modal
  setTimeout(function () {
    confirmationModal.style.display = "none";
    // Remove the zoom-out class to reset for the next time
    modalContent.classList.remove("zoom-out");
  }, 500); // 500ms should match the animation duration
}

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
