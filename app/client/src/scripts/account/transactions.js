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
  