// display time in admin overview

function updateDateTime() {
  let currentDate = new Date();

  let dateOptions = { weekday: "long", month: "long", day: "numeric" };
  let timeOptions = {
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    hour12: false,
  };

  let date = currentDate.toLocaleDateString("en-PH", dateOptions);
  let time = currentDate.toLocaleTimeString("en-PH", timeOptions);

  // Update the HTML elements
  document.getElementById("display_date").innerText = date;
  document.getElementById("display_time").innerText = time;
}


setInterval(updateDateTime, 1000);

// Initial update when the page loads
updateDateTime();

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
