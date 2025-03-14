document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("withdrawForm");
  const bank = document.getElementById("bank");
  const accountName = document.getElementById("accountName");
  const accountNumber = document.getElementById("accountNumber");

  function validateInput(input, errorId, condition, message) {
    const errorElement = document.getElementById(errorId);
    if (condition) {
      errorElement.textContent = "";
      return true;
    } else {
      errorElement.textContent = message;
      return false;
    }
  }

  function validateForm(event) {
    let isValid = true;

    if (!validateInput(bank, "bankError", bank.value !== "", "Please select a bank")) {
      isValid = false;
    }

    if (!validateInput(accountName, "nameError", /^[a-zA-Z\s]+$/.test(accountName.value.trim()), "Name can only contain letters and spaces")) {
      isValid = false;
    }

    if (!validateInput(accountNumber, "accountError", /^[0-9]{10,16}$/.test(accountNumber.value), "Enter a valid account number (10-16 digits)")) {
      isValid = false;
    }

    if (!isValid) {
      event.preventDefault();
    }
  }

  bank.addEventListener("change", function () {
    validateInput(bank, "bankError", bank.value !== "", "Please select a bank");
  });

  accountName.addEventListener("input", function () {
    validateInput(accountName, "nameError", /^[a-zA-Z\s]+$/.test(accountName.value.trim()), "Name can only contain letters and spaces");
  });

  accountNumber.addEventListener("input", function () {
    validateInput(accountNumber, "accountError", /^[0-9]{10,16}$/.test(accountNumber.value), "Enter a valid account number (10-16 digits)");
  });

  form.addEventListener("submit", validateForm);
});
