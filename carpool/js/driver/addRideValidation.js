document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("addRide");

  // Get form elements
  const date = document.getElementById("txtDate");
  const hour = document.getElementById("hour");
  const minute = document.getElementById("minute");
  const pickup = document.getElementById("pickup");
  const dropoff = document.getElementById("dropoff");
  const vehicle = document.getElementById("vehicle");

  // Get error message elements
  const dateError = document.getElementById("txtDateError");
  const timeError = document.getElementById("timeError");
  const pickupError = document.getElementById("pickupError");
  const dropoffError = document.getElementById("dropoffError");

  // Function to validate selection
  function validateField(field, errorElement, message) {
    if (field.value.trim() === "") {
      errorElement.textContent = message;
      field.classList.add("error-border"); // Add red border
      return false;
    } else {
      errorElement.textContent = "";
      field.classList.remove("error-border"); // Remove red border
      return true;
    }
  }

  // Function to validate date selection (must be strictly after today)
  function validateDate() {
    const selectedDate = new Date(date.value);
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset time to midnight for accurate comparison
    selectedDate.setHours(0, 0, 0, 0);

    if (date.value.trim() === "") {
      dateError.textContent = "Please select a date.";
      date.classList.add("error-border");
      return false;
    } else if (selectedDate <= today) { // Prevents today and past dates
      dateError.textContent = "Date must be after today.";
      date.classList.add("error-border");
      return false;
    } else {
      dateError.textContent = "";
      date.classList.remove("error-border");
      return true;
    }
  }

  // Function to validate time selection
  function validateTime() {
    let isHourValid = validateField(hour, timeError, "Please select a valid hour.");
    let isMinuteValid = validateField(minute, timeError, "Please select a valid minute.");
    return isHourValid && isMinuteValid;
  }

  // Function to validate pickup point
  function validatePickup() {
    return validateField(pickup, pickupError, "Please select a pickup point.");
  }

  // Function to validate drop-off point
  function validateDropoff() {
    if (dropoff.value.trim() === "") {
      dropoffError.textContent = "Please select a drop-off point.";
      dropoff.classList.add("error-border");
      return false;
    } else if (pickup.value === dropoff.value) {
      dropoffError.textContent = "Pickup and drop-off points cannot be the same.";
      dropoff.classList.add("error-border");
      return false;
    } else {
      dropoffError.textContent = "";
      dropoff.classList.remove("error-border");
      return true;
    }
  }

  // Function to validate vehicle selection
  function validateVehicle() {
    return validateField(vehicle, document.createElement("span"), "Please select a vehicle.");
  }

  // Attach event listeners for real-time validation
  date.addEventListener("change", validateDate);
  hour.addEventListener("change", validateTime);
  minute.addEventListener("change", validateTime);
  pickup.addEventListener("change", validatePickup);
  dropoff.addEventListener("change", validateDropoff);
  vehicle.addEventListener("change", validateVehicle);

  // Form submission validation
  form.addEventListener("submit", function (event) {
    let isValid = true;

    if (!validateDate()) isValid = false;
    if (!validateTime()) isValid = false;
    if (!validatePickup()) isValid = false;
    if (!validateDropoff()) isValid = false;
    if (!validateVehicle()) isValid = false;

    if (!isValid) {
      event.preventDefault(); // Prevent form submission if any validation fails
    }
  });
});

