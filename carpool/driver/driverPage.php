<?php
session_start();
include("../dbconn.php");
include("../headerHomepage.php");

$_SESSION['id'] = 10;
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
  $frontLicensePath = str_replace("../../", "", $frontImgPath);
  $backLicensePath = str_replace("../../", "", $backImgPath);

  // echo $frontLicensePath;
  // echo $backLicensePath;

  $driverID = $driver['id'];
  $_SESSION['driverID'] = $driverID;
  // echo $_SESSION['driverID'];
} else {
  echo "No driver record found!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver</title>
  <link rel="stylesheet" href="../css/driverPage/driverPage.css" />
  <link rel="stylesheet" href="../css/driverPage/addRide.css">
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
  <div class="features">
    <button id="recentActivities" class="featureBtn" data-content="activityContent">
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
    <div class="activityContent">Upcoming Rides</div>
    <div class="rideContent" style="display: none;">
      <div class="addRides" id="addRideContainer">
        <h1>Create Rides Now !</h1><br>
        <form id="addRideForm" method="POST" action="php/driver/addRideProcess.php" novalidate>
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
                <button type="button" onclick="if(validateRideForm()) showConfirmation()"
                  id="addRideBtn">Create</button>
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
              pick_up_point, drop_off_point, slots_available, price, driver_id, vehicle_id
              FROM ride 
              WHERE date BETWEEN '$last_sunday' AND '$last_saturday'
              AND status = 'completed' 
              ORDER BY date ASC;";

      $result = $conn->query($sql);
      ?>
      <div class="historyTable" id="historyContainer">
        <h1>Add Rides From Previous Activities</h1>
        <table class="rideHistory">
          <thead>
            <tr>
              <td colspan="6"></td>
            </tr>
            <tr>
              <!-- <th></th> -->
              <th></th>
              <th>Day</th>
              <th>Time</th>
              <th>Pick-Up</th>
              <th>Drop-Off</th>
              <th>Slots</th>
              <!-- <th></th> -->
            </tr>
          </thead>
          <tbody id="tableBody">
            <!-- Centered Divider after Header -->
            <tr class="divider-row">
              <td colspan="6">
                <div class="centered-line"></div>
              </td>
            </tr>
            <?php
            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo "<tr>
                  <td><input type='checkbox' class='rideCheckbox' value='{$row['id']}' data-ride='" . json_encode($row) . "'></td>
                  <td>{$row['day']}</td>
                  <td>{$row['formatted_time']}</td>
                  <td>{$row['pick_up_point']}</td>
                  <td>{$row['drop_off_point']}</td>
                  <td class='historySlots'>{$row['slots_available']}</td>
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
              <!-- insert the paganition here -->
            </tr>
            <tr class="create-btn-row" style="display: none;">
              <td colspan="6" style="text-align: center;">
                <button class="addSelectBtn" onclick="showSelectedRidesConfirmation()">Create Selected Rides</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div id="selectedRidesConfirmation" class="confirmation-modal" style="display: none;">
        <div class="modal-content">
          <h2>Confirm Selected Rides</h2>
          <div id="selectedRideDetails"></div>
          <button onclick="addSelectedRides()">Confirm</button>
          <button onclick="hideSelectedRidesConfirmation()">Cancel</button>
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
</body>

</html>