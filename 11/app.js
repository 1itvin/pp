const nameInput = document.querySelector("#name");
const loginInput = document.querySelector("#login");
const passwordInput = document.querySelector("#password");
const passwordConfInput = document.querySelector("#password-confirm");
const fileInput = document.querySelector("#file");
const emailInput = document.querySelector("#email");
const countryInput = document.querySelector("#country");
const submitBtn = document.querySelector("#submit-btn");

const validInputs = {
  name: false,
  login: false,
  pass: false,
  passConf: false,
  email: false,
};

const shownInputErrs = {
  name: false,
  login: false,
  pass: false,
  passConf: false,
  email: false,
  // file: true,
  // country: true,
};

function showInputError(errMsg, target, inputType) {
  if (shownInputErrs[inputType]) return;

  const parent = target.parentElement;
  const span = document.createElement("span");
  span.innerText = errMsg;
  span.className = "input-error-msg";

  parent.appendChild(span);
  target.classList.add("input-error-msg");
  shownInputErrs[inputType] = true;
  validInputs[inputType] = false;
}

function hideInputError(target, inputType) {
  if (!shownInputErrs[inputType]) {
    return;
  }

  const parent = target.parentElement;
  parent.removeChild(parent.lastElementChild);
  target.classList.remove("input-error-msg");
  shownInputErrs[inputType] = false;
  validInputs[inputType] = true;
}

nameInput.addEventListener("keyup", (e) => {
  e.target.value = e.target.value.trim();
  const value = e.target.value;

  if (value.length < 4 || value.length > 200) {
    showInputError(
      "Name must be at least 4 chars and not longer than 200 chars",
      e.target,
      "name"
    );
    return;
  }

  if (/[^0-9A-Za-z!@#&*()_{[}\]|\.?\/]/g.test(value)) {
    showInputError("Characters are not acceptable", e.target, "name");
    return;
  }

  hideInputError(e.target, "name");
});

loginInput.addEventListener("keyup", (e) => {
  e.target.value = e.target.value.trim();
  const value = e.target.value;

  if (value.length < 4 || value.length > 100) {
    showInputError(
      "Login must be at least 4 chars and not longer than 100 chars",
      e.target,
      "login"
    );
    return;
  }

  if (/[^0-9A-Za-z!@#&*()_{[}\]|\.?\/]/g.test(value)) {
    showInputError("Characters are not acceptable", e.target, "login");
    return;
  }

  hideInputError(e.target, "login");
});

passwordInput.addEventListener("keyup", (e) => {
  e.target.value = e.target.value.trim();
  const value = e.target.value;
  console.log(value);
  if (value.length < 8 || value.length > 24) {
    showInputError(
      "Password must be at least 8 chars and not longer than 24 chars",
      e.target,
      "pass"
    );
    return;
  }

  if (/[^0-9A-Za-z!@#&*()_{[}\]|\.?\/]/g.test(value)) {
    showInputError("Characters are not acceptable", e.target, "pass");
    return;
  }

  hideInputError(e.target, "pass");
});

passwordConfInput.addEventListener("keyup", (e) => {
  e.target.value = e.target.value.trim();
  const value = e.target.value;

  if (value.length < 8 || value.length > 24) {
    showInputError(
      "Password must be at least 8 chars and not longer than 24 chars",
      e.target,
      "passConf"
    );
    return;
  }

  if (/[^0-9A-Za-z!@#&*()_{[}\]|\.?\/]/g.test(value)) {
    showInputError("Characters are not acceptable", e.target, "passConf");
    return;
  }

  if (value !== passwordInput.value) {
    showInputError("Passwords don't match", e.target, "passConf");
    return;
  }

  hideInputError(e.target, "passConf");
});

emailInput.addEventListener("keyup", (e) => {
  e.target.value = e.target.value.trim();
  const value = e.target.value.trim();
  const regex =
    /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/;

  if (!regex.test(value.toLowerCase())) {
    showInputError("Characters are not acceptable", e.target, "email");
    return;
  }

  hideInputError(e.target, "email");
});

submitBtn.addEventListener("click", (e) => {
  e.preventDefault();

  const areInputsValid = Object.values(validInputs).every((val) => val);

  if (!areInputsValid) {
    nameInput.dispatchEvent(new KeyboardEvent("keyup"));
    loginInput.dispatchEvent(new KeyboardEvent("keyup"));
    passwordInput.dispatchEvent(new KeyboardEvent("keyup"));
    passwordConfInput.dispatchEvent(new KeyboardEvent("keyup"));
    emailInput.dispatchEvent(new KeyboardEvent("keyup"));
    alert("Incorrect form");
    return;
  }

  const objToSend = {
    name: nameInput.value,
    login: loginInput.value,
    pass: passwordInput.value,
    passConf: passwordConfInput.value,
    file: fileInput.value,
    email: emailInput.value,
    country: countryInput.value,
  };

  console.log("Object to send to a server: ", objToSend);

  nameInput.value = "";
  loginInput.value = "";
  passwordInput.value = "";
  passwordConfInput.value = "";
  fileInput.value = "";
  emailInput.value = "";
  countryInput.value = "none";
});
