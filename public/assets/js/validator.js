document.addEventListener("DOMContentLoaded", () => {
  console.log("Validator script loaded");

  const showErrors = (errDiv, errors) => {
    errDiv.innerHTML = "";

    const ul = document.createElement("ul");
    ul.classList.add("list-disc", "pl-5", "space-y-1");

    errors.forEach((error) => {
      const li = document.createElement("li");
      li.textContent = error;
      ul.appendChild(li);
    });

    errDiv.appendChild(ul);

    errDiv.classList.remove("hidden");
  };

  const hideErrors = (errDiv) => {
    errDiv.innerHTML = "";
    errDiv.classList.add("hidden");
  };

  const forms = document.querySelectorAll(".js-validate-form");
  if (!forms.length) return;

  forms.forEach((form) => {
    const errDiv = form.querySelector(".js-err");
    if (!errDiv) return;

    form.addEventListener("submit", (e) => {
      const errors = [];

      const nameInp = form.querySelector("input[name='name']");
      const emailInp = form.querySelector("input[name='email']");
      const passwordInp = form.querySelector("input[name='password']");

      const name = nameInp ? nameInp.value.trim() : "";
      const email = emailInp ? emailInp.value.trim() : "";
      const password = passwordInp ? passwordInp.value : "";

      if (nameInp) {
        if (!name) errors.push("Name is required");
        else if (!/^[a-zA-Z\s]{5,20}$/.test(name)) {
          errors.push("Name must be at least 5 characters");
        }
      }

      if (emailInp) {
        if (!email) errors.push("Email is required");
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
          errors.push("Invalid email format");
        }
      }

      if (passwordInp) {
        if (!password) errors.push("Password is required");
        else if (password.length < 8) {
          errors.push("Password must be at least 8 characters long");
        } else if (!/[A-Za-z]/.test(password) || !/[0-9]/.test(password)) {
          errors.push(
            "Password must contain at least one letter and one number.",
          );
        }
      }

      if (errors.length > 0) {
        e.preventDefault();
        showErrors(errDiv, errors);
      } else {
        hideErrors(errDiv);
      }
    });
  });
});
