const dropOff = JSON.parse(document.getElementById("dropOffData").textContent);
const pickUp = JSON.parse(document.getElementById("pickUpData").textContent);

window.initMap = function () {
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer({
    suppressMarkers: true,
    polylineOptions: { strokeColor: "#007bff", strokeWeight: 5 }
  });

  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: { lat: pickUp.lat, lng: pickUp.lng }, // Center map at pickup location
    disableDefaultUI: true,
    mapId: "25e7edf70620c555"
  });

  directionsRenderer.setMap(map);

  // Add Pickup & Drop-off Markers
  addMarker(pickUp, "http://maps.google.com/mapfiles/ms/icons/green-dot.png");
  addMarker(dropOff, "http://maps.google.com/mapfiles/ms/icons/blue-dot.png");

  // Draw route
  calculateRoute(pickUp, dropOff);
};

// Function to add markers
function addMarker(location, iconUrl) {
  if (!location || !location.lat || !location.lng || !location.name) {
    console.error("Invalid location data:", location);
    return;
  }

  const marker = new google.maps.Marker({
    position: { lat: location.lat, lng: location.lng },
    map: map,
    icon: { url: iconUrl }
  });

  const labelDiv = document.createElement("div");
  labelDiv.style.position = "absolute";
  labelDiv.style.background = "white";
  labelDiv.style.padding = "5px 10px";
  labelDiv.style.borderRadius = "5px";
  labelDiv.style.boxShadow = "0px 2px 6px rgba(0,0,0,0.3)";
  labelDiv.style.fontSize = "14px";
  labelDiv.style.whiteSpace = "nowrap";
  labelDiv.style.fontWeight = "bold";
  labelDiv.style.pointerEvents = "none";
  labelDiv.innerText = location.name;

  const overlay = new google.maps.OverlayView();
  overlay.onAdd = function () {
    const layer = this.getPanes().floatPane;
    layer.appendChild(labelDiv);
  };

  overlay.draw = function () {
    const projection = this.getProjection();
    if (!projection) return;
    const position = projection.fromLatLngToDivPixel(marker.getPosition());

    labelDiv.style.left = position.x - labelDiv.offsetWidth / 10 + "px";
    labelDiv.style.top = position.y - 70 + "px";
  };

  overlay.onRemove = function () {
    if (labelDiv.parentNode) {
      labelDiv.parentNode.removeChild(labelDiv);
    }
  };

  overlay.setMap(map);
}

// Function to calculate and show route
function calculateRoute(start, end) {
  if (!start || !start.lat || !start.lng || !end || !end.lat || !end.lng) {
    console.error("Invalid route parameters:", { start, end });
    return;
  }

  const request = {
    origin: start,
    destination: end,
    travelMode: google.maps.TravelMode.DRIVING
  };

  directionsService.route(request, (result, status) => {
    if (status === google.maps.DirectionsStatus.OK) {
      directionsRenderer.setDirections(result);
    } else {
      console.error("Directions request failed:", status);
    }
  });
}

function displayRideDetails() {
  const detailsDiv = document.getElementById("rideDetails");
  if (!detailsDiv) return;

  // Parse ride details
  const rideDetails = JSON.parse(document.getElementById("rideDetailsData").textContent);

  // Update innerHTML
  detailsDiv.innerHTML = `
    <h2>Ride Details</h2>
    <table>
      <tr><th>Pick Up Point</th><td><strong>${rideDetails.pick_up_point}</strong></td></tr>
      <tr><th>Drop Off Point</th><td><strong>${rideDetails.drop_off_point}</strong></td></tr>
      <tr><th>Time</th><td><strong>${rideDetails.time}</strong></td></tr>
      <tr><th>Passenger</th><td><strong>${rideDetails.passenger}</strong></td></tr>
    </table>
    <div class="btnContainer">
    <button class="reachPickUp show" id="reachPickUp" onclick="updateStatus('reachPickUp')">Arrived Pick Up</button>
    <button class="start" id="start" onclick="updateStatus('start')">Start Ride</button>
    <button class="arrived" id="arrived" onclick="updateStatus('arrived')">Complete</button>    
    </div>`;

  // Wait for DOM update before attaching event listeners
  setTimeout(() => {
    const reachPickUpBtn = document.getElementById("reachPickUp");
    const startBtn = document.getElementById("start");
    const arrivedBtn = document.getElementById("arrived");

    if (reachPickUpBtn && startBtn && arrivedBtn) {
      reachPickUpBtn.addEventListener("click", function () {
        this.classList.remove("show");
        startBtn.classList.add("show");
        showProgress(1);
      });

      startBtn.addEventListener("click", function () {
        this.classList.remove("show");
        arrivedBtn.classList.add("show");
        showProgress(2);
      });

      arrivedBtn.addEventListener("click", function () {
        showProgress(3);
        alert("Ride Completed Successfully!");
      });
    }
  }, 100); // Small delay to ensure elements exist before attaching listeners
}

// Ensure function is executed after the page loads
document.addEventListener("DOMContentLoaded", function () {
  displayRideDetails(); // Ensure ride details are displayed

  setTimeout(() => {
    const progress0 = document.getElementById("progress0");
    const reachPickUpBtn = document.getElementById("reachPickUp");

    if (progress0 && reachPickUpBtn) {
      showProgress(0); // Show "Ride Started" progress

      // Ensure "Arrived Pick Up" button is visible initially
      reachPickUpBtn.style.display = "block";
      reachPickUpBtn.style.opacity = "1";
      reachPickUpBtn.style.visibility = "visible";
    } else {
      console.error("❌ Missing elements: 'progress0' or 'reachPickUp'!");
    }
  }, 500); // Delay ensures elements exist before execution
});


function showProgress(index) {
  // Hide all previous status messages first
  document.querySelectorAll(".status").forEach((el) => {
    el.style.visibility = "hidden";
  });

  // Get elements for the current progress
  const progressDiv = document.getElementById(`progress${index}`);
  const statusElement = document.getElementById(`status${index}`);
  const progressLine = document.getElementById(`progressLine${index}`);

  if (!progressDiv || !statusElement || !progressLine) {
    console.error(`Element with ID progress${index} or status${index} or progressLine${index} not found`);
    return;
  }

  // Show the current progress and status
  progressDiv.style.visibility = "visible";
  progressDiv.style.display = "flex";
  statusElement.style.visibility = "visible";

  // Set the status message dynamically
  let statusMessage = "";
  if (index === 0) {
    statusMessage = '🚙💨 Ride Started';
  } else if (index === 1) {
    statusMessage = '🚙 Waiting...';
  } else if (index === 2) {
    statusMessage = '🚙💨 On the Way ~';
  } else if (index === 3) {
    statusMessage = "🏁 Ride Completed";
  }
  statusElement.textContent = statusMessage;

  // Update progress line to blue
  progressLine.style.width = "80%";
  progressLine.style.height = "10px"; // Set progress line height to 10px
  progressLine.style.backgroundColor = "#2b83ff";

  // Reset previous progress lines to gray
  for (let i = 0; i < index; i++) {
    const prevProgressLine = document.getElementById(`progressLine${i}`);
    if (prevProgressLine) {
      prevProgressLine.style.backgroundColor = "gray";
    }
  }

  // Hide all buttons
  document.querySelectorAll(".btnContainer button").forEach((btn) => {
    btn.style.display = "none";
  });

  // Show the correct button based on progress index
  if (index === 0) {
    document.getElementById("reachPickUp").style.display = "block";
  } else if (index === 1) {
    document.getElementById("start").style.display = "block";
  } else if (index === 2) {
    document.getElementById("arrived").style.display = "block";
  }
}

// Modify event listeners
setTimeout(() => {
  document.getElementById("reachPickUp").addEventListener("click", function () {
    showProgress(1); // Move to "Heading to Pick Up"
  });

  document.getElementById("start").addEventListener("click", function () {
    showProgress(2); // Move to "Heading to Destination"
  });

  document.getElementById("arrived").addEventListener("click", function () {
    showProgress(3); // Move to "Ride Completed"
    alert("Ride Completed Successfully!");
  });
}, 0);

window.onload = function () {
  showProgress(0); // Show "Ride Started" progress

  // Ensure "Arrived Pick Up" button is visible initially
  document.getElementById("reachPickUp").style.display = "block";
  document.getElementById("reachPickUp").style.opacity = "1";
  document.getElementById("reachPickUp").style.visibility = "visible";
};


function updateStatus(buttonID) {
  let status;

  if (buttonID === "reachPickUp") {
    status = "waiting";
  } else if (buttonID === "start") {
    status = "ongoing";
  } else if (buttonID === "arrived") {
    status = "completed";
  } else {
    console.error("Invalid button ID:", buttonID);
    return;
  }

  // Send AJAX request to updateStatus.php
  fetch("../php/ride/updateStatus.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `status=${encodeURIComponent(status)}`,
  })
    .then((response) => response.text())
    .then((data) => {
      console.log("Server Response:", data);
    })
    .catch((error) => {
      console.error("Error updating status:", error);
    });
}
