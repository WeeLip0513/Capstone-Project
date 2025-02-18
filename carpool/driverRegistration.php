<?php
include("dbconn.php");
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Driver & Vehicle</title>
  <script src="js/register/driverValidation.js" defer></script>
</head>

<body>
  <div class="driverRegForm">
    <form action="php/register/registerDriverVehicle.php" method="post" id="registrationForm"
      enctype="multipart/form-data">
      <div id="driverSection">
        <h1>Register Driver</h1>
        <table>
          <tr>
            <td>TP Number</td>
            <td>
              <input type="text" name="txtTP" id="txtTP" required pattern="[A-Za-z0-9]+">
              <span class="error" id="txtTPError"></span>
            </td>
          </tr>
          <tr>
            <td>First Name</td>
            <td>
              <input type="text" name="txtFname" id="txtFname" required pattern="[A-Za-z]+">
              <span class="error" id="txtFnameError"></span>
            </td>
          </tr>
          <tr>
            <td>Last Name</td>
            <td>
              <input type="text" name="txtLname" id="txtLname" required pattern="[A-Za-z]+">
              <span class="error" id="txtLnameError"></span>
            </td>
          </tr>
          <tr>
            <td>Password</td>
            <td>
              <input type="password" name="txtPass" id="txtPass" required>
              <span class="error" id="txtPassError"></span>
            </td>
          </tr>
          <tr>
            <td>
              Email :
            </td>
            <td>
              <input type="text" name="txtEmail" id="txtEmail" required
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
              <span class="error" id="txtEmailError"></span>
            </td>
          </tr>
          <tr>
            <td>Phone Number</td>
            <td>
              <input type="text" name="txtPhone" id="txtPhone" required pattern="[0-9]+">
              <span class="error" id="txtPhoneError"></span>
            </td>
          </tr>
          <tr>
            <td>License Number</td>
            <td>
              <input type="text" name="txtLicense" id="txtLicense" required pattern="[A-Za-z0-9]+">
              <span class="error" id="txtLicenseError"></span>
            </td>
          </tr>
          <tr>
            <td>License Expiry Date</td>
            <td>
              <input type="date" name="txtExpDate" id="txtExpDate" required>
              <span class="error" id="txtExpDateError"></span>
            </td>
          </tr>
          <tr>
            <td>License Photo</td>
            <td>
              <input type="file" id="license_photo" name="license_photo" accept="image/*" required>
              <span class="error" id="license_photoError"></span>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center;">
              <button type="button" id="nextButton">Next</button>
            </td>
          </tr>
        </table>
      </div>

      <div id="vehicleSection" style="display: none;">
        <h1>Register Vehicle</h1>
        <table>
          <tr>
            <td>Type</td>
            <td>
              <select name="vehicleType" id="vehicleType" required>
                <option value="">Select Vehicle Type</option>
                <option value="motorcar">Motorcar</option>
                <option value="pickup">Pickup Truck</option>
                <option value="jeep">Jeep</option>
                <option value="van">Van</option>
                <option value="mpv">MPV</option>
                <option value="suv">SUV</option>
              </select>
              <span class="error" id="vehicleTypeError"></span>
            </td>
          </tr>
          <tr>
            <td>Manufacturing Year</td>
            <td>
              <input type="number" name="vehicleYear" id="vehicleYear" required min="1900" max="2099">
              <span class="error" id="vehicleYearError"></span>
            </td>
          </tr>
          <tr>
            <td>Brand</td>
            <td>
              <select name="vehicleBrand" id="vehicleBrand" required onchange="updateModels()">
                <option value="">Select Brand</option>
                <option value="Perodua">Perodua</option>
                <option value="Proton">Proton</option>
                <option value="Toyota">Toyota</option>
                <option value="Honda">Honda</option>
                <option value="Nissan">Nissan</option>
                <option value="Mazda">Mazda</option>
                <option value="BMW">BMW</option>
                <option value="Mercedes-Benz">Mercedes-Benz</option>
                <option value="Hyundai">Hyundai</option>
                <option value="Kia">Kia</option>
              </select>
              <span class="error" id="vehicleBrandError"></span>
            </td>
          </tr>
          <tr>
            <td>Model</td>
            <td>
              <select name="vehicleModel" id="vehicleModel" required>
                <option value="">Select Model</option>
              </select>
              <span class="error" id="vehicleModelError"></span>
            </td>
          </tr>

          <script src="js/register/vehicleSelection.js"></script>

          <td>Color</td>
          <td>
            <input type="text" name="vehicleColor" id="vehicleColor" required>
            <span class="error" id="vehicleColorError"></span>
          </td>
          </tr>
          <tr>
            <td>Plate Number</td>
            <td>
              <input type="text" name="plateNo" id="plateNo" required pattern="[A-Za-z0-9]+">
              <span class="error" id="plateNoError"></span>
            </td>
          </tr>
          <tr>
            <td>Seat Number</td>
            <td>
              <input type="number" name="seatNo" id="seatNo" required readonly>
            </td>
          </tr>
          <tr>
            <td colspan="2" style="text-align: center;">
              <button type="button" id="backButton">Back</button>
              <input type="submit" value="Register">
            </td>
          </tr>
        </table>
      </div>
    </form>
  </div>
</body>

</html>