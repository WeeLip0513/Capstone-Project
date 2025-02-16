document.addEventListener("DOMContentLoaded", function () {
  const driverInputs = document.querySelectorAll("#driverSection input");
  const vehicleInputs = document.querySelectorAll("#vehicleSection input");

  // Add event listeners for real-time validation
  driverInputs.forEach(input => {
      input.addEventListener("input", () => validateField(input));
  });

  vehicleInputs.forEach(input => {
      input.addEventListener("input", () => validateField(input));
  });

  document.getElementById("nextButton").addEventListener("click", function () {
      if (validateDriverForm()) {
          document.getElementById("driverSection").style.display = "none";
          document.getElementById("vehicleSection").style.display = "block";
      }
  });

  document.getElementById("backButton").addEventListener("click", function () {
      document.getElementById("vehicleSection").style.display = "none";
      document.getElementById("driverSection").style.display = "block";
  });

  document.getElementById("registrationForm").addEventListener("submit", function (event) {
      if (!validateVehicleForm()) {
          event.preventDefault(); // Prevent submission if validation fails
      }
  });
});

// Validation function for individual fields
function validateField(input) {
  let errorSpan = document.getElementById(input.id + "Error");
  let value = input.value.trim();
  let isValid = true;

  switch (input.id) {
      case "txtTP":
      case "txtLicense":
      case "plateNo":
          isValid = /^[A-Za-z0-9]+$/.test(value);
          errorSpan.innerText = isValid ? "" : "Only letters and numbers are allowed.";
          break;

      case "txtFname":
      case "txtLname":
      case "vehicleBrand":
      case "vehicleColor":
      case "vehicleType":
          isValid = /^[A-Za-z]+$/.test(value);
          errorSpan.innerText = isValid ? "" : "Only letters are allowed.";
          break;

      case "txtPass":
          isValid = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%^&+=]).{8,}$/.test(value);
          errorSpan.innerText = isValid ? "" : "Password must be at least 8 characters with an uppercase, lowercase, number, and special character.";
          break;

      case "txtPhone":
          isValid = /^[0-9]+$/.test(value);
          errorSpan.innerText = isValid ? "" : "Only numbers are allowed.";
          break;

      case "txtExpDate":
          isValid = value !== "";
          errorSpan.innerText = isValid ? "" : "Select a valid date.";
          break;

      case "license_photo":
          isValid = input.files.length > 0;
          errorSpan.innerText = isValid ? "" : "Upload a valid image.";
          break;

      case "vehicleYear":
          isValid = parseInt(value) >= 1900 && parseInt(value) <= new Date().getFullYear();
          errorSpan.innerText = isValid ? "" : "Enter a valid year.";
          break;

      case "seatNo":
          isValid = parseInt(value) >= 1;
          errorSpan.innerText = isValid ? "" : "Seat number must be at least 1.";
          break;

      default:
          isValid = value !== "";
          errorSpan.innerText = isValid ? "" : "This field is required.";
  }

  return isValid;
}

// Validate the entire driver form
function validateDriverForm() {
  let isValid = true;
  document.querySelectorAll("#driverSection input").forEach(input => {
      if (!validateField(input)) {
          isValid = false;
      }
  });
  return isValid;
}

// Validate the entire vehicle form
function validateVehicleForm() {
  let isValid = true;
  document.querySelectorAll("#vehicleSection input").forEach(input => {
      if (!validateField(input)) {
          isValid = false;
      }
  });
  return isValid;
}
