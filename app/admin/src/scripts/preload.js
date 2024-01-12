/* prevents color flickering when loading */
const theme = localStorage.getItem("theme") || "light";
document.documentElement.dataset.theme = theme;
