const HOME_URL = "/index.html";

export function sendData(url, data, processData) {
  let statusCode;

  fetch(url, {
    method: "POST",
    body: data,
  })
    .then((response) => {
      statusCode = response.status;
      return response.json();
    })
    .then((data) => {
      if (statusCode === 302) {
        window.location.href = data.url;
        return;
      }
      data.statusCode = statusCode;
      processData(data);
    });
}

export function logSend(url, data, processData) {
  let statusCode;

  fetch(url, {
    method: "POST",
    body: data,
  })
    .then((response) => {
      statusCode = response.status;
      return response.text();
    })
    .then((data) => {
      if (statusCode === 302) {
        window.location.href = data.url;
        return;
      }
      console.log(data);
    });
}

export function fetchData(url, processData) {
  let statusCode;

  fetch(url)
    .then((response) => {
      statusCode = response.status;
      return response.json();
    })
    .then((data) => {
      data.statusCode = statusCode;
      processData(data);
    });
}

export function logFetch(url, processData) {
  let statusCode;

  fetch(url)
    .then((response) => {
      statusCode = response.status;
      return response.text();
    })
    .then((data) => {
      console.log(data);
    });
}

export function goToURL(url, processData) {
  fetch(url)
    .then((response) => {
      return response.status;
    })
    .then((statusCode) => {
      processData(statusCode);
    });
}

export function showFeedback(message, errMessage, result, area) {
  if (!result) {
    area.innerHTML = errMessage;
    return;
  }
  area.innerHTML = message;
  setTimeout(() => {
    area.innerHTML = "";
  }, 3000);
}

export function strToNum(number) {
  number = parseFloat(number);
  return number.toLocaleString("en-US", {
    style: "decimal",
    minimumFractionDigits: 2,
  });
}

export function genErrorMessage(statusCode) {
  let message;

  switch (statusCode) {
    case 400:
      message =
        "The server couldn't understand your request. " +
        "Check your input if it is correct.";
      break;
    case 401:
      message =
        "Access denied. Please provide valid credentials " +
        "to access the requested resource.";
      break;
    case 403:
      message =
        "You don't have permission to access this resource. " +
        "Contact the administrator for access.";
      break;
    case 404:
      message =
        "The resource could not be found. Check your input " +
        "if it is correct.";
      break;
    default:
      message = "There was an error. Try reloading the page.";
  }
  return message;
}

export function clearFeedback(area) {
  setTimeout(() => {
    area.innerHTML = "&nbsp";
  }, 3000);
}

export function checkAdminSession(start) {
  let url;

  url = "../../backend/php/admin-session.php";
  fetchData(url, (data) => {
    if (!data.success) {
      window.location.href = HOME_URL;
      return;
    }
    start();
  });
}

export function saveRequest(url, body) {
  let requestBody, saveURL;

  saveURL = "../../backend/php/request-save.php";
  requestBody = new FormData();
  requestBody.append("request_url", url);
  requestBody.append("request_body", formToString(body));
  sendData(saveURL, requestBody);
}

export function formToString(formData) {
  let form;

  form = {};
  formData.forEach((value, key) => {
    form[key] = value;
  });
  return JSON.stringify(form);
}
