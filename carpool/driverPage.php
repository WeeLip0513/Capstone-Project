<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Driver</title>
  <link rel="stylesheet" href="css/driverPage.css" />
</head>

<body>
  <div class="features">
    <button id="recentActivities" class="feature" data-content="activityContent">
      Recent Activities
    </button>
    <button id="addRides" class="feature" data-content="rideContent">
      Add Rides
    </button>
    <button id="earnings" class="feature" data-content="earningsContent">
      Earnings
    </button>
    <button id="vehicles" class="feature" data-content="vehicleContent">
      Vehicles
    </button>
    <button id="history" class="feature" data-content="historyContent">
      History
    </button>
  </div>
  <div class="contents">
    <div class="activityContent">recentActivities</div>
    <div class="rideContent" style="display: none;">
      <form action method="post" id="addRide">
        <table class="addRideTable">
          <tr>
            <td>
              <h2>Day :</h2>
            </td>
            <td>
              <select name="day" id="day" required>
                <option value="monday">Monday</option>
                <option value="tuesday">Tuesday</option>
                <option value="wednesday">Wednesday</option>
                <option value="thursday">Thursday</option>
                <option value="friday">Friday</option>
              </select>
              <span class="error" id="dayError"></span>
            </td>
          </tr>
          <tr>
            <td>
              <h2>Time :</h2>
            </td>
            <td>
              <select name="hour" id="hour" required>
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
              </select>
              <select name="minute" id="minute" required>
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
              <span class="error" id="timeError"></span>
            </td>
          </tr>
          <tr>
            <td>
              <h2>Pick-Up Point :</h2>
            </td>
            <td>
              <select name="pickup" id="pickup" required>
                <option value="apu">APU</option>
                <option value="lrt_bukit_jalil">LRT Bukit Jalil</option>
              </select>
              <span class="error" id="pickupError"></span>
            </td>
          </tr>
          <tr>
            <td>
              <h2>Drop-Off Point :</h2>
            </td>
            <td>
              <select name="dropoff" id="dropoff" required>
                <option value="apu">APU</option>
                <option value="lrt_bukit_jalil">LRT Bukit Jalil</option>
              </select>
              <span class="error" id="dropoffError"></span>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center">
              <input type="submit" value="Submit" name="btnSubmit" class="button" />
            </td>
          </tr>
        </table>
      </form>
      <div class="addedRides">
        Testing
      </div>
    </div>
    <div class="earningsContent" style="display: none">earning</div>
    <div class="vehicleContent" style="display: none">vehicle</div>
    <div class="historyContent" style="display: none">history</div>
  </div>
  <script src="js/driver/driverPage.js"></script>
</body>

</html>