// display time in admin overview

function updateDateTime() {
  // Create a new Date object
  var currentDate = new Date();

  // Get date and time components using the 'en-PH' locale
  var dateOptions = { weekday: "long", month: "long", day: "numeric" };
  var timeOptions = {
    hour: "2-digit",
    minute: "2-digit",
    second: "2-digit",
    hour12: false,
  };

  var date = currentDate.toLocaleDateString("en-PH", dateOptions);
  var time = currentDate.toLocaleTimeString("en-PH", timeOptions);

  // Update the HTML elements
  document.getElementById("display_date").innerText = date;
  document.getElementById("display_time").innerText = time;
}

// Update the date and time every second (you can adjust the interval as needed)
setInterval(updateDateTime, 1000);

// Initial update when the page loads
updateDateTime();
