document.addEventListener("DOMContentLoaded", function () {
  const selectedRidesDiv = document.getElementById("selectedRidesConfirmation");
  let conflictMap = {}; // Object to store ride conflicts
  let rideConflicts = {};

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

    console.log(selectedRides);

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
  
      const text = await response.text(); // Read raw response
      console.log("Raw Response:", text); // ✅ Log full response
  
      try {
        const data = JSON.parse(text); // Try parsing JSON
        console.log("Parsed JSON:", data);
        rideConflicts = data;
        buildConflictMap(data);
        displayRides(data);
      } catch (jsonError) {
        console.error("Invalid JSON response. Raw output:", text);
      }
  
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

  // Function to format specific locations
  function formatLocation(location) {
    let locationMap = {
      "apu": "APU",
      "lrt_bukit_jalil": "LRT Bukit Jalil",
      "pav_bukit_jalil": "Pavilion Bukit Jalil",
      "sri_petaling": "Sri Petaling"
    };
    return locationMap[location.toLowerCase()] || location;
  }

  // Display selected rides in a table with checkboxes
  function displayRides(data) {
    selectedRidesDiv.innerHTML = ""; // Clear previous content

    // Add heading
    let heading = document.createElement("h2");
    heading.innerText = "Select Rides to Replace and Create";
    heading.style.textAlign = "center";
    heading.style.marginBottom = "5px";
    selectedRidesDiv.appendChild(heading);

    let description = document.createElement("p");
    description.innerText = "* Rides Show in RED are CONFLICTED RIDES *"
    description.style.textAlign = "center";
    description.style.marginBottom = "15px";
    selectedRidesDiv.appendChild(description);

    let table = document.createElement("table");
    table.style.width = "100%";
    table.innerHTML = `
          <thead>
              <tr>
                  <th></th>
                  <th>Day</th>
                  <th>Time</th>
                  <th>Pick Up Point</th>
                  <th>Drop Off Point</th>
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
    confirmButton.innerText = "Confirm";
    confirmButton.className = "confirmSelectionBtn"; // Added class
    confirmButton.style.marginRight = "10px";
    confirmButton.addEventListener("click", confirmSelection);
    
    // Cancel selection button
    let cancelButton = document.createElement("button");
    cancelButton.innerText = "Cancel";
    cancelButton.className = "cancelSelectionBtn"; // Added class
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

    if (confirmRideIds.length === 0) {
        alert("Please select at least one ride before confirming.");
        return;
    }

    console.log("Confirmed Ride IDs:", confirmRideIds);
    // alert("Rides confirmed!");
    displayConfirmedRides(confirmRideIds);
}


  function cancelSelection() {
    selectedRidesDiv.style.display = "none";
    document.getElementById("addRideContainer").style.display = "flex";
    document.getElementById("historyContainer").style.display = "flex";
  }

  // Create a row for a ride entry
  function createRideRow(ride, isConflict) {
    let row = document.createElement("tr");
    let rideId = isConflict ? ride.conflict_id : ride.original_ride_id;
    let rideDate = ride.original_date || ride.date;
    let rideTime = ride.original_time || ride.time;
    let dayOfWeek = getDayOfWeek(rideDate);
    let formattedPickup = formatLocation(ride.pick_up_point);
    let formattedDropoff = formatLocation(ride.drop_off_point);

    if (isConflict) {
        row.style.setProperty("background-color", "#ffcccc", "important"); // Light red for conflicts
        row.style.setProperty("color","red");
    } else {
        row.style.setProperty("background-color", "#ffffff", "important"); // Ensure non-conflict rides are white
        row.style.setProperty("color","#2b83ff");
    }

    row.innerHTML = `
        <td>
            <input type="checkbox" class="cRideCheckbox" id="checkbox_${rideId}" value="${rideId}" data-ride='${JSON.stringify(ride)}'>
            <label for="checkbox_${rideId}"></label>
        </td>
        <td>${dayOfWeek}</td>
        <td>${rideTime}</td>
        <td>${formattedPickup}</td>
        <td>${formattedDropoff}</td>
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
    function getNextWeekDate(weekdayName) {
        const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        let today = new Date();
        let todayIndex = today.getDay();
        let targetIndex = daysOfWeek.indexOf(weekdayName);

        if (targetIndex === -1) {
            console.error("Invalid weekday:", weekdayName);
            return null;
        }

        let daysUntilNext = (targetIndex - todayIndex + 7) % 7;
        let nextDate = new Date();
        nextDate.setDate(today.getDate() + daysUntilNext + 7);

        return {
            fullDate: nextDate.toISOString().split("T")[0],
            weekday: daysOfWeek[nextDate.getDay()]
        };
    }

    let conflictMap = new Map();
    rideConflicts.conflicts.forEach(conflict => {
        conflictMap.set(String(conflict.conflict_id), conflict.date);
        conflictMap.set(String(conflict.original_ride_id), conflict.date);
    });

    let confirmedRides = confirmRideIds.map(id => {
        let checkbox = document.querySelector(`#checkbox_${id}`);
        if (checkbox) {
            let row = checkbox.closest("tr");
            if (row) {
                let originalDay = row.cells[1].textContent.trim();
                let nextWeekDateInfo = getNextWeekDate(originalDay);

                let rideDate = conflictMap.has(String(id)) ? conflictMap.get(String(id)) : nextWeekDateInfo.fullDate;
                let rideDay = conflictMap.has(String(id)) ? new Date(rideDate).toLocaleDateString('en-US', { weekday: 'long' }) : nextWeekDateInfo.weekday;

                return {
                    day: rideDay,
                    date: rideDate,
                    time: row.cells[2].textContent,
                    pickup: row.cells[3].textContent,
                    dropoff: row.cells[4].textContent
                };
            }
        }
        return null;
    }).filter(ride => ride !== null);

    selectedRidesDiv.innerHTML = "";

    // Add Final Confirmation Heading
    let heading = document.createElement("h2");
    heading.innerText = "Final Confirmation";
    heading.style.textAlign = "center";
    heading.style.marginBottom = "10px";
    selectedRidesDiv.appendChild(heading);

    let table = document.createElement("table");
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

    confirmedRides.forEach(ride => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${ride.day}</td>
            <td>${ride.date}</td>
            <td>${ride.time}</td>
            <td>${ride.pickup}</td>
            <td>${ride.dropoff}</td>
        `;
        row.style.setProperty("background-color","white");
        row.style.setProperty("color","#2b83ff");
        tbody.appendChild(row);
    });

    let buttonContainer = document.createElement("div");
    buttonContainer.style.marginTop = "15px";
    buttonContainer.style.textAlign = "center";

    let finalizeButton = document.createElement("button");
    finalizeButton.innerText = "Confirm";
    finalizeButton.style.marginRight = "10px";
    finalizeButton.className = "finalizeBtn";
    finalizeButton.addEventListener("click", finalizeRides);

    let goBackButton = document.createElement("button");
    goBackButton.innerText = "Go Back";
    goBackButton.className = "backBtn";
    goBackButton.addEventListener("click", function () {
        showSelectedRidesConfirmation();
        document.getElementById("addRideContainer").style.display = "flex";
        document.getElementById("historyContainer").style.display = "flex";
    });

    buttonContainer.appendChild(finalizeButton);
    buttonContainer.appendChild(goBackButton);
    selectedRidesDiv.appendChild(buttonContainer);

    selectedRidesDiv.style.display = "block";
    document.getElementById("addRideContainer").style.display = "none";
    document.getElementById("historyContainer").style.display = "none";
}



  async function finalizeRides() {
    if (!rideConflicts || (!rideConflicts.original_rides?.length && !rideConflicts.conflicts?.length)) {
      alert("No rides available for finalization.");
      return;
    }

    if (!confirmRideIds || confirmRideIds.length === 0) {
      alert("No confirmed rides selected.");
      return;
    }

    let confirmedIds = confirmRideIds.map(id => parseInt(id, 10));

    function addTwoWeeks(dateStr) {
      let date = new Date(dateStr);
      date.setDate(date.getDate() + 14);
      return date.toISOString().split("T")[0];
    }

    let conflictRideIds = (rideConflicts.conflicts || []).map(ride => parseInt(ride.original_ride_id, 10));

    let nonConflictRides = (rideConflicts.original_rides || [])
      .filter(ride => confirmedIds.includes(parseInt(ride.original_ride_id, 10)) && !conflictRideIds.includes(parseInt(ride.original_ride_id, 10)))
      .map(ride => ({
        ride_id: parseInt(ride.original_ride_id, 10),
        date: addTwoWeeks(ride.original_date),
        time: ride.original_time,
        pickup: ride.pick_up_point,
        dropoff: ride.drop_off_point,
        vehicle_id: parseInt(ride.vehicle_id, 10),
        driver_id: parseInt(ride.driver_id, 10),
        slots: parseInt(ride.slots, 10)
      }));

    let conflictRides = rideConflicts.conflicts
      .filter(ride =>
        confirmedIds.includes(parseInt(ride.conflict_id, 10)) ||
        confirmedIds.includes(parseInt(ride.original_ride_id, 10))
      )
      .map(ride => {
        // Find the original ride details using original_ride_id
        let originalRide = rideConflicts.original_rides.find(r =>
          parseInt(r.original_ride_id, 10) === parseInt(ride.original_ride_id, 10)
        );

        // Function to check if a date is within the previous week (Sunday to Saturday)
        function isFromPreviousWeek(dateStr) {
          let rideDate = new Date(dateStr);
          let today = new Date();

          // Get the start (Sunday) and end (Saturday) of the previous week
          let lastSunday = new Date(today);
          lastSunday.setDate(today.getDate() - today.getDay() - 7); // Move back to last week's Sunday
          lastSunday.setHours(0, 0, 0, 0); // Reset time

          let lastSaturday = new Date(lastSunday);
          lastSaturday.setDate(lastSunday.getDate() + 6); // Get last week's Saturday
          lastSaturday.setHours(23, 59, 59, 999);

          return rideDate >= lastSunday && rideDate <= lastSaturday; // Check if the ride date is within last week
        }

        return {
          ride_id: parseInt(ride.conflict_id, 10), // Keep conflict ride_id the same
          date: originalRide && isFromPreviousWeek(originalRide.original_date)
            ? addTwoWeeks(originalRide.original_date)
            : ride.date, // Only add two weeks if it's within last week
          time: originalRide ? originalRide.original_time : ride.time,
          pickup: originalRide ? originalRide.pick_up_point : ride.pick_up_point,
          dropoff: originalRide ? originalRide.drop_off_point : ride.drop_off_point,
          vehicle_id: originalRide ? parseInt(originalRide.vehicle_id, 10) : parseInt(ride.vehicle_id, 10),
          driver_id: originalRide ? parseInt(originalRide.driver_id, 10) : parseInt(ride.driver_id, 10),
          slots: originalRide ? parseInt(originalRide.slots, 10) : parseInt(ride.slots, 10)
        };
      });



    console.log("Filtered Non-Conflict Rides:", JSON.stringify(nonConflictRides, null, 2));
    console.log("Filtered Conflict Rides:", JSON.stringify(conflictRides, null, 2));

    try {
      if (nonConflictRides.length > 0) {
        let response = await fetch("../php/driver/addNonConflictRides.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ rides: nonConflictRides })
        });
        let result = await response.json();
        console.log("Non-Conflict Rides Finalized:", result);
      }

      if (conflictRides.length > 0) {
        let response = await fetch("../php/driver/replaceConflictedRides.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ rides: conflictRides })
        });
        let result = await response.json();
        console.log("Conflict Rides Finalized:", result);
      }

      alert("Rides finalized successfully!");
      location.reload();
    } catch (error) {
      console.error("Error finalizing rides:", error);
      alert("An error occurred while finalizing rides.");
    }
  }

  document.querySelector(".addSelectBtn").addEventListener("click", showSelectedRidesConfirmation);
});
