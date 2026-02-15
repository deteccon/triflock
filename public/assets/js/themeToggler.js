const htmlElement = document.documentElement;
const toggleBtn = document.getElementById("theme-tog");
const iconS = document.getElementById("icon-S");
const iconM = document.getElementById("icon-M");

if (
  localStorage.getItem("theme") === "dark" ||
  (!localStorage.getItem("theme") &&
    window.matchMedia("(prefers-color-scheme: dark)").matches())
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

