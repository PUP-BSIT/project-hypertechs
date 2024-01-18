// Function to update the last updated information
function updateLastUpdatedInfo() {
  var lastUpdatedElement = document.getElementById("last_updated_info");
  var now = new Date();
  lastUpdatedElement.textContent =
    "Updated " + calculateTimeSinceLastRefresh(now);
}

// Function to calculate time since the last refresh
function calculateTimeSinceLastRefresh(currentTime) {
  var lastRefreshTime = localStorage.getItem("lastRefreshTime");
  if (lastRefreshTime) {
    lastRefreshTime = new Date(lastRefreshTime);
    var timeDifference = Math.floor((currentTime - lastRefreshTime) / 1000); // in seconds

    if (timeDifference < 60) {
      return timeDifference + " seconds ago";
    } else {
      var minutes = Math.floor(timeDifference / 60);
      return minutes + " minute(s) ago";
    }
  } else {
    return "N/A";
  }
}

// Event listener for page load or refresh
window.addEventListener("load", function () {
  // Store the current time in localStorage
  localStorage.setItem("lastRefreshTime", new Date());

  // Update last updated information
  updateLastUpdatedInfo();
});

// Periodically update the last updated information
setInterval(function () {
  updateLastUpdatedInfo();
}, 10000); // Update every 10 seconds


/* ------ script for dynamic balance sizing ------ */
function updateBalanceFontSize() {
  var balanceElement = document.getElementById("display_account_balance");
  var balanceValue = balanceElement.textContent;

  // Count the number of digits before and after the decimal point
  var digitsBeforeDecimal = balanceValue.split(".")[0].replace(/,/g, "").length;
  var digitsAfterDecimal = balanceValue.split(".")[1]
    ? balanceValue.split(".")[1].length
    : 0;

  // Set the font size based on the number of digits
  var fontSize;
  if (digitsBeforeDecimal + digitsAfterDecimal <= 5) {
    fontSize = "2.2vw";
  } else if (digitsBeforeDecimal + digitsAfterDecimal <= 6) {
    fontSize = "2.2vw";
  } else if (digitsBeforeDecimal + digitsAfterDecimal <= 8) {
    fontSize = "2vw";
  } else if (digitsBeforeDecimal + digitsAfterDecimal <= 9) {
    fontSize = "1.8vw";
  } else if (digitsBeforeDecimal + digitsAfterDecimal <= 10) {
    fontSize = "1.7vw";
  } else {
    // Set a default font size if the balance is very large
    fontSize = "1.2vw";
  }

  // Apply the font size to the balance display
  document.getElementById("balance_display").style.fontSize = fontSize;
}

// Event listener for page load or refresh
window.addEventListener("load", function () {
  // Update balance font size
  updateBalanceFontSize();
});
