document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("withdrawForm");
  const bank = document.getElementById("bank");
  const accountName = document.getElementById("accountName");
  const accountNumber = document.getElementById("accountNumber");
  const withdrawAmount = document.getElementById("withdrawAmount");
  const submitButton = document.getElementById("submitBtn");
  const month = document.querySelector("input[name='month']");
  const nameError = document.getElementById("nameError");
  const accountError = document.getElementById("accountError");
  const bankError = document.getElementById("bankError");
  const backBtn = document.getElementById("backBtn");

  // Function to validate fields
  function validateField(field, errorElement, condition, message) {
      if (!condition) {
          errorElement.textContent = message;
          return false;
      } else {
          errorElement.textContent = "";
          return true;
      }
  }

  function validateForm() {
      let isValid = true;

      const nameValid = /^[a-zA-Z\s]+$/.test(accountName.value.trim());
      const accountValid = /^[0-9]{10,16}$/.test(accountNumber.value.trim());

      isValid = validateField(bank, bankError, bank.value !== "", "Please select a bank.") && isValid;
      isValid = validateField(accountName, nameError, accountName.value.trim() !== "", "Account name is required.") && isValid;
      isValid = validateField(accountName, nameError, nameValid, "Name can only contain letters and spaces.") && isValid;
      isValid = validateField(accountNumber, accountError, accountNumber.value.trim() !== "", "Account number is required.") && isValid;
      isValid = validateField(accountNumber, accountError, accountValid, "Enter a valid account number (10-16 digits).") && isValid;

      return isValid;
  }

  form.addEventListener("submit", function (event) {
      event.preventDefault();
      if (!validateForm()) return;

      submitButton.disabled = true; // Prevent multiple submissions

      const formData = {
          bank: bank.value.trim(),
          accountName: accountName.value.trim(),
          accountNumber: accountNumber.value.trim(),
          withdrawAmount: parseFloat(withdrawAmount.value), // Fixed amount
          month: month.value.trim(),
      };

      console.log("Sending data:", formData); // Debugging: See if data is correct before sending

      fetch("../php/driver/withdraw.php", {
          method: "POST",
          headers: {
              "Content-Type": "application/json",
          },
          body: JSON.stringify(formData),
      })
      .then(response => {
          console.log("Raw Response:", response);
          return response.json();
      })
      .then(data => {
          console.log("Response received:", data); // Debugging: Log response
          if (data.success) {
              alert("Withdrawal request submitted successfully!");
              form.reset();
              window.location.href = "successPage.php"; // Redirect if needed
          } else {
              alert("Error: " + data.message);
          }
      })
      .catch(error => {
          console.error("Error:", error);
          alert("An error occurred. Please try again.");
      })
      .finally(() => {
          submitButton.disabled = false;
      });
  });

  backBtn.addEventListener("click", function (event) {
    event.preventDefault(); // Prevent default button behavior
    window.history.back(); // Go back to the previous page

    // Refresh the page after going back
    setTimeout(() => {
        location.reload();
    }, 500); // Delay to ensure the page loads first before refreshing
});



});
