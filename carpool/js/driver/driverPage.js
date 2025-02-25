document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.featureBtn'); // Updated selector
    const contents = document.querySelectorAll('.contents > div');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const contentId = this.getAttribute('data-content');

            contents.forEach(content => content.style.display = 'none'); // Hide all contents

            // Show the selected content
            const selectedContent = document.querySelector('.' + contentId);
            if (selectedContent) selectedContent.style.display = 'flex';

            // Remove 'active' class from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));

            // Add 'active' class to the clicked button
            this.classList.add('active');
        });
    });

    // Show the first content by default
    if (buttons.length > 0 && contents.length > 0) {
        buttons[0].classList.add('active');
        contents[0].style.display = 'flex'; // Ensure the default content is visible
    }

    // Get form elements
    const txtDate = document.getElementById("txtDate");
    const txtDateError = document.getElementById("txtDateError");

    const hour = document.getElementById("hour");
    const minute = document.getElementById("minute");
    const timeError = document.getElementById("timeError");

    const pickup = document.getElementById("pickup");
    const pickupError = document.getElementById("pickupError");

    const dropoff = document.getElementById("dropoff");
    const dropoffError = document.getElementById("dropoffError");

    const vehicle = document.getElementById("vehicle");
    const vehicleError = document.getElementById("vehicleError");

    // Set the min date to tomorrow
    const today = new Date();
    today.setDate(today.getDate() + 1); // Move to tomorrow
    const minDate = today.toISOString().split("T")[0];
    txtDate.setAttribute("min", minDate); // Set min date to tomorrow

    // Validation function
    function validateField(input, errorElement, errorMessage) {
        if (!input.value.trim()) {
            errorElement.textContent = errorMessage;
            errorElement.style.color = "red";
            input.style.border = "2px solid red";
        } else {
            errorElement.textContent = "";
            input.style.border = "2px solid #ffc107";
        }
    }

    function validateLocations() {
        const pickup = document.getElementById("pickup");
        const dropoff = document.getElementById("dropoff");
        const pickupError = document.getElementById("pickupError");
        const dropoffError = document.getElementById("dropoffError");

        let isValid = true;

        // Check if pickup is selected
        if (!pickup.value) {
            pickupError.textContent = "Please select a pick-up point.";
            pickupError.style.color = "red";
            pickup.style.border = "2px solid red";
            isValid = false;
        } else {
            pickupError.textContent = "";
            pickup.style.border = "2px solid #ffc107";
        }

        // Check if drop-off is selected
        if (!dropoff.value) {
            dropoffError.textContent = "Please select a drop-off point.";
            dropoffError.style.color = "red";
            dropoff.style.border = "2px solid red";
            isValid = false;
        } else {
            dropoffError.textContent = "";
            dropoff.style.border = "2px solid #ffc107";
        }

        // Check if both are selected and not the same
        if (pickup.value && dropoff.value && pickup.value === dropoff.value) {
            dropoffError.textContent = "Pickup and Drop-off cannot be the same.";
            dropoffError.style.color = "red";
            pickup.style.border = "2px solid red";
            dropoff.style.border = "2px solid red";
            isValid = false;
        }

        return isValid;
    }


    // Date Validation (Ensures a date is selected)
    function validateDate() {
        if (!txtDate.value.trim()) {
            txtDateError.textContent = "Please select a date.";
            txtDateError.style.color = "red";
            txtDate.style.border = "2px solid red";
        } else {
            txtDateError.textContent = "";
            txtDate.style.border = "2px solid #ffc107";
        }
    }

    // Attach real-time validation to fields
    txtDate.addEventListener("input", validateDate);
    hour.addEventListener("change", () => validateField(hour, timeError, "Please select a valid time."));
    minute.addEventListener("change", () => validateField(minute, timeError, "Please select a valid time."));
    pickup.addEventListener("change", validateLocations);
    dropoff.addEventListener("change", validateLocations);
    vehicle.addEventListener("change", () => validateField(vehicle, vehicleError, "Please select a vehicle."));

    // Main validation function when form is submitted
    window.validateRideForm = function () {
        let isValid = true;

        validateDate();
        validateField(hour, timeError, "Please select a valid time.");
        validateField(minute, timeError, "Please select a valid time.");
        validateField(pickup, pickupError, "Please select a pick-up point.");
        validateField(dropoff, dropoffError, "Please select a drop-off point.");
        validateField(vehicle, vehicleError, "Please select a vehicle.");
        validateLocations();

        // Check if there are any error messages still present
        document.querySelectorAll(".error").forEach((error) => {
            if (error.textContent !== "") {
                isValid = false;
            }
        });

        return isValid;
    };
});

// Show Confirmation Pop-up
function showConfirmation() {
    if (!validateRideForm()) return; // Prevent pop-up if validation fails

    const confirmationBox = document.getElementById("confirmation");
    const rideDetails = document.getElementById("rideDetails");

    const date = document.getElementById("txtDate").value;
    const time = document.getElementById("hour").value + document.getElementById("minute").value;
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
    document.getElementById('addRideContainer').style.display = 'none';
    document.getElementById('historyContainer').style.display = 'none';

}

// Hide Confirmation Pop-up
function hideConfirmation() {
    document.getElementById('confirmation').style.display = 'none';
    document.getElementById('addRideContainer').style.display = 'block';
    document.getElementById('historyContainer').style.display = 'block';
}

function submitForm() {
    const form = document.getElementById("addRideForm");

    if (!form) {
        console.error("🚨 Form not found!");
        return;
    }

    console.log("✅ Form found. Submitting...");
    
    // Hide confirmation popup to prevent interference
    document.getElementById("confirmation").style.display = "none"; 

    // Submit the form
    form.submit();
}

function addSelectedRides() {
    let selectedRides = [];

    // Get all checked checkboxes
    document.querySelectorAll('.rideCheckbox:checked').forEach(checkbox => {
      let ride = JSON.parse(checkbox.dataset.ride);
      let newDate = getThisWeekDate(ride.day); // Get the current week's date based on the day
      ride.newDate = newDate;
      selectedRides.push(ride);
    });

    if (selectedRides.length > 0) {
      console.log("Adding Rides:", selectedRides);

      // Send data to PHP via AJAX
      fetch("php/driver/addSelectedRide.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(selectedRides)
      })
        .then(response => response.text())
        .then(data => {
          alert("Rides Added Successfully!");
          console.log(data);
        })
        .catch(error => console.error("Error:", error));
    } else {
      alert("No rides selected!");
    }
  }

  function getThisWeekDate(dayName) {
    let today = new Date();
    let daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

    let targetDay = daysOfWeek.indexOf(dayName);
    let currentDay = today.getDay();

    let difference = targetDay - currentDay;
    if (difference < 0) difference += 7; // If it's a past day, move to the next week

    let newDate = new Date();
    newDate.setDate(today.getDate() + difference);

    return newDate.toISOString().split('T')[0]; // Return YYYY-MM-DD format
  }