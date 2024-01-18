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
