/* script to switch from internal to external transfer form */
function showInternalTransferForm() {
    document.getElementById("profile_info_btn").classList.add("active");
    document.getElementById("account_info_btn").classList.remove("active");
    document.getElementById("profile_info_form").style.display = "block";
    document.getElementById("account_info_form").style.display = "none";
    document.querySelector(".profile-info-desc").style.display = "block";
    document.querySelector(".account-info-desc").style.display = "none";
    switchForm("profile_info_form");
  }
  
  function showExternalTransferForm() {
    document.getElementById("account_info_btn").classList.add("active");
    document.getElementById("profile_info_btn").classList.remove("active");
    document.getElementById("profile_info_form").style.display = "none";
    document.getElementById("account_info_form").style.display = "block";
    document.querySelector(".profile-info-desc").style.display = "none";
    document.querySelector(".account-info-desc").style.display = "block";
    switchForm("account_info_form");
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
    let forms = document.querySelectorAll(".settings-form-wrapper");
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
    let transferContainer = document.querySelector(".apex-settings-container");
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

function confirmCloseAccount() {
  // Perform the action to close the account here
  alert("Account closed!"); // Replace this with your actual account closure logic
  closeConfirmationPopup();
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