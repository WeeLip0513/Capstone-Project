document.addEventListener("DOMContentLoaded", function () {
  const addRideButton = document.querySelector("button[onclick*='showConfirmation']");
  addRideButton.addEventListener("click", function () {
      if (validateRideForm()) {
          showConfirmation();
      }
  });

  function validateRideForm() {
      let isValid = true;

      // Date Validation
      const txtDate = document.getElementById("txtDate");
      const txtDateError = document.getElementById("txtDateError");
      if (txtDate.value.trim() === "") {
          txtDateError.textContent = "Please select a date.";
          isValid = false;
      } else {
          txtDateError.textContent = "";
      }

      // Time Validation
      const hour = document.getElementById("hour");
      const minute = document.getElementById("minute");
      const timeError = document.getElementById("timeError");
      if (hour.value === "" || minute.value === "") {
          timeError.textContent = "Please select a valid time.";
          isValid = false;
      } else {
          timeError.textContent = "";
      }

      // Pickup Validation
      const pickup = document.getElementById("pickup");
      const pickupError = document.getElementById("pickupError");
      if (pickup.value === "") {
          pickupError.textContent = "Please select a pick-up point.";
          isValid = false;
      } else {
          pickupError.textContent = "";
      }

      // Drop-off Validation
      const dropoff = document.getElementById("dropoff");
      const dropoffError = document.getElementById("dropoffError");
      if (dropoff.value === "") {
          dropoffError.textContent = "Please select a drop-off point.";
          isValid = false;
      } else {
          dropoffError.textContent = "";
      }

      // Vehicle Validation
      const vehicle = document.getElementById("vehicle");
      const vehicleError = document.getElementById("vehicleError");
      if (vehicle.value === "") {
          vehicleError.textContent = "Please select a vehicle.";
          isValid = false;
      } else {
          vehicleError.textContent = "";
      }

      return isValid;
  }

  function showConfirmation() {
      const confirmationBox = document.getElementById("confirmation");
      const rideDetails = document.getElementById("rideDetails");

      const date = document.getElementById("txtDate").value;
      const time = document.getElementById("hour").value + ":" + document.getElementById("minute").value;
      const pickup = document.getElementById("pickup").options[document.getElementById("pickup").selectedIndex].text;
      const dropoff = document.getElementById("dropoff").options[document.getElementById("dropoff").selectedIndex].text;
      const vehicle = document.getElementById("vehicle").options[document.getElementById("vehicle").selectedIndex].text;

      rideDetails.innerHTML = `
          <strong>Date:</strong> ${date} <br>
          <strong>Time:</strong> ${time} <br>
          <strong>Pick-Up:</strong> ${pickup} <br>
          <strong>Drop-Off:</strong> ${dropoff} <br>
          <strong>Vehicle:</strong> ${vehicle} 
      `;

      confirmationBox.style.display = "block";
  }

  window.hideConfirmation = function () {
      document.getElementById("confirmation").style.display = "none";
  };

  window.submitForm = function () {
      document.getElementById("addRide").submit();
  };
});
