let map, directionsService, directionsRenderer, userMarker, watchId;

// Get ride details & drop-off location from PHP
const dropOff = JSON.parse(document.getElementById("dropOffData").textContent);
const rideDetails = JSON.parse(document.getElementById("rideDetailsData").textContent);

window.initMap = function () {
  directionsService = new google.maps.DirectionsService();
  directionsRenderer = new google.maps.DirectionsRenderer({
    suppressMarkers: true,
    polylineOptions: { strokeColor: "#007bff", strokeWeight: 5 }
  });

  map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: { lat: 3.05, lng: 101.69 },
    disableDefaultUI: true,
    mapId: "25e7edf70620c555" // Add your Map ID here
  });

  directionsRenderer.setMap(map);
  addDestinationMarker(dropOff);
  trackUserLocation();
  displayRideDetails();
};


function addDestinationMarker(location) {
  if (!location || !location.lat || !location.lng || !location.name) {
    console.error("Invalid location data:", location);
    return;
  }

  const marker = new google.maps.Marker({
    position: { lat: location.lat, lng: location.lng },
    map: map,
    icon: {
      url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png"
    }
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

function trackUserLocation() {
  if (navigator.geolocation) {
    watchId = navigator.geolocation.watchPosition(
      (position) => {
        if (!position.coords || isNaN(position.coords.latitude) || isNaN(position.coords.longitude)) {
          console.error("Invalid geolocation data:", position.coords);
          return; // Stop execution if invalid
        }

        const userLatLng = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };

        console.log("User location:", userLatLng); // Debugging log

        if (!userMarker) {
          userMarker = new google.maps.Marker({
            position: userLatLng,
            map: map,
            title: "Your Location",
            icon: {
              url: "https://maps.google.com/mapfiles/kml/shapes/cabs.png", // Car icon
              scaledSize: new google.maps.Size(30, 30) // Resize the icon if needed
            }
          });
        } else {
          userMarker.position = userLatLng;
        }

        calculateRoute(userLatLng, dropOff);
      },
      (error) => {
        console.error("Error getting location: " + error.message);
      },
      { enableHighAccuracy: true, maximumAge: 10000, timeout: 5000 }
    );
  } else {
    console.error("Geolocation is not supported by this browser.");
  }
}


// Function to create a custom car icon
function createCarIcon() {
  const carDiv = document.createElement("div");
  carDiv.innerHTML = "🚗"; // You can replace this with an <img> tag if needed
  carDiv.style.fontSize = "32px";
  carDiv.style.position = "absolute";
  return carDiv;
}


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

  detailsDiv.innerHTML = `
    <h2>Ride Details</h2>
    <p>Pick Up Point :<strong> &nbsp&nbsp${rideDetails.pick_up_point}</strong></p>
    <p>Drop Off Point :<strong>  &nbsp&nbsp${rideDetails.drop_off_point}</strong></p>
    <p>Time :<strong>  &nbsp&nbsp${rideDetails.time}</strong></p>
    <p>Passenger:<strong>  &nbsp&nbsp${rideDetails.passenger}</strong></p>
    <button class="reachPickUp" id="reachPickUp">Arrived Pick Up</button>
    <button class="start" id="start" style="display:none;">Start Ride</button>
    <button class="arrived" id="arrived" style="display:none;">Complete</button>
  `;
}
