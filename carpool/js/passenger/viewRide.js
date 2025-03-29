const dropOff = JSON.parse(document.getElementById("dropOffData").textContent);
const pickUp = JSON.parse(document.getElementById("pickUpData").textContent);

window.initMap = function () {
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer({
    suppressMarkers: true,
    polylineOptions: { strokeColor: "#007bff", strokeWeight: 5 }
  });

  map = new google.maps.Map(document.getElementById("map"), {
    disableDefaultUI: true,
    zoom: 10,
    mapId: "25e7edf70620c555"
  });

  directionsRenderer.setMap(map);

  // Add Pickup & Drop-off Markers
  addMarker(pickUp, "http://maps.google.com/mapfiles/ms/icons/green-dot.png");
  addMarker(dropOff, "http://maps.google.com/mapfiles/ms/icons/blue-dot.png");

  // Adjust map bounds to fit both points
  let bounds = new google.maps.LatLngBounds();
  bounds.extend(new google.maps.LatLng(pickUp.lat, pickUp.lng));
  bounds.extend(new google.maps.LatLng(dropOff.lat, dropOff.lng));

  // Apply padding to ensure both points are clearly visible
  // map.fitBounds(bounds);

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
    <button class="arrived" id="arrived" onclick="handleArrivedClick()">Complete</button>
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
        // alert("Ride Completed Successfully!");
      });
    }
  }, 100); // Small delay to ensure elements exist before attaching listeners
}
window.onload = function () {
  initMap();
  displayRideDetails();
  updateRideStatus(); // Fetch ride status from the backend
};

// Fetch ride status from getRideStatus.php
function updateRideStatus() {
  fetch(`../php/ride/getRideStatus.php?ride_id=${rideID}`)
    .then(response => response.json())
    .then(data => {
      if (!data.status) {
        console.error("Invalid response from server:", data);
        return;
      }

      const rideStatus = data.status; // Example: "reached_pickup", "started", "completed"
      updateUIBasedOnStatus(rideStatus);
      console.log(data.status);
    })
    .catch(error => console.error("Error fetching ride status:", error));
}

// Update UI based on ride status
function updateUIBasedOnStatus(rideStatus) {
  // Define the correct status labels
  const statuses = ["🚙💨 Ride Started", "🚙 Driver Waiting", "🚙💨 On The Way", "🏁 Ride Complete"];

  // Reset all statuses (but keep progress lines colored)
  for (let i = 0; i <= 3; i++) {
    document.getElementById(`status${i}`).style.visibility = "hidden";
  }

  // Determine progress index based on ride status
  let progressIndex = 0;
  switch (rideStatus) {
    case "active":  // Ride Started
      progressIndex = 0;
      break;
    case "waiting":  // Driver Waiting
      progressIndex = 1;
      break;
    case "ongoing":  // On The Way
      progressIndex = 2;
      break;
    case "completed":  // Ride Complete
      progressIndex = 3;
      break;
  }

  // Show only the current status
  document.getElementById(`status${progressIndex}`).style.visibility = "visible";
  document.getElementById(`status${progressIndex}`).innerText = statuses[progressIndex];

  // Keep previous progress lines highlighted
  for (let i = 0; i <= progressIndex; i++) {
    document.getElementById(`progressLine${i}`).style.backgroundColor = "#007bff"; // Active blue color
  }

  // if(rideStatus === "completed"){
  //   document.getElementById("ratingModal").style.display="flex";
  //   document.body.classList.add('no-scroll');
  //   showNotification("Ride Complete! Please rate your ride.");
  // }
}

// Show progress in ride journey
function showProgress(step) {
  const progressBar = document.getElementById("progressBar"); // Assume you have a progress bar
  if (!progressBar) return;

  const progressSteps = ["0%", "33%", "66%", "100%"];
  progressBar.style.width = progressSteps[step];
}

function updateRideStatus() {
  fetch(`../php/ride/getRideStatus.php?ride_id=${rideID}`)
    .then(response => response.json())
    .then(data => {
      if (!data.status) {
        console.error("Invalid response from server:", data);
        return;
      }

      const rideStatus = data.status; // Example: "reached_pickup", "started", "completed"
      updateUIBasedOnStatus(rideStatus);
      
      console.log("Ride Status:", rideStatus);

      // Show rating modal ONLY when the ride is completed
      if (rideStatus === "completed") {
        document.getElementById("ratingModal").style.display = "flex";
        document.body.classList.add('no-scroll');
        showNotification("Ride Complete! Please rate your ride.");
      } else {
        document.getElementById("ratingModal").style.display = "none";
      }
    })
    .catch(error => console.error("Error fetching ride status:", error));
}




