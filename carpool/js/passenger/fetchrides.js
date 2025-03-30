document.addEventListener("DOMContentLoaded", function () {
    let pickup = document.getElementById("pickup");
    let dropoff = document.getElementById("dropoff");
    let date = document.getElementById("date");
    let hour = document.getElementById("hour");
    let minute = document.getElementById("minute");
    let rideResults = document.getElementById("rideResults");

    // Ensure rideResults exists before running
    if (!rideResults) {
        console.error("Error: Element #rideResults not found in the document.");
        return;
    }

    function fetchRides() {
        let pickupVal = pickup.value;
        let dropoffVal = dropoff.value;
        let dateVal = date.value;
        let hourVal = hour.value;
        let minuteVal = minute.value;

        if (!pickupVal || !dropoffVal || !dateVal || !hourVal || !minuteVal) {
            rideResults.innerHTML = "<p>Please select all fields to see available rides.</p>";
            return;
        }

        let timeVal = hourVal + ":" + minuteVal;

        let formData = new FormData();
        formData.append("pickup", pickupVal);
        formData.append("dropoff", dropoffVal);
        formData.append("date", dateVal);
        formData.append("time", timeVal);

        fetch("../php/passenger/displayrides.php", {
            method: "POST",
            body: formData,
        })
        .then(response => response.text())
        .then(data => {
            if (rideResults) {
                rideResults.innerHTML = data;
            }
        })
        .catch(error => console.error("Error:", error));
    }

    pickup.addEventListener("change", fetchRides);
    dropoff.addEventListener("change", fetchRides);
    date.addEventListener("change", fetchRides);
    hour.addEventListener("change", fetchRides);
    minute.addEventListener("change", fetchRides);
});

document.addEventListener("DOMContentLoaded", function () {
    let dateInput = document.getElementById("date");
    // Get today's date
    let today = new Date();
    today.setDate(today.getDate() + 1);
    let minDate = today.toISOString().split("T")[0];  // Format the date as YYYY-MM-DD
    dateInput.setAttribute("min", minDate); // Set the min attribute of the date input field
});
