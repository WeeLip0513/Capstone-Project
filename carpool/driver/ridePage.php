<?php
session_start();
include("../dbconn.php");
include("../userHeader.php");

$ride_id = 118;
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch both pick-up and drop-off points from the database
$sql = "SELECT pick_up_point, drop_off_point FROM ride WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$result = $stmt->get_result();
$ride = $result->fetch_assoc();

if (!$ride) {
  die("Ride not found.");
}

$pick_up_point = $ride['pick_up_point'];
$drop_off_point = $ride['drop_off_point'];

// Predefined locations with lat & lng
$locations = [
  "apu" => ["lat" => 3.0470, "lng" => 101.7009, "name" => "APU University"],
  "lrtbukitjalil" => ["lat" => 3.0597, "lng" => 101.6895, "name" => "LRT Bukit Jalil"],
  "pavilionbukitjalil" => ["lat" => 3.0515, "lng" => 101.6710, "name" => "Pavilion Bukit Jalil"],
  "sripetaling" => ["lat" => 3.0701, "lng" => 101.6951, "name" => "Sri Petaling"]
];

// Convert both points to lat/lng
$pick_up_key = strtolower(str_replace("_", "", $pick_up_point));
$drop_off_key = strtolower(str_replace("_", "", $drop_off_point));

$pick_up = $locations[$pick_up_key] ?? null;
$drop_off = $locations[$drop_off_key] ?? null;

if (!$pick_up || !$drop_off) {
  die("Invalid pick-up or drop-off point.");
}

// Pass PHP values to JavaScript
$pick_up_json = json_encode($pick_up);
$drop_off_json = json_encode($drop_off);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ride Route</title>
  <link rel="stylesheet" href="../css/ridePage/map.css">
  <script>
    let map, directionsService, directionsRenderer;

    // Get PHP data in JavaScript
    const pickUp = <?php echo $pick_up_json; ?>;
    const dropOff = <?php echo $drop_off_json; ?>;

    console.log("Pick-Up Data:", pickUp);
    console.log("Drop-Off Data:", dropOff);

    // Ensure initMap is globally accessible
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
        styles: [
          { featureType: "poi", stylers: [{ visibility: "off" }] },
          { featureType: "transit", stylers: [{ visibility: "off" }] },
          { featureType: "road", elementType: "labels", stylers: [{ visibility: "off" }] }
        ]
      });

      directionsRenderer.setMap(map);
      addPinMarker(pickUp);
      addPinMarker(dropOff);
      calculateRoute(pickUp, dropOff);
    };

    function addPinMarker(location) {
      if (!location || !location.lat || !location.lng || !location.name) {
        console.error("Invalid location data:", location);
        return;
      }

      const marker = new google.maps.Marker({
        position: { lat: location.lat, lng: location.lng },
        map: map,
        icon: {
          url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
        }
      });

      // Create a custom label
      const labelDiv = document.createElement("div");
      labelDiv.style.position = "absolute";
      labelDiv.style.background = "white";
      labelDiv.style.padding = "5px 10px";
      labelDiv.style.borderRadius = "5px";
      labelDiv.style.boxShadow = "0px 2px 6px rgba(0,0,0,0.3)";
      labelDiv.style.fontSize = "14px";
      labelDiv.style.whiteSpace = "nowrap";
      labelDiv.style.fontWeight = "bold";
      labelDiv.style.pointerEvents = "none"; // Prevents interaction issues
      labelDiv.innerText = location.name;

      const overlay = new google.maps.OverlayView();
      overlay.onAdd = function () {
        const layer = this.getPanes().floatPane; // Ensures label is above route
        layer.appendChild(labelDiv);
      };

      overlay.draw = function () {
        const projection = this.getProjection();
        if (!projection) return;
        const position = projection.fromLatLngToDivPixel(marker.getPosition());

        labelDiv.style.left = position.x - labelDiv.offsetWidth / 10 + "px";
        labelDiv.style.top = position.y - 70 + "px"; // Adjust height to avoid pin overlap
      };

      overlay.onRemove = function () {
        if (labelDiv.parentNode) {
          labelDiv.parentNode.removeChild(labelDiv);
        }
      };

      overlay.setMap(map);
    }

    function calculateRoute(origin, destination) {
      const request = {
        origin: new google.maps.LatLng(origin.lat, origin.lng),
        destination: new google.maps.LatLng(destination.lat, destination.lng),
        travelMode: google.maps.TravelMode.DRIVING
      };

      directionsService.route(request, (result, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
          directionsRenderer.setDirections(result);
          
          const bounds = new google.maps.LatLngBounds();
          result.routes[0].legs[0].steps.forEach(step => {
            bounds.extend(step.start_location);
            bounds.extend(step.end_location);
          });
          
          map.fitBounds(bounds);
        } else {
          console.error("Directions request failed: " + status);
        }
      });
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGINGrQ2OWAupvgvS8ZbzO8QtbT8jbFek&callback=initMap"></script>
</head>

<body>
  <div class="content">
    <h2>Route from Pick-up to Drop-off</h2>
  </div>

  <div id="map"></div>
</body>

</html>
