<?php
include ("dbconn.php");
include ("headerHomepage.php");

session_start();
// Example: Check if the driver is logged in
// if (!isset($_SESSION['driver_id'])) {
//     header("Location: loginpage.php");
//     exit;
// }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Home Page - Carpool System</title>
  <style>
    /* Basic CSS for layout and styling */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f4f4f4;
    }
    header {
      background: #0073e6;
      color: #fff;
      padding: 150px;
      text-align: center;
      margin-top: 80px;
    }
    nav {
      background: #005bb5;
      overflow: hidden;
    }
    nav a {
      float: left;
      display: block;
      color: #fff;
      text-align: center;
      padding: 14px 20px;
      text-decoration: none;
    }
    nav a:hover {
      background: #003f7f;
    }
    .container {
      padding: 20px;
    }
    .section {
      display: none;
      background: #fff;
      margin-bottom: 20px;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0px 0px 5px rgba(0,0,0,0.1);
    }
    .active {
      display: block;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 5px;
    }
    input, textarea, select {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    button {
      background: #0073e6;
      color: #fff;
      padding: 10px 15px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }
    button:hover {
      background: #005bb5;
    }
  </style>
</head>
<body>
  <header>
    <h1>Welcome, Driver!</h1>
  </header>

  <nav>
    <a href="#" onclick="showSection('driverDetails')">Driver Details</a>
    <a href="#" onclick="showSection('withdrawEarnings')">Withdraw Earnings</a>
    <a href="#" onclick="showSection('createRide')">Create Ride</a>
    <a href="#" onclick="showSection('addVehicle')">Add Vehicle</a>
    <a href="#" onclick="showSection('recoverPassword')">Recover Password</a>
  </nav>

  <div class="container">
    <!-- Driver Details Section -->
    <div id="driverDetails" class="section active">
      <h2>Driver Details</h2>
      <?php
      // Example PHP code to fetch driver details from a database.
      // This is a placeholder - replace with your actual database code.
      $driverName = "John Doe"; // Replace with query result.
      $driverEmail = "johndoe@example.com"; // Replace with query result.
      ?>
      <p><strong>Name:</strong> <?php echo htmlspecialchars($driverName); ?></p>
      <p><strong>Email:</strong> <?php echo htmlspecialchars($driverEmail); ?></p>
      <!-- More details can be added here -->
    </div>

    <!-- Withdraw Earnings Section -->
    <div id="withdrawEarnings" class="section">
      <h2>Withdraw Earnings</h2>
      <form action="withdraw.php" method="post">
        <div class="form-group">
          <label for="amount">Amount to Withdraw:</label>
          <input type="number" id="amount" name="amount" required>
        </div>
        <button type="submit">Withdraw</button>
      </form>
    </div>

    <!-- Create Ride Section -->
    <div id="createRide" class="section">
      <h2>Create Ride</h2>
      <form action="create_ride.php" method="post">
        <div class="form-group">
          <label for="origin">Origin:</label>
          <input type="text" id="origin" name="origin" required>
        </div>
        <div class="form-group">
          <label for="destination">Destination:</label>
          <input type="text" id="destination" name="destination" required>
        </div>
        <div class="form-group">
          <label for="date">Date & Time:</label>
          <input type="datetime-local" id="date" name="date" required>
        </div>
        <button type="submit">Create Ride</button>
      </form>
    </div>

    <!-- Add Vehicle Section -->
    <div id="addVehicle" class="section">
      <h2>Add Vehicle</h2>
      <form action="add_vehicle.php" method="post">
        <div class="form-group">
          <label for="make">Make:</label>
          <input type="text" id="make" name="make" required>
        </div>
        <div class="form-group">
          <label for="model">Model:</label>
          <input type="text" id="model" name="model" required>
        </div>
        <div class="form-group">
          <label for="year">Year:</label>
          <input type="number" id="year" name="year" required>
        </div>
        <button type="submit">Add Vehicle</button>
      </form>
    </div>

    <!-- Recover Password Section -->
    <div id="recoverPassword" class="section">
      <h2>Recover Password</h2>
      <form action="recover_password.php" method="post">
        <div class="form-group">
          <label for="email">Enter Your Email:</label>
          <input type="email" id="email" name="email" required>
        </div>
        <button type="submit">Recover Password</button>
      </form>
    </div>
  </div>

  <script>
    // JavaScript to switch between sections
    function showSection(sectionId) {
      var sections = document.getElementsByClassName('section');
      for (var i = 0; i < sections.length; i++) {
        sections[i].classList.remove('active');
      }
      document.getElementById(sectionId).classList.add('active');
    }
  </script>
</body>
</html>
