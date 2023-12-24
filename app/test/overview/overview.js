// JavaScript code to toggle between light and dark themes
document.addEventListener("DOMContentLoaded", function () {
    const root = document.documentElement;
    const currentTheme = localStorage.getItem("theme") || "light";
  
    root.setAttribute("data-theme", currentTheme);
  
    function toggleTheme() {
      const newTheme =
        root.getAttribute("data-theme") === "light" ? "dark" : "light";
      root.setAttribute("data-theme", newTheme);
      localStorage.setItem("theme", newTheme);
    }
  
    const themeToggle = document.getElementById("theme_mode");
    themeToggle.checked = currentTheme === "dark";
  
    themeToggle.addEventListener("change", toggleTheme);
  });
  