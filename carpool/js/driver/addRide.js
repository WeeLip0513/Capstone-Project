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
  const slots = document.getElementById("seatNo").value;

  rideDetails.innerHTML = `
  <table>
      <tr>
          <th>Date</th>
          <td>${date}</td>
      </tr>
      <tr>
          <th>Time</th>
          <td>${time}</td>
      </tr>
      <tr>
          <th>Pick-Up</th>
          <td>${pickup}</td>
      </tr>
      <tr>
          <th>Drop-Off</th>
          <td>${dropoff}</td>
      </tr>
      <tr>
          <th>Vehicle</th>
          <td>${vehicle}</td>
      </tr>
      <tr>
          <th>Slots</th>
          <td>${slots}</td>
      </tr>
  </table>`;

  document.getElementById("confirmation").style.display = "flex";

  // Hide other sections without affecting layout shifts
  document.getElementById("addRideContainer").style.display = "none";
  document.getElementById("historyContainer").style.display = "none";

}

// Hide Confirmation Pop-up
function hideConfirmation() {
  document.getElementById("confirmation").style.display = "none";

  // Restore previous sections
  document.getElementById("addRideContainer").style.display = "flex";
  document.getElementById("historyContainer").style.display = "flex";
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

function replaceRide() {
  if (!selectedRideId) {
      alert("Error: No ride ID selected for replacement.");
      return;
  }

  const rideData = {
      ride_id: selectedRideId,
      date: document.getElementById('txtDate').value,
      hour: document.getElementById('hour').value,
      minute: document.getElementById('minute').value,
      pickup: document.getElementById('pickup').value,
      dropoff: document.getElementById('dropoff').value,
      vehicle: document.getElementById('vehicle').value,
      seatNo: document.getElementById('seatNo').value
  };

  console.log("🚀 Sending Replace Ride Request:", rideData);

  fetch('../php/driver/replaceRide.php', {
      method: "POST",
      headers: { "Content-Type": "application/json" }, // Send JSON
      body: JSON.stringify(rideData)
  })
      .then(response => response.text()) // Read as plain text first
      .then(text => {
          console.log("🔍 Raw Response:", text); // Log full response

          try {
              return JSON.parse(text); // Try parsing JSON
          } catch (error) {
              console.error("❌ Invalid JSON. Server Response:", text);
              throw new Error("Server returned invalid JSON.");
          }
      })
      .then(data => {
          console.log("✅ Parsed JSON:", data);
          if (data.status === "success") {
              alert("Ride replaced successfully!");

              // Hide conflict section and show add ride/history containers
              document.getElementById('conflictRides').style.display = "none";
              document.getElementById('addRideContainer').style.display = "flex";
              document.getElementById('historyContainer').style.display = "flex";

              // Clear all form fields
              document.getElementById('addRideForm').reset(); // Reset form if it has id="rideForm"

              // Manually clear dropdown selections if needed
              document.getElementById('txtDate').value = "";
              document.getElementById('hour').value = "";
              document.getElementById('minute').value = "";
              document.getElementById('pickup').selectedIndex = 0;
              document.getElementById('dropoff').selectedIndex = 0;
              document.getElementById('vehicle').selectedIndex = 0;
              document.getElementById('seatNo').value = "";

              document.querySelectorAll('#addRideForm input, #addRideForm select').forEach(field => {
                  field.style.border = "1px solid #ccc"; // Reset to default
              });

          } else {
              alert("Failed to replace ride: " + data.message);
              console.error("❌ Replace Ride Error:", data.message);
          }
      })
      .catch(error => console.error('❌ Fetch Error:', error));
}

document.getElementById('replaceRideBtn').addEventListener('click', replaceRide);

function checkRideConflict() {
  const date = document.getElementById('txtDate').value;
  const hour = document.getElementById('hour').value;
  const minute = document.getElementById('minute').value;
  const pickup = document.getElementById('pickup').value;
  const dropoff = document.getElementById('dropoff').value;

  if (!date || !hour || !minute || !pickup || !dropoff) {
      alert("Please select a date, time, and locations first.");
      return;
  }

  fetch('../php/driver/checkRideConflict.php', {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `date=${date}&hour=${hour}&minute=${minute}`
  })
      .then(response => response.text())  // Read as plain text for debugging
      .then(text => {
          console.log("Raw Response:", text);
          try {
              return JSON.parse(text); // Try parsing JSON
          } catch (error) {
              console.error("Invalid JSON response. Full response:", text);
              throw new Error("Server returned invalid JSON.");
          }
      })
      .then(conflicts => {
          console.log("Parsed JSON:", conflicts);
          const conflictDiv = document.getElementById('conflictRides');
          const conflictBtn = document.getElementById('conflictBtn');
          const addRideContainer = document.getElementById('addRideContainer');
          const historyContainer = document.getElementById('historyContainer');

          if (conflicts.length > 0) {
              selectedRideId = conflicts[0].ride_id; // Store ride_id globally

              let conflictHTML = `
          <h3>Conflicting Ride(s) Found</h3>
          <table border="1">
              <thead>
                  <tr>
                      <th>Type</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Pickup</th>
                      <th>Dropoff</th>
                  </tr>
              </thead>
              <tbody>
                  <tr style="background-color: #f2f2f2;">
                      <td><strong>Your Ride</strong></td>
                      <td>${date}</td>
                      <td>${hour}:${minute}</td>
                      <td>${pickup}</td>
                      <td>${dropoff}</td>
                  </tr>`;

              conflicts.forEach(ride => {
                  conflictHTML += `
                  <tr style="background-color: #ffcccc;">
                      <td><strong>Conflict</strong></td>
                      <td>${ride.ride_date}</td>
                      <td>${ride.ride_time}</td>
                      <td>${ride.pickup}</td>
                      <td>${ride.dropoff}</td>
                  </tr>`;
              });

              conflictHTML += `</tbody></table>`;

              conflictDiv.innerHTML = conflictHTML;
              conflictDiv.appendChild(conflictBtn); // Show buttons

              conflictDiv.style.display = "block";
              addRideContainer.style.display = "none";
              historyContainer.style.display = "none";
          } else {
              showConfirmation();
          }
      })
      .catch(error => console.error('Error:', error));
}

document.getElementById('keepBtn').addEventListener('click', function () {
  // Hide conflict section
  document.getElementById('conflictRides').style.display = "none";
  document.getElementById('addRideContainer').style.display = "flex";
  document.getElementById('historyContainer').style.display = "flex";

  // Reset form fields
  document.getElementById('rideForm').reset(); // Assuming your form has id="rideForm"

  // If some fields are not inside a form, manually clear them:
  document.getElementById('txtDate').value = "";
  document.getElementById('hour').value = "";
  document.getElementById('minute').value = "";
  document.getElementById('pickup').selectedIndex = 0;
  document.getElementById('dropoff').selectedIndex = 0;
  document.getElementById('vehicle').selectedIndex = 0;
  document.getElementById('seatNo').value = "";
});

