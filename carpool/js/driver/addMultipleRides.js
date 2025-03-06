let selectedRides = [];

function addSelectedRides() {

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
    fetch("../php/driver/addSelectedRide.php", {
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

function getNextWeekDate(dayName) {
  const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
  const today = new Date();
  const currentDayIndex = today.getDay(); // 0 = Sunday, 1 = Monday, etc.
  const targetDayIndex = daysOfWeek.indexOf(dayName);

  if (targetDayIndex === -1) {
    console.error("Invalid day name:", dayName);
    return null;
  }

  let daysToAdd = (targetDayIndex - currentDayIndex + 7) % 7; // Calculate days to next occurrence
  if (daysToAdd === 0) daysToAdd = 7; // Ensure it's next week, not today

  const nextWeekDate = new Date();
  nextWeekDate.setDate(today.getDate() + daysToAdd);

  return nextWeekDate.toISOString().split('T')[0]; // Format: YYYY-MM-DD
}

function showSelectedRidesConfirmation() {
  let selectedRides = [];

  document.querySelectorAll('.rideCheckbox:checked').forEach(checkbox => {
    const rideData = JSON.parse(checkbox.getAttribute('data-ride'));

    selectedRides.push({
      ride_id: rideData.id,
      date: rideData.day.toLowerCase(), // Ensure lowercase (though unnecessary for dates)
      hour: rideData.formatted_time.split(':')[0], // Extract hour
      minute: rideData.formatted_time.split(':')[1], // Extract minute
      pickup: rideData.pick_up_point.toLowerCase(), // Convert pickup point to lowercase
      dropoff: rideData.drop_off_point.toLowerCase() // Convert dropoff point to lowercase
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

  console.log("Checking for conflicts before submission...");

  // ✅ Log the lowercase date(s) being sent to PHP
  console.log("Date(s) being sent to PHP (lowercase):", selectedRides.map(ride => ride.date));
  console.log("Pickup & Dropoff (lowercase):", selectedRides.map(ride => ({ pickup: ride.pickup, dropoff: ride.dropoff })));

  fetch('../php/driver/checkMultipleRideConflicts.php', {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ ride_ids: selectedRides.map(ride => ride.ride_id) })
  })
    .then(response => response.text())
    .then(text => {
      console.log("Raw Conflict Check Response:", text);

      try {
        return JSON.parse(text);
      } catch (error) {
        console.error("Invalid JSON response. Full response:", text);
        throw new Error("Server returned invalid JSON.");
      }
    })
    .then(responseData => {
      if (!responseData || !Array.isArray(responseData.conflicts)) {
        console.error("Invalid response format: Expected an array inside an object, got:", responseData);
        throw new Error("Unexpected server response.");
      }

      const conflicts = responseData.conflicts;

      if (conflicts.length > 0) {
        showConflictingRides(selectedRides, conflicts);
      } else {
        submitSelectedRides(selectedRides.map(ride => ride.ride_id));
      }
    })
    .catch(error => console.error("❌ Error checking ride conflicts:", error));
}

let conflicts = []; // Global conflict storage
let newRidesList = [];

function showConflictingRides(newRides, conflictData) {
  if (!conflictData || conflictData.length === 0) {
    console.error("❌ No conflict data received!");
    return;
  }

  conflicts = conflictData; // ✅ Store conflicts globally
  newRidesList = newRides;  // ✅ Store new rides globally

  const conflictDiv = document.getElementById('conflictRides');

  let conflictHTML = `
      <h3>⚠️ Conflicting Ride(s) Found</h3>
      <p>The following ride(s) already exist. Please select which new ride(s) to replace, or cancel if you don't want to proceed.</p>
      <table border="1">
          <thead>
              <tr>
                  <th>Select</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>Time</th>
                  <th>Pickup</th>
                  <th>Dropoff</th>
              </tr>
          </thead>
          <tbody>`;

  // ✅ Extract conflict ride IDs from PHP response
  const conflictIds = conflictData.map(ride => ride.id); // This should be [53]
  console.log("🚀 Extracted Conflict IDs:", conflictIds);

  // Add existing conflicting rides
  // Display existing conflicting rides
  conflictData.forEach(conflict => {
    conflictHTML += `
        <tr style="background-color: #ffcccc;">
            <td></td> 
            <td><strong>Existing Ride</strong></td>
            <td>${conflict.date}</td> 
            <td>${conflict.time}</td> 
            <td>${conflict.pick_up_point}</td>
            <td>${conflict.drop_off_point}</td>
        </tr>`;

    // Now add a matching new ride row for each conflict
    newRides.forEach(ride => {
      conflictHTML += `
        <tr style="background-color: #d4edda;">
            <td><input type="checkbox" class="replaceCheckbox" value="${conflict.conflict_id}" data-original-ride-id="${conflict.original_ride_id}">"${conflict.conflict_id}"</td>
            <td><strong>New Ride</strong></td>
            <td>${ride.date}</td>
            <td>${ride.hour}:${ride.minute}</td>
            <td>${ride.pickup}</td>
            <td>${ride.dropoff}</td>
        </tr>`;
    });
  });

  conflictHTML += `</tbody></table>
      <button onclick="replaceSelectedRides()">Replace Selected Rides</button>
      <button onclick="cancelConflictCheck()">Cancel</button>`;

  conflictDiv.innerHTML = conflictHTML;
  conflictDiv.style.display = "block";

  document.getElementById("addRideContainer").style.display = "none";
  document.getElementById("historyContainer").style.display = "none";
}

// ✅ Ensure correct selection logic
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".replaceCheckbox").forEach(checkbox => {
    checkbox.addEventListener("change", function () {
      let rideId = parseInt(this.value);

      if (this.checked) {
        if (!selectedRides.includes(rideId)) {
          selectedRides.push(rideId);
        }
      } else {
        selectedRides = selectedRides.filter(id => id !== rideId);
      }

      console.log("Updated Selected Rides:", selectedRides);
    });
  });
});


// ✅ Auto-select the conflicting rides
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".replaceCheckbox").forEach(checkbox => {
    checkbox.addEventListener("change", function () {
      let rideId = parseInt(this.value);

      if (this.checked) {
        if (!selectedRides.includes(rideId)) {
          selectedRides.push(rideId);
        }
      } else {
        selectedRides = selectedRides.filter(id => id !== rideId);
      }

      console.log("Updated Selected Rides:", selectedRides);
    });
  });
});

function replaceSelectedRides() {
  let selectedNewRides = [];
  let replaceRideIds = [];

  console.log("🚀 replaceSelectedRides() triggered!");
  console.log("✅ Stored conflicts:", conflicts);
  console.log("✅ Stored new rides:", newRidesList);

  // ✅ Get all checked checkboxes
  document.querySelectorAll('.replaceCheckbox:checked').forEach(checkbox => {
    const selectedConflictId = checkbox.value; // Get checked conflict ID

    console.log("🟡 Checking for selected conflict_id:", selectedConflictId);

    // ✅ Find the conflicting ride using the selected ID
    const conflictingRide = conflicts.find(conflict => conflict.conflict_id == selectedConflictId);

    if (!conflictingRide) {
      console.error("❌ No matching conflict found for conflict_id:", selectedConflictId);
      return;
    }

    console.log("✅ Matching conflicting ride found:", conflictingRide);

    // ✅ Find the new ride ID that corresponds to this conflict
    const newRideId = conflictingRide.new_ride_id;

    if (!newRideId) {
      console.error("❌ No new ride ID found for conflict_id:", selectedConflictId);
      return;
    }

    console.log("🆕 New Ride ID for conflict:", newRideId);

    // ✅ Get the new ride details using `new_ride_id`
    const newRide = newRidesList.find(r => r.ride_id == newRideId);

    if (newRide) {
      // ✅ Add conflict ID (which will be replaced) and the new ride details
      replaceRideIds.push(selectedConflictId);
      selectedNewRides.push({
        date: newRide.date,
        time: `${newRide.hour}:${newRide.minute}`,
        pickup: newRide.pickup,
        dropoff: newRide.dropoff
      });

      console.log("✅ New ride selected for conflict:", newRide);
    } else {
      console.error("❌ No matching new ride details found for new_ride_id:", newRideId);
    }
  });

  console.log("🔵 Selected Conflict IDs for Replacement:", replaceRideIds);
  console.log("🆕 New Ride Details:", selectedNewRides);

  if (replaceRideIds.length === 0 || selectedNewRides.length === 0) {
    alert("No rides selected for replacement!");
    return;
  }

  // ✅ Send selected conflict IDs and corresponding new ride details to PHP
  fetch('../php/driver/replaceSelectedRides.php', {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ replace_ride_ids: replaceRideIds, new_ride_data: selectedNewRides })
  })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Selected conflicting rides replaced successfully!");
        document.getElementById('conflictRides').style.display = "none";
      } else {
        alert("Error replacing rides: " + data.message);
      }
    })
    .catch(error => console.error("❌ Error replacing rides:", error));
}


function cancelConflictCheck() {
  document.getElementById("conflictRides").style.display = "none";
  document.getElementById("addRideContainer").style.display = "flex";
  document.getElementById("historyContainer").style.display = "flex";
}

// Hide the confirmation modal
function hideSelectedRidesConfirmation() {
  document.getElementById("selectedRidesConfirmation").style.display = "none";

  // Restore previous sections
  document.getElementById("addRideContainer").style.display = "flex";
  document.getElementById("historyContainer").style.display = "flex";
}

// Function to process the selected rides
function submitSelectedRides() {
  let selectedRides = [];

  document.querySelectorAll('.rideCheckbox:checked').forEach(checkbox => {
    const rideData = JSON.parse(checkbox.getAttribute('data-ride'));

    // ✅ Calculate the correct date for next week's ride
    const nextWeekDate = getNextWeekDate(rideData.day);

    // 🚨 Ensure every required field is present
    if (!nextWeekDate || !rideData.day || !rideData.formatted_time ||
      !rideData.pick_up_point || !rideData.drop_off_point ||
      !rideData.slots || !rideData.vehicle_id ||
      !rideData.driver_id || !rideData.price) {

      console.error("❌ Missing required ride details!", rideData);
      return; // Skip this ride if any detail is missing
    }

    selectedRides.push({
      newDate: nextWeekDate, // ✅ Set to next week's date
      day: rideData.day,
      formatted_time: rideData.formatted_time,
      pick_up_point: rideData.pick_up_point,
      drop_off_point: rideData.drop_off_point,
      slots_available: parseInt(rideData.slots, 10),
      slots: parseInt(rideData.slots, 10), // ✅ Ensure slots exist
      vehicle_id: rideData.vehicle_id,
      driver_id: rideData.driver_id,
      price: parseFloat(rideData.price)
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

  console.log("🚀 Submitting Rides:", JSON.stringify(selectedRides, null, 2));

  fetch('../php/driver/addSelectedRide.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ rides: selectedRides }) // ✅ Ensure correct format
  })
    .then(response => response.text())  // Get raw response as text
    .then(text => {
      console.log("🚨 Raw Server Response:", text); // Log full response

      try {
        return JSON.parse(text); // Attempt to parse JSON
      } catch (error) {
        console.error("❌ JSON Parse Error. Server response was:", text);
        throw new Error("Server returned invalid JSON.");
      }
    })
    .then(data => {
      alert("Selected rides created successfully!");
      hideSelectedRidesConfirmation();
    })
    .catch(error => console.error("❌ Error submitting rides:", error));
}

function validateAndCheckConflict() {
  if (!validateRideForm()) {
    return; // Stop if form validation fails
  }

  checkRideConflict(); // This function is async, so we need to handle it properly
}

let selectedRideId = null; // Store ride_id globally

document.querySelectorAll('.rideCheckbox').forEach(checkbox => {
  checkbox.addEventListener('change', function () {
    let selectedCheckboxes = document.querySelectorAll('.rideCheckbox:checked');

    if (selectedCheckboxes.length > 7) {
      alert("You can select a maximum of 7 rides.");
      this.checked = false; // Uncheck the latest selection
    }
  });
});