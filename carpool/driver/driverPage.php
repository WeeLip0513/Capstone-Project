<?php
session_start();
include("../dbconn.php");
include("../userHeader.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$_SESSION['id'] = 11;
$userID = $_SESSION['id'];

$query = "SELECT * FROM driver WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $userID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
  $driver = mysqli_fetch_assoc($result);
  // echo "<pre>";
  // print_r($driver); // Debugging: Print driver details
  // echo "</pre>";
  $frontImgPath = $driver['license_photo_front'];
  $backImgPath = $driver['license_photo_back'];
  $frontLicensePath = str_replace("../../../", "../", $frontImgPath);
  $backLicensePath = str_replace("../../../", "../", $backImgPath);

  // echo $frontLicensePath;
  // echo $backLicensePath;

  $driverID = $driver['id'];
  $_SESSION['driverID'] = $driverID;
  // echo $_SESSION['driverID'];
} else {
  echo "No driver record found!";
}

// Set Malaysia Timezone
date_default_timezone_set('Asia/Kuala_Lumpur');

// Get today's date and the start of next week (next Sunday)
$today = date('Y-m-d');
$startOfNextWeek = date('Y-m-d', strtotime('next sunday'));
$currentTime = date('H:i'); // Current time in 24-hour format

// Cancel rides that are 30+ minutes past their time
$update_sql = "UPDATE ride 
               SET status = 'canceled' 
               WHERE driver_id = ? 
               AND status = 'upcoming' 
               AND TIMESTAMPDIFF(MINUTE, CONCAT(date, ' ', time), NOW()) > 30";

$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("i", $_SESSION['driverID']);
$update_stmt->execute();

// Get the number of affected rows (canceled rides count)
$canceled_rides = $update_stmt->affected_rows;

$update_stmt->close();

// Step 2: Get the current cancel count and status
$check_sql = "SELECT cancel_count, status FROM driver WHERE id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $driverID);
$check_stmt->execute();
$result = $check_stmt->get_result();
$driver = $result->fetch_assoc();
$check_stmt->close();

if ($canceled_rides > 0) {
  // Step 3: Increment cancel_count
  $update_driver_sql = "UPDATE driver 
                          SET cancel_count = cancel_count + ? 
                          WHERE id = ?";

  $update_driver_stmt = $conn->prepare($update_driver_sql);
  $update_driver_stmt->bind_param("ii", $canceled_rides, $driverID);
  $update_driver_stmt->execute();
  $update_driver_stmt->close();

  // Step 4: Apply penalty only if cancel_count was previously less than 3
  if ($driver && $driver['cancel_count'] < 3) {
    // Now check the updated count
    $check_sql = "SELECT cancel_count FROM driver WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $driverID);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    $updated_driver = $result->fetch_assoc();
    $check_stmt->close();

    if ($updated_driver && $updated_driver['cancel_count'] >= 3) {
      // Step 5: Restrict the driver and set penalty_end_date
      $penalty_end_date = date('Y-m-d', strtotime('+1 month'));
      $restrict_sql = "UPDATE driver 
                             SET status = 'restricted', penalty_end_date = ? 
                             WHERE id = ?";

      $restrict_stmt = $conn->prepare($restrict_sql);
      $restrict_stmt->bind_param("si", $penalty_end_date, $driverID);
      $restrict_stmt->execute();
      $restrict_stmt->close();

      echo "<script>
            alert('⚠️ WARNING: Your status has been changed to RESTRICTED due to too many RIDE CANCELLATIONS!');
        </script>";

    }
  }
}

// Output response
// echo json_encode([
//   "canceled_rides" => $canceled_rides,
//   "current_time" => $currentTime
// ]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver</title>
  <link rel="stylesheet" href="../css/driverPage/driverPage.css" />
  <link rel="stylesheet" href="../css/driverPage/addRide.css">
  <link rel="stylesheet" href="../css/driverPage/upcomingRides.css">
  <link rel="stylesheet" href="../css/driverPage/addHistoryRides.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <!-- <script src="js/driver/addRideValidation.js"></script> -->
  <!-- <script src="js/driver/confirmationPopUp.js"></script> -->
  <script src="../js/driver/driverPage.js" defer></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Bungee+Tint&family=Edu+VIC+WA+NT+Beginner:wght@400..700&family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">
</head>

<body>
  <!-- Hamburger Icon (Outside Features Menu) -->
  <button class="hamburger" id="hamburger">
    <div></div>
    <div></div>
    <div></div>
  </button>

  <!-- Features Menu -->
  <div class="features" id="featuresMenu">
    <button id="recentActivities" class="featureBtn active" data-content="activityContent">
      Upcoming Rides
    </button>
    <button id="addRides" class="featureBtn" data-content="rideContent">
      Add Rides
    </button>
    <button id="earnings" class="featureBtn" data-content="earningsContent">
      Earnings
    </button>
    <button id="history" class="featureBtn" data-content="historyContent">
      Rides History
    </button>
    <button id="profile" class="featureBtn" data-content="profileContent">
      Profile
    </button>
  </div>

  <div class="contents">
    <div class="activityContent">
      <div class="upcomingHeader">
        Start Your Ride !
      </div>
      <div id="rideTableContainer" class="rideTableContainer">
        <table>
          <thead>
            <tr>
              <th>Day</th>
              <th>Date</th>
              <th>Time</th>
              <th>Pick Up Point</th>
              <th>Drop Off Point</th>
              <th>Passengers</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="rideTableBody"></tbody>
        </table>
        <div id="pagination" class="pagination"></div>
      </div>
      <div class="warningContainer" id="warningContainer" style="display:none;">
      </div>
    </div>
    <div class="rideContent" style="display: none;">
      <div class="addRides" id="addRideContainer" style="display: flex;">
        <h1>Create Rides Now !</h1><br>
        <form id="addRideForm" method="POST" action="../php/driver/addRideProcess.php" novalidate>
          <table class="addRidesTable">
            <tr>
              <td>
                <h2>Date</h2>
              </td>
              <td class="input-container">
                <input type="date" name="txtDate" id="txtDate">
                <span class="error" id="txtDateError"></span>
              </td>
            </tr>
            <tr>
              <td>
                <h2>Time</h2>
              </td>
              <td>
                <div class="time-container">
                  <select name="hour" id="hour" required>
                    <option value="">HH</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                  </select>
                  <select name="minute" id="minute" required>
                    <option value="">MM</option>
                    <option value="00">00</option>
                    <option value="05">05</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                    <option value="25">25</option>
                    <option value="30">30</option>
                    <option value="35">35</option>
                    <option value="40">40</option>
                    <option value="45">45</option>
                    <option value="50">50</option>
                    <option value="55">55</option>
                  </select>
                </div>
                <span class="error" id="timeError"></span>
              </td>
            </tr>
            <tr>
              <td>
                <h2>Pick-Up Point</h2>
              </td>
              <td class="input-container">
                <select name="pickup" id="pickup" required>
                  <option value="">Select Pick-Up Point</option>
                  <option value="apu">APU</option>
                  <option value="lrt_bukit_jalil">LRT Bukit Jalil</option>
                  <option value="pav_bukit_jalil">Pavilion Bukit Jalil</option>
                  <option value="sri_petaling">Sri Petaling</option>
                </select>
                <span class="error" id="pickupError"></span>
              </td>
            </tr>
            <tr>
              <td>
                <h2>Drop-Off Point</h2>
              </td>
              <td class="input-container">
                <select name="dropoff" id="dropoff" required>
                  <option value="">Select Drop-Off Point</option>
                  <option value="apu">APU</option>
                  <option value="lrt_bukit_jalil">LRT Bukit Jalil</option>
                  <option value="pav_bukit_jalil">Pavilion Bukit Jalil</option>
                  <option value="sri_petaling">Sri Petaling</option>
                </select>
                <span class="error" id="dropoffError"></span>
              </td>
            </tr>
            <tr>
              <td>
                <h2>Vehicle</h2>
              </td>
              <td class="input-container">
                <select name="vehicle" id="vehicle" onchange="updateSlots()">
                  <option value="">Select Vehicle</option>
                  <?php
                  // Fetch vehicles linked to this driver
                  $getVehicleSQL = "SELECT * FROM vehicle WHERE driver_id = '$driverID'";
                  $vehicleResult = mysqli_query($conn, $getVehicleSQL);

                  if (mysqli_num_rows($vehicleResult) > 0) {
                    while ($vehicle = mysqli_fetch_assoc($vehicleResult)) {
                      $vehicleID = $vehicle['id'];
                      $plateNo = $vehicle['plate_no'];
                      $seatNumber = $vehicle['seat_no'] - 1;
                      echo "<option value='$vehicleID' data-seats='$seatNumber'>$plateNo</option>";
                    }
                  } else {
                    echo "<option value=''>No Vehicles Available</option>";
                  }
                  ?>
                </select>
                <span class="error" id="vehicleError"></span>
              </td>
            </tr>
            <tr>
              <td>
                <h2>Slots</h2>
              </td>
              <td class="input-container">
                <input type="number" name="seatNo" id="seatNo" min="1" disabled>

                <script>
                  function updateSlots() {
                    const vehicleSelect = document.getElementById('vehicle');
                    const seatInput = document.getElementById('seatNo');
                    const selectedOption = vehicleSelect.options[vehicleSelect.selectedIndex];
                    const maxSeats = selectedOption.getAttribute('data-seats');

                    if (maxSeats && selectedOption.value !== "") {
                      seatInput.max = maxSeats;
                      seatInput.value = maxSeats;
                      seatInput.style.color = "black";
                      seatInput.style.fontWeight = "bold";
                      seatInput.style.border = "3px solid #009432"
                      seatInput.removeAttribute('disabled');
                    } else {
                      seatInput.value = "";
                      seatInput.setAttribute('disabled', 'true');
                    }
                  }
                </script>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align: center">
                <button type="button" id="addRideBtn" onclick="validateAndCheckConflict()">Add Ride</button>
              </td>
            </tr>
          </table>
        </form>
      </div>
      <div id="confirmation" class="confirmation" style="display: none;">
        <h2>Ride Confirmation</h2>
        <div id="rideDetails" class="rideDetails">
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
          </table>
        </div>
        <div class="confirmationBtn">
          <button onclick="submitForm()">Confirm</button>
          <button onclick="hideConfirmation()">Cancel</button>
        </div>
      </div>
      <?php
      // Get the date range for last week's Sunday to Saturday
      $last_sunday = date('Y-m-d', strtotime('last sunday -6 days')); // Previous week's Sunday
      $last_saturday = date('Y-m-d', strtotime('last sunday')); // Previous week's Saturday
      
      $sql = "SELECT id, date, DAYNAME(date) AS day, 
              TIME_FORMAT(time, '%h:%i %p') AS formatted_time, 
              pick_up_point, drop_off_point, slots_available,slots, price, driver_id, vehicle_id
              FROM ride 
              WHERE date BETWEEN '$last_sunday' AND '$last_saturday'
              AND status = 'completed' 
              ORDER BY date ASC;";

      $result = $conn->query($sql);
      ?>
      <div class="historyTable" id="historyContainer" style="display: flex;">
        <h1>Add Rides From Previous Activities</h1>
        <table class="rideHistory">
          <thead>
            <tr>
              <td colspan="6"></td>
            </tr>
            <tr>
              <th></th>
              <th>Day</th>
              <th>Time</th>
              <th>Pick-Up</th>
              <th>Drop-Off</th>
              <th>Slots</th>
            </tr>
          </thead>
          <tbody id="tableBody">
            <tr class="divider-row">
              <td colspan="6">
                <div class="centered-line"></div>
              </td>
            </tr>
            <?php
            if ($result->num_rows > 0) {
              // Define custom formatting for specific locations
              $customLocations = [
                "apu" => "APU",
                "lrt_bukit_jalil" => "LRT Bukit Jalil",
                "sri_petaling" => "Sri Petaling",
                "pav_bukit_jalil" => "Pavilion Bukit Jalil"
              ];

              while ($row = $result->fetch_assoc()) {
                // Format pick-up and drop-off points
                $pickUp = isset($customLocations[$row['pick_up_point']]) ?
                  $customLocations[$row['pick_up_point']] :
                  ucwords(str_replace('_', ' ', strtolower(trim($row['pick_up_point']))));

                $dropOff = isset($customLocations[$row['drop_off_point']]) ?
                  $customLocations[$row['drop_off_point']] :
                  ucwords(str_replace('_', ' ', strtolower(trim($row['drop_off_point']))));

                echo "<tr>
              <td><input type='checkbox' class='rideCheckbox' value='{$row['id']}' data-ride='" . json_encode($row) . "'></td>
              <td>{$row['day']}</td>
              <td>{$row['formatted_time']}</td>
              <td>{$pickUp}</td>
              <td>{$dropOff}</td>
              <td class='historySlots'>{$row['slots']}</td>
          </tr>";
              }
            } else {
              echo "<tr><td colspan='6'>No rides found from the previous week</td></tr>";
            }
            ?>
            <tr class="divider-row">
              <td colspan="6">
                <div class="centered-line"></div>
              </td>
            </tr>
            <tr class="pageControl" height="15px">
              <!-- insert the pagination here -->
            </tr>
            <tr class="create-btn-row">
              <td colspan="6" style="text-align: center;">
                <button class="addSelectBtn" onclick="showSelectedRidesConfirmation()">Create Selected Rides</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div id="selectedRidesConfirmation" class="selectedRidesConfirmation" style="display: none;">
      </div>
      <div id="conflictRides" class="conflictRides" style="display: none;">
        <div class="conflictBtn" id="conflictBtn">
          <button class="replaceRideBtn" id="replaceRideBtn">Replace</button>
          <button class="keepBtn" id="keepBtn">Keep</button>
        </div>
      </div>
    </div>
    <div class="earningsContent" style="display: none">earning</div>
    <div class="historyContent" style="display: none">history</div>
    <div class="profileContent" style="display: none">Profile
      <div class="licenseImg">
        <img src="<?php echo htmlspecialchars($frontLicensePath); ?>" alt="license photo_front" width="30%"
          height="40%">
        <img src="<?php echo htmlspecialchars($backLicensePath); ?>" alt="license photo_back" width="30%" height="40%">
      </div>
    </div>
  </div>
  <script src="../js/driver/upcomingRide.js" defer></script>
  <script src="../js/driver/addRide.js" defer></script>
  <script src="../js/driver/addHistoryRides.js" defer></script>
</body>

</html>