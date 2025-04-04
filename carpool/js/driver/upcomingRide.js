document.addEventListener("DOMContentLoaded", function () {
  fetchUpcomingRides();
});

let currentPage = 1;
const rowsPerPage = 10;
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

  const today = new Date().toISOString().split("T")[0]; // Get today's date in YYYY-MM-DD format

  ridesToShow.forEach(ride => {
    const pickupFormatted = formatLocationName(ride.pick_up_point);
    const dropoffFormatted = formatLocationName(ride.drop_off_point);
    const occupiedSlots = ride.slots - ride.slots_available;
    const passengerIcons = generatePassengerIcons(ride.slots, occupiedSlots);

    const row = document.createElement("tr");

    // Check if the ride's date matches today
    const isToday = ride.date === today;

    let actionButtons = `<button class="cancelBtn" onclick="showCancelWarning(${ride.id}, ${occupiedSlots})">Cancel</button>`;

    // Only show "Start" button if it's today and there is at least one passenger
    if (isToday && occupiedSlots > 0) {
      actionButtons = `
        <button class="startBtn" onclick="startRide(${ride.id})">Start</button>
        ` + actionButtons;
    }

    row.innerHTML = `
      <td>${ride.day}</td>
      <td>${ride.date}</td>
      <td>${ride.time}</td>
      <td>${pickupFormatted}</td>
      <td>${dropoffFormatted}</td>
      <td>${passengerIcons}</td>
      <td>${actionButtons}</td>
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



// Generate Pagination with Dots Only
function generatePagination() {
  const paginationContainer = document.getElementById('pagination');
  paginationContainer.innerHTML = "";

  const totalPages = Math.ceil(ridesData.length / rowsPerPage);

  if (totalPages <= 1) {
    return; // No pagination needed if only one page
  }

  // Display dots-based pagination logic
  if (totalPages <= 5) {
    // If there are 5 or fewer pages, show each page as a dot
    for (let i = 1; i <= totalPages; i++) {
      const pageDot = document.createElement("button");
      pageDot.textContent = "•";
      pageDot.classList.add("pagination-dot");
      pageDot.disabled = i === currentPage;
      pageDot.addEventListener("click", () => displayPage(i));
      paginationContainer.appendChild(pageDot);
    }
  } else {
    // More than 5 pages: Use dots for range navigation
    if (currentPage <= 3) {
      // Show first 3 dots, then 3 dots at the end
      for (let i = 1; i <= 3; i++) {
        const pageDot = document.createElement("button");
        pageDot.textContent = "•";
        pageDot.classList.add("pagination-dot");
        pageDot.disabled = i === currentPage;
        pageDot.addEventListener("click", () => displayPage(i));
        paginationContainer.appendChild(pageDot);
      }
      const dots = document.createElement("span");
      dots.textContent = "...";
      dots.classList.add("pagination-dot");
      paginationContainer.appendChild(dots);
      const lastPageDot = document.createElement("button");
      lastPageDot.textContent = "•";
      lastPageDot.classList.add("pagination-dot");
      lastPageDot.addEventListener("click", () => displayPage(totalPages));
      paginationContainer.appendChild(lastPageDot);
    } else if (currentPage >= totalPages - 2) {
      // Show first dot, then 3 dots at the beginning and the last 3 dots
      const firstPageDot = document.createElement("button");
      firstPageDot.textContent = "•";
      firstPageDot.classList.add("pagination-dot");
      firstPageDot.addEventListener("click", () => displayPage(1));
      paginationContainer.appendChild(firstPageDot);

      const dots = document.createElement("span");
      dots.textContent = "...";
      dots.classList.add("pagination-dot");
      paginationContainer.appendChild(dots);

      for (let i = totalPages - 2; i <= totalPages; i++) {
        const pageDot = document.createElement("button");
        pageDot.textContent = "•";
        pageDot.classList.add("pagination-dot");
        pageDot.disabled = i === currentPage;
        pageDot.addEventListener("click", () => displayPage(i));
        paginationContainer.appendChild(pageDot);
      }
    } else {
      // Show first dot, 3 dots in the middle range, and last dot
      const firstPageDot = document.createElement("button");
      firstPageDot.textContent = "•";
      firstPageDot.classList.add("pagination-dot");
      firstPageDot.addEventListener("click", () => displayPage(1));
      paginationContainer.appendChild(firstPageDot);

      const dots = document.createElement("span");
      dots.textContent = "...";
      dots.classList.add("pagination-dot");
      paginationContainer.appendChild(dots);

      for (let i = currentPage - 1; i <= currentPage + 1; i++) {
        const pageDot = document.createElement("button");
        pageDot.textContent = "•";
        pageDot.classList.add("pagination-dot");
        pageDot.disabled = i === currentPage;
        pageDot.addEventListener("click", () => displayPage(i));
        paginationContainer.appendChild(pageDot);
      }

      const lastDots = document.createElement("span");
      lastDots.textContent = "...";
      lastDots.classList.add("pagination-dot");
      paginationContainer.appendChild(lastDots);

      const lastPageDot = document.createElement("button");
      lastPageDot.textContent = "•";
      lastPageDot.classList.add("pagination-dot");
      lastPageDot.addEventListener("click", () => displayPage(totalPages));
      paginationContainer.appendChild(lastPageDot);
    }
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
    icons += `<i class="fa fa-user" style="color: ${i < occupiedSlots ? '#2b83ff' : 'lightgray'};"></i> `;
  }

  return icons;
}

function showCancelWarning(rideId, passengerCount) {
  const warningDiv = document.getElementById('warningContainer');
  const tableContainer = document.getElementById('rideTableContainer');

  let warningContent = `
    <h1>⚠ Warning ⚠</h1>
    <p>If you cancel more than or equal to <span style="color: red; font-weight: bold;">THREE TIMES</span><br>
    Your earnings will be deducted by <span style="color: red; font-weight: bold;">20%</span></p>
    <p><strong>Are you sure you want to <span style="color: red; font-weight: bold;">CANCEL</span> this ride?</strong></p>
  `;

  let confirmFunction = `cancelWithPenalty(${rideId},'${stripeSessionId}')`;

  // If there are no passengers, show a simpler warning and change the function
  if (passengerCount === 0) {
    warningContent = `
      <h1>⚠ Warning ⚠</h1>
      <p><strong>Are you sure you want to <span style="color: red; font-weight: bold;">CANCEL</span> this ride?</strong></p>
    `;
    confirmFunction = `cancelWithoutPenalty(${rideId})`;
  }

  warningDiv.innerHTML = `
    <div class="warning-content">
      ${warningContent}
      <button class="confirm-btn" onclick="${confirmFunction}">Confirm</button>
      <button class="back-btn" onclick="hideWarning()">Back</button>
    </div>
  `;

  warningDiv.style.display = "flex";
  tableContainer.style.display = "none";
}


function hideWarning() {
  document.getElementById('warningContainer').style.display = "none";
  document.getElementById('rideTableContainer').style.display = "block";
}

function cancelWithPenalty(rideId, stripeSessionId) {
  console.log("Canceling: ", rideId);
  hideWarning();

  fetch('../php/driver/cancelRideWithPenalty.php', {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `ride_id=${rideId}&penalty=true`
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        if (stripeSessionId) {
          return processRefund(stripeSessionId).then(() => data);
        }
        return data;
      } else {
        throw new Error("Cancellation failed: " + data.message);
      }
    })
    .then(data => {
      alert("✅ Ride canceled successfully" + (stripeSessionId ? " and refund processed." : "."));
      fetchUpcomingRides();
    })
    .catch(error => {
      console.error("❌ Error in cancellation process:", error);
      alert("❌ " + error.message);
    });
}

function cancelWithoutPenalty(rideId) {
  console.log("Canceling without penalty: ", rideId)
  hideWarning();

  fetch('../php/driver/cancelRide.php', {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `ride_id=${rideId}&penalty=false`
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        alert("✅ Ride canceled successfully.");
        return fetch(`../php/passenger/paymentRefund.php?session_id=${encodeURIComponent(stripeSessionId)}`);
      } else {
        throw new Error("Cancellation failed: " + data.message);
      }
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        console.log("Refund processed successfully.");
        fetchUpcomingRides();
      } else {
        alert("❌ Failed to process refund: " + data.message);
      }
    })
    .catch(error => console.error('❌ Error in cancellation process:', error));
}


function startRide(rideId) {
  const ride = ridesData.find(r => r.id === rideId);
  if (!ride) {
    alert("❌ Ride not found.");
    return;
  }

  console.log("🚗 Ride Object:", ride);  // Log entire ride object for debugging

  if (!ride.time || !ride.time.includes(":")) {
    console.error("❌ Invalid ride time format:", ride.time);
    alert("❌ Ride time is not in the correct format.");
    return;
  }

  // Check if the ride time is in 12-hour format and convert it to 24-hour format
  let [rideHour, rideMinute] = ride.time.split(":").map(num => parseInt(num, 10));

  // Handle if hour is a single digit, assuming it's in 12-hour format and AM
  if (rideHour < 10) {
    rideHour += 12;  // Convert single digit hour (e.g., 1 -> 13)
  }

  if (isNaN(rideHour) || isNaN(rideMinute)) {
    console.error("❌ Failed to parse ride time:", ride.time);
    alert("❌ Could not understand ride time.");
    return;
  }

  const now = new Date();
  const currentHour = now.getHours();
  const currentMinute = now.getMinutes();

  const rideTimeInMinutes = rideHour * 60 + rideMinute;
  const currentTimeInMinutes = currentHour * 60 + currentMinute;

  // console.log(`🕒 Current Time: ${currentHour}:${currentMinute} (${currentTimeInMinutes} minutes)`);
  // console.log(`🚗 Ride Time: ${rideHour}:${rideMinute} (${rideTimeInMinutes} minutes)`);
  // console.log(`⌛ Time Difference: ${rideTimeInMinutes - currentTimeInMinutes} minutes`);

  if (currentTimeInMinutes < rideTimeInMinutes - 30) {
    alert("⏳ You can only start the ride within 30 minutes of the scheduled time.");
    return;
  }

  fetch('../php/driver/startRide.php', {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `ride_id=${rideId}`
  })
    .then(response => response.json())
    .then(data => {
      if (data.status === "success") {
        window.location.href = `ridePage.php?ride_id=${rideId}`;
      } else {
        alert("❌ Failed to start ride: " + data.message);
      }
    })
    .catch(error => console.error('❌ Error starting ride:', error));
}


function processRefund(stripeSessionId) {
  if (!stripeSessionId) {
    console.log("DEBUG: No Stripe session ID provided; skipping refund.");
    return Promise.resolve(null);
  }
  const refundUrl = `../php/passenger/paymentRefund.php?session_id=${encodeURIComponent(stripeSessionId)}`;
  console.log("DEBUG: Calling refund endpoint at:", refundUrl);
  return fetch(refundUrl, {
    method: "GET",
    headers: { "Content-Type": "application/x-www-form-urlencoded" }
  })
    .then(response => {
      console.log("DEBUG: Refund endpoint response received.");
      return response.json();
    })
    .then(data => {
      console.log("DEBUG: Response from paymentRefund:", data);
      if (data.success) {
        console.log("DEBUG: Refund processed successfully.");
        return data;
      } else {
        console.log("Successfully requested refund. The refund amount will be credited into your account in 3 to 5 working days.");
        return data;
      }
    });
}





