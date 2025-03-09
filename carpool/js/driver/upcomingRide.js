document.addEventListener("DOMContentLoaded", function () {
  fetchUpcomingRides();
});

let currentPage = 1;
const rowsPerPage = 8;
let ridesData = [];

function fetchUpcomingRides() {
  fetch('../php/driver/getUpcomingRides.php')
    .then(response => response.json())
    .then(data => {
      console.log("🚀 Data received:", data);

      if (!Array.isArray(data)) {
        console.error("❌ Invalid data format:", data);
        return;
      }

      ridesData = data;
      displayPage(1);
    })
    .catch(error => console.error('❌ Error fetching rides:', error));
}

function displayPage(page) {
  currentPage = page;
  const tableContainer = document.getElementById('rideTableContainer');
  const tableBody = document.getElementById('rideTableBody');
  const paginationContainer = document.getElementById('pagination');
  
  tableBody.innerHTML = "";

  if (ridesData.length === 0) {
    tableBody.innerHTML = "<tr><td colspan='7'>No upcoming rides available.</td></tr>";
    return;
  }

  tableContainer.style.display = "block";

  const startIndex = (page - 1) * rowsPerPage;
  const endIndex = startIndex + rowsPerPage;
  const ridesToShow = ridesData.slice(startIndex, endIndex);

  ridesToShow.forEach(ride => {
    const pickupFormatted = formatLocationName(ride.pick_up_point);
    const dropoffFormatted = formatLocationName(ride.drop_off_point);
    const passengerIcons = generatePassengerIcons(ride.slots, ride.slots - ride.slots_available);

    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${ride.day}</td>
      <td>${ride.date}</td>
      <td>${ride.time}</td>
      <td>${pickupFormatted}</td>
      <td>${dropoffFormatted}</td>
      <td>${passengerIcons}</td>
      <td>
          <button class="startBtn" onclick="startRide(${ride.id})">Start</button>
          <button class="cancelBtn" onclick="showCancelWarning(${ride.id})">Cancel</button>
      </td>
    `;
    tableBody.appendChild(row);
  });

  // Fill remaining rows with empty placeholders to ensure 7 rows always
  while (tableBody.rows.length < rowsPerPage) {
    let emptyRow = document.createElement("tr");
    emptyRow.innerHTML = `<td colspan="7">&nbsp;</td>`;
    tableBody.appendChild(emptyRow);
  }

  generatePagination();
}

// Generate Pagination Buttons
function generatePagination() {
  const paginationContainer = document.getElementById('pagination');
  paginationContainer.innerHTML = "";
  
  const totalPages = Math.ceil(ridesData.length / rowsPerPage);
  
  for (let i = 1; i <= totalPages; i++) {
    const button = document.createElement("button");
    button.textContent = i;
    button.classList.add("pagination-btn");
    if (i === currentPage) button.classList.add("active");
    
    button.addEventListener("click", () => displayPage(i));
    paginationContainer.appendChild(button);
  }
}

// Function to format pickup and drop-off locations correctly
function formatLocationName(location) {
  if (!location) return "";

  const specialCases = {
    "pav_bukit_jalil": "Pavilion Bukit Jalil",
    "lrt_bukit_jalil": "LRT Bukit Jalil",
    "sri_petaling": "Sri Petaling",
    "apu": "APU"
  };

  return specialCases[location] || location
    .replace(/_/g, " ")  
    .replace(/\b\w/g, char => char.toUpperCase()); 
}

function generatePassengerIcons(totalSlots, occupiedSlots) {
  let icons = "";

  for (let i = 0; i < totalSlots; i++) {
    icons += `<i class="fa fa-user" style="color: ${i < occupiedSlots ? 'black' : 'lightgray'};"></i> `;
  }

  return icons;
}

function showCancelWarning(rideId) {
  const warningDiv = document.getElementById('warning');
  const tableContainer = document.getElementById('rideTableContainer');

  warningDiv.innerHTML = `
    <div class="warning-content">
      <p>⚠ <strong>Are you sure you want to cancel this ride?</strong></p>
      <p>Your earnings will be deducted by 20% if you cancel more than or equal to three times.</p>
      <button class="confirm-btn" onclick="cancelRide(${rideId})">Confirm</button>
      <button class="cancel-btn" onclick="hideWarning()">Cancel</button>
    </div>
  `;

  warningDiv.style.display = "block";
  tableContainer.style.display = "none";
}

function hideWarning() {
  document.getElementById('warning').style.display = "none";
  document.getElementById('rideTableContainer').style.display = "block";
}

function cancelRide(rideId) {
  hideWarning();

  fetch('cancelRide.php', {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `ride_id=${rideId}`
  })
  .then(response => response.json())
  .then(data => {
    if (data.status === "success") {
      alert("✅ Ride canceled successfully.");
      fetchUpcomingRides();
    } else {
      alert("❌ Failed to cancel ride: " + data.message);
    }
  })
  .catch(error => console.error('❌ Error canceling ride:', error));
}

function startRide(rideId) {
  alert("🚗 Starting ride ID: " + rideId);
}
