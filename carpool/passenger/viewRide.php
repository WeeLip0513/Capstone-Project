<?php
session_start();
include("../dbconn.php");
include("../rideHeader.php");



$passenger_id = $_GET['passenger_id'];
$_SESSION['passengerID'] = $passenger_id;
$ride_id = $_GET['ride_id'];
$_SESSION['rideID'] = $ride_id;
// echo($_SESSION['rideID']);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch ride details from the database
$sql = "SELECT drop_off_point, pick_up_point, time,slots,slots_available FROM ride WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$result = $stmt->get_result();
$ride = $result->fetch_assoc();

if (!$ride) {
  die("Ride not found.");
}

$drop_off_point = $ride['drop_off_point'];
$pick_up_point = $ride['pick_up_point'];
$time = $ride['time'];
$slots = $ride['slots'];
$slots_available = $ride['slots_available'];

$passengerCount = $slots - $slots_available;

// Predefined locations with lat & lng
$locations = [
  "apu" => ["lat" => 3.05560, "lng" => 101.70069, "name" => "APU University"],
  "lrtbukitjalil" => ["lat" => 3.0593243832900945, "lng" => 101.69242002219941, "name" => "LRT Bukit Jalil"],
  "pavbukitjalil" => ["lat" => 3.0503746741835793, "lng" => 101.6709629957691, "name" => "Pavilion Bukit Jalil"],
  "sripetaling" => ["lat" => 3.068877168730232, "lng" => 101.68697247937381, "name" => "Sri Petaling"]
];

// Convert drop-off point to lat/lng
$drop_off_key = strtolower(str_replace("_", "", $drop_off_point));
$drop_off = $locations[$drop_off_key] ?? null;
$pick_up_key = strtolower(str_replace("_", "", $pick_up_point));
$pick_up = $locations[$pick_up_key] ?? null;

if (!$drop_off) {
  die("Invalid drop-off point.");
}

// Pass PHP values to JavaScript
$drop_off_json = json_encode($drop_off);
$pick_up_json = json_encode($pick_up);
$ride_details_json = json_encode([
  "pick_up_point" => $pick_up['name'],
  "drop_off_point" => $drop_off['name'],
  "time" => $time,
  "passenger" => $passengerCount
]);

// $ride_id = $_GET['ride_id'] ?? null;
$sql = "SELECT COUNT(*) as count 
        FROM passenger_transaction pt
        JOIN ride r ON pt.ride_id = r.id
        WHERE pt.ride_id = ? 
          AND pt.status = 'complete' 
          AND r.status = 'completed'
          AND pt.ride_rating IS NULL";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$result = $stmt->get_result();
$pending_ratings = $result->fetch_assoc()['count'];

$showRatingModal = ($pending_ratings > 0) ? "true" : "false";


// echo($_SESSION["driverID"]);
?>

<script>
  const rideID = <?php echo json_encode($ride_id); ?>;
  console.log(rideID);
</script>

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ride</title>
  <link rel="stylesheet" href="../css/ridePage/viewRide.css">
  <link rel="stylesheet" href="../css/ridePage/rating.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
  <div class="progress-container">
    <div id="progress0" class="progress">
      <div class="status" id="status0" style="visibility:hidden;">status0</div>
      <div class="progressLine" id="progressLine0"></div>
    </div>
    <div id="progress1" class="progress">
      <div class="status" id="status1" style="visibility:hidden;">status1</div>
      <div class="progressLine" id="progressLine1"></div>
    </div>
    <div id="progress2" class="progress">
      <div class="status" id="status2" style="visibility:hidden;">status2</div>
      <div class="progressLine" id="progressLine2"></div>
    </div>
    <div id="progress3" class="progress">
      <div class="status" id="status3" style="visibility:hidden;">status3</div>
      <div class="progressLine" id="progressLine3"></div>
    </div>
  </div>

  <div class="content">
    <div id="map"></div>
    <div class="rideDetails" id="rideDetails"></div>
    <div class="completeMessage" id="completeMessage" style="display:none;">
      <div id="icon" class="icon"></div>

    </div>
  </div>

  <div id="ratingModal" class="rating-modal">
    <div class="rating-modal-content">
      <h3>Rate Your Ride</h3>
      <h4>You have reached your destination</h4>
      <div id="starContainer" class="star-container">
        <span class="star" data-rating="1">★</span>
        <span class="star" data-rating="2">★</span>
        <span class="star" data-rating="3">★</span>
        <span class="star" data-rating="4">★</span>
        <span class="star" data-rating="5">★</span>
      </div>
    </div>
  </div>

  <!-- Pass PHP data to JS -->
  <script id="dropOffData" type="application/json"><?php echo $drop_off_json; ?></script>
  <script id="pickUpData" type="application/json"><?php echo $pick_up_json; ?></script>
  <script id="rideDetailsData" type="application/json"><?php echo $ride_details_json; ?></script>

  <script>
    var showRatingModal = <?php echo json_encode($showRatingModal); ?>;
    var passengerID = <?php echo json_encode($passenger_id); ?>;
    var rideID = <?php echo json_encode($ride_id); ?>;
    console.log("showRatingModal:", showRatingModal, "rideID:", rideID, "passenger ID:", passengerID);
  </script>

  <!-- Load JS first -->
  <!-- <script src="../js/ride/map.js"></script> -->

  <!-- Load Google Maps API after JS -->
  <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGINGrQ2OWAupvgvS8ZbzO8QtbT8jbFek&callback=initMap&libraries=marker&map_ids=25e7edf70620c555"
    async defer></script>

  <script src="../js/passenger/viewRide.js"></script>
  <script src="../js/passenger/rating.js"></script>

  <script>
    const reachPickUpBtn = document.getElementById("reachPickUp");
    const startBtn = document.getElementById("start");
    const arrivedBtn = document.getElementById("arrived");

    reachPickUpBtn.style.visibility = "hidden";
    startBtn.style.visibility = "hidden";
    arrivedBtn.style.visibility = "hidden";
  </script>


</body>

</html>