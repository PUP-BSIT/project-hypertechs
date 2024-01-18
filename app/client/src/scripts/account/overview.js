
// script for dynamic balance sizing
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

// Periodically update the balance font size (you can adjust the interval as needed)
setInterval(function () {
  updateBalanceFontSize();
}, 60000); // Update every minute
