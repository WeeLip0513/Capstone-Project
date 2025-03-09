document.addEventListener("DOMContentLoaded", function () {
    fetchExistingRides();
    
    const addRideButton = document.querySelector("button[onclick*='showConfirmation']");
    addRideButton.addEventListener("click", function () {
        if (validateRideForm()) {
            checkForConflicts();
        }
    });

    let existingRides = [];

    function fetchExistingRides() {
        fetch('get_rides.php')
            .then(response => response.json())
            .then(data => {
                existingRides = data;
            })
            .catch(error => console.error('Error fetching rides:', error));
    }

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

    function checkForConflicts() {
        const selectedDate = document.getElementById("txtDate").value;
        const selectedHour = parseInt(document.getElementById("hour").value, 10);
        const selectedMinute = parseInt(document.getElementById("minute").value, 10);
        const selectedTimeInMinutes = selectedHour * 60 + selectedMinute;

        const conflictingRide = existingRides.find(ride => {
            if (ride.date === selectedDate) {
                const [rideHour, rideMinute] = ride.time.split(":").map(Number);
                const rideTimeInMinutes = rideHour * 60 + rideMinute;
                return Math.abs(selectedTimeInMinutes - rideTimeInMinutes) <= 120;
            }
            return false;
        });

        if (conflictingRide) {
            showConflictResolution(conflictingRide);
        } else {
            showConfirmation();
        }
    }

    function showConflictResolution(conflictingRide) {
        const conflictBox = document.getElementById("conflictRides");
        const conflictDetails = document.getElementById("conflictDetails");

        const selectedRideDetails = `
            <strong>Date:</strong> ${document.getElementById("txtDate").value} <br>
            <strong>Time:</strong> ${document.getElementById("hour").value}:${document.getElementById("minute").value} <br>
            <strong>Pick-Up:</strong> ${document.getElementById("pickup").options[document.getElementById("pickup").selectedIndex].text} <br>
            <strong>Drop-Off:</strong> ${document.getElementById("dropoff").options[document.getElementById("dropoff").selectedIndex].text} <br>
            <strong>Vehicle:</strong> ${document.getElementById("vehicle").options[document.getElementById("vehicle").selectedIndex].text} 
        `;

        conflictDetails.innerHTML = `
            <h3>Existing Ride:</h3>
            <p>${conflictingRide.date} | ${conflictingRide.time} | ${conflictingRide.pickup} → ${conflictingRide.dropoff} | ${conflictingRide.vehicle}</p>
            <h3>Selected Ride:</h3>
            <p>${selectedRideDetails}</p>
            <button onclick="replaceRide()">Replace Ride</button>
            <button onclick="keepPreviousRide()">Keep Existing Ride</button>
        `;

        conflictBox.style.display = "block";
    }

    window.replaceRide = function () {
        existingRides = existingRides.filter(ride => ride.date !== document.getElementById("txtDate").value);
        existingRides.push({
            date: document.getElementById("txtDate").value,
            time: `${document.getElementById("hour").value}:${document.getElementById("minute").value}`,
            pickup: document.getElementById("pickup").options[document.getElementById("pickup").selectedIndex].text,
            dropoff: document.getElementById("dropoff").options[document.getElementById("dropoff").selectedIndex].text,
            vehicle: document.getElementById("vehicle").options[document.getElementById("vehicle").selectedIndex].text
        });
        document.getElementById("conflictRides").style.display = "none";
        showConfirmation();
    };

    window.keepPreviousRide = function () {
        document.getElementById("conflictRides").style.display = "none";
    };

    function showConfirmation() {
        const confirmationBox = document.getElementById("confirmation");
        confirmationBox.style.display = "block";
    }

    // ✅ Move this function inside DOMContentLoaded
    function validateAndCheckConflict() {
        if (validateRideForm()) {
            checkForConflicts();
        }
    }

    // ✅ Make it globally accessible
    window.validateAndCheckConflict = validateAndCheckConflict;
});
