document.addEventListener("DOMContentLoaded", function () {
  const selectedRidesDiv = document.getElementById("selectedRidesConfirmation");
  let conflictMap = {}; // Object to store ride conflicts

  // Function to display selected rides for confirmation
  window.showSelectedRidesConfirmation = function () {
    let selectedRides = [];

    // Collect selected ride details
    document.querySelectorAll('.rideCheckbox:checked').forEach(checkbox => {
      const rideData = JSON.parse(checkbox.getAttribute('data-ride'));

      selectedRides.push({
        ride_id: rideData.id,
        date: rideData.day.toLowerCase(),
        hour: rideData.formatted_time.split(':')[0],
        minute: rideData.formatted_time.split(':')[1],
        pickup: rideData.pick_up_point.toLowerCase(),
        dropoff: rideData.drop_off_point.toLowerCase()
      });
    });

    if (selectedRides.length === 0) {
      alert("No rides selected!");
      return;
    }

    if (selectedRides.length > 7) {
      alert("You can select a maximum of 7 rides at a time.");
      return;
    }

    fetchRides(selectedRides);
  };

  // Fetch ride conflicts from the server
  async function fetchRides(selectedRides) {
    try {
      const response = await fetch("../php/driver/checkMultipleRideConflicts.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ride_ids: selectedRides.map(r => r.ride_id) })
      });

      const data = await response.json();
      buildConflictMap(data); // Store conflict mapping
      displayRides(data); // Show ride selection table
    } catch (error) {
      console.error("Error fetching rides:", error);
    }
  }

  // Create a conflict mapping between rides
  function buildConflictMap(data) {
    conflictMap = {}; // Reset previous conflict mapping

    if (data.conflicts && Array.isArray(data.conflicts)) {
      data.conflicts.forEach(conflict => {
        let originalRideId = conflict.original_ride_id;
        let conflictRideId = conflict.conflict_id;

        // Create bi-directional mapping of conflicting rides
        if (!conflictMap[originalRideId]) conflictMap[originalRideId] = [];
        if (!conflictMap[conflictRideId]) conflictMap[conflictRideId] = [];

        conflictMap[originalRideId].push(conflictRideId);
        conflictMap[conflictRideId].push(originalRideId);
      });
    }
  }

  // Display selected rides in a table with checkboxes
  function displayRides(data) {
    selectedRidesDiv.innerHTML = ""; // Clear previous content

    let table = document.createElement("table");
    table.border = "1";
    table.style.width = "100%";
    table.innerHTML = `
          <thead>
              <tr>
                  <th>Select</th>
                  <th>Ride ID</th>
                  <th>Day</th>
                  <th>Time</th>
                  <th>Pick-up</th>
                  <th>Drop-off</th>
              </tr>
          </thead>
          <tbody id="ridesTableBody"></tbody>
      `;
    selectedRidesDiv.appendChild(table);
    let tbody = document.getElementById("ridesTableBody");

    let ridesMap = {}; // Track rides to insert conflicts correctly

    // Insert main rides first
    if (data.original_rides && Array.isArray(data.original_rides)) {
      data.original_rides.forEach(ride => {
        let rideRow = createRideRow(ride, false);
        tbody.appendChild(rideRow);
        ridesMap[ride.original_ride_id] = rideRow;
      });
    }

    // Insert conflicting rides after their corresponding main ride
    if (data.conflicts && Array.isArray(data.conflicts)) {
      data.conflicts.forEach(conflict => {
        let conflictRow = createRideRow(conflict, true);
        let originalRideRow = ridesMap[conflict.original_ride_id];

        if (originalRideRow) {
          originalRideRow.insertAdjacentElement("afterend", conflictRow);
        } else {
          tbody.appendChild(conflictRow);
        }
      });
    }

    // Create button container for confirmation/cancel actions
    let buttonContainer = document.createElement("div");
    buttonContainer.style.marginTop = "15px";
    buttonContainer.style.textAlign = "center";

    // Confirm selection button
    let confirmButton = document.createElement("button");
    confirmButton.innerText = "Confirm Selection";
    confirmButton.style.marginRight = "10px";
    confirmButton.addEventListener("click", confirmSelection);

    // Cancel selection button
    let cancelButton = document.createElement("button");
    cancelButton.innerText = "Cancel";
    cancelButton.addEventListener("click", cancelSelection);

    buttonContainer.appendChild(confirmButton);
    buttonContainer.appendChild(cancelButton);
    selectedRidesDiv.appendChild(buttonContainer);

    selectedRidesDiv.style.display = "block";
    document.getElementById("addRideContainer").style.display = "none";
    document.getElementById("historyContainer").style.display = "none";

    attachCheckboxListeners(); // Ensure checkbox selection rules apply
  }

  let confirmRideIds = []; // Global variable

  function confirmSelection() {
    confirmRideIds = [];
    document.querySelectorAll(".cRideCheckbox:checked").forEach(checkbox => {
      confirmRideIds.push(checkbox.value);
    });
    console.log("Confirmed Ride IDs:", confirmRideIds);
    alert("Rides confirmed!");
    // selectedRidesDiv.style.display = "none";
    displayConfirmedRides(confirmRideIds);
  }

  function cancelSelection() {
    selectedRidesDiv.style.display = "none";
  }

  // Create a row for a ride entry
  function createRideRow(ride, isConflict) {
    let row = document.createElement("tr");
    let rideId = isConflict ? ride.conflict_id : ride.original_ride_id;
    let rideDate = ride.original_date || ride.date;
    let rideTime = ride.original_time || ride.time;
    let dayOfWeek = getDayOfWeek(rideDate);

    if (isConflict) row.style.backgroundColor = "#ffcccc";

    row.innerHTML = `
          <td>
              <input type="checkbox" class="cRideCheckbox" id="checkbox_${rideId}" value="${rideId}" data-ride='${JSON.stringify(ride)}'>
              <label for="checkbox_${rideId}">(${rideId})</label>
          </td>
          <td>${rideId}</td>
          <td>${dayOfWeek}</td>
          <td>${rideTime}</td>
          <td>${ride.pick_up_point}</td>
          <td>${ride.drop_off_point}</td>
      `;

    return row;
  }

  // Attach event listeners to disable conflicting rides
  function attachCheckboxListeners() {
    document.querySelectorAll(".cRideCheckbox").forEach(checkbox => {
      checkbox.addEventListener("change", function () {
        let rideId = this.value;

        if (this.checked) {
          if (conflictMap[rideId]) {
            conflictMap[rideId].forEach(conflictId => {
              let conflictCheckbox = document.getElementById(`checkbox_${conflictId}`);
              if (conflictCheckbox) conflictCheckbox.disabled = true;
            });
          }
        } else {
          if (conflictMap[rideId]) {
            conflictMap[rideId].forEach(conflictId => {
              let conflictCheckbox = document.getElementById(`checkbox_${conflictId}`);
              if (conflictCheckbox) conflictCheckbox.disabled = false;
            });
          }
        }
      });
    });
  }

  function getDayOfWeek(dateString) {
    const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    let date = new Date(dateString);

    if (isNaN(date.getTime())) {
      console.error("Invalid date:", dateString);
      return "Invalid Date";
    }

    return days[date.getDay()];
  }

  function displayConfirmedRides(confirmRideIds) {
    // Helper function to get next week's date for a given weekday name
    function getNextWeekDate(weekdayName) {
        const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        let today = new Date();
        let todayIndex = today.getDay(); // Get index (0 for Sunday, 1 for Monday, etc.)
        let targetIndex = daysOfWeek.indexOf(weekdayName); // Find index of the given weekday
        
        if (targetIndex === -1) {
            console.error("Invalid weekday:", weekdayName);
            return null;
        }

        // Calculate days until next occurrence of the target day
        let daysUntilNext = (targetIndex - todayIndex + 7) % 7;
        let nextDate = new Date();
        nextDate.setDate(today.getDate() + daysUntilNext + 7); // Move to next week's same day

        return {
            fullDate: nextDate.toISOString().split("T")[0], // Format as YYYY-MM-DD
            weekday: daysOfWeek[nextDate.getDay()] // Get the weekday name for next week's date
        };
    }

    // Store ride details before clearing
    let confirmedRides = confirmRideIds.map(id => {
        let checkbox = document.querySelector(`#checkbox_${id}`);
        if (checkbox) {
            let row = checkbox.closest("tr");
            if (row) {
                let originalDay = row.cells[2].textContent.trim(); // Get day name (e.g., Monday)
                let nextWeekDateInfo = getNextWeekDate(originalDay); // Convert to next week's date

                return {
                    day: nextWeekDateInfo.weekday, // Show weekday name instead of ride ID
                    date: nextWeekDateInfo.fullDate, // Full date (YYYY-MM-DD)
                    time: row.cells[3].textContent,
                    pickup: row.cells[4].textContent,
                    dropoff: row.cells[5].textContent
                };
            }
        }
        return null;
    }).filter(ride => ride !== null); // Remove any null values

    // Clear previous data but keep selectedRidesDiv visible
    selectedRidesDiv.innerHTML = "";

    // Create new table
    let table = document.createElement("table");
    table.border = "1";
    table.style.width = "100%";
    table.innerHTML = `
        <thead>
            <tr>
                <th>Day</th>
                <th>Date</th>
                <th>Time</th>
                <th>Pick-up</th>
                <th>Drop-off</th>
            </tr>
        </thead>
        <tbody id="confirmedRidesBody"></tbody>
    `;
    selectedRidesDiv.appendChild(table);
    let tbody = document.getElementById("confirmedRidesBody");

    // Append ride rows
    confirmedRides.forEach(ride => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${ride.day}</td>
            <td>${ride.date}</td>
            <td>${ride.time}</td>
            <td>${ride.pickup}</td>
            <td>${ride.dropoff}</td>
        `;
        tbody.appendChild(row);
    });

    // Add confirm and cancel buttons
    let buttonContainer = document.createElement("div");
    buttonContainer.style.marginTop = "15px";
    buttonContainer.style.textAlign = "center";

    let finalizeButton = document.createElement("button");
    finalizeButton.innerText = "Finalize Selection";
    finalizeButton.style.marginRight = "10px";
    finalizeButton.addEventListener("click", function () {
        alert("Rides confirmed!");
        selectedRidesDiv.style.display = "none"; // Hide confirmation section
    });

    let goBackButton = document.createElement("button");
    goBackButton.innerText = "Go Back";
    goBackButton.addEventListener("click", function () {
        showSelectedRidesConfirmation(); // Redisplay selection screen
    });

    buttonContainer.appendChild(finalizeButton);
    buttonContainer.appendChild(goBackButton);
    selectedRidesDiv.appendChild(buttonContainer);

    selectedRidesDiv.style.display = "block"; // Ensure it's visible
}

  document.querySelector(".addSelectBtn").addEventListener("click", showSelectedRidesConfirmation);
});
