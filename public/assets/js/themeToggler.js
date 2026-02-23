const htmlElement = document.documentElement;
const toggleBtn = document.getElementById("theme-tog");
const iconS = document.getElementById("icon-S");
const iconM = document.getElementById("icon-M");

const prefersDark =
  window.matchMedia &&
  window.matchMedia("(prefers-color-scheme: dark)").matches;

if (
  localStorage.getItem("theme") === "dark" ||
  (!localStorage.getItem("theme") && prefersDark)
) {
  htmlElement.classList.add("dark");
  iconS.classList.remove("hidden");
  iconM.classList.add("hidden");
} else {
  htmlElement.classList.remove("dark");
  iconS.classList.add("hidden");
  iconM.classList.remove("hidden");
}

toggleBtn.addEventListener("click", () => {
  htmlElement.classList.toggle("dark");
  if (htmlElement.classList.contains("dark")) {
    localStorage.setItem("theme", "dark");
    iconS.classList.remove("hidden");
    iconM.classList.add("hidden");
  } else {
    localStorage.setItem("theme", "light");
    iconS.classList.add("hidden");
    iconM.classList.remove("hidden");
  }
});
