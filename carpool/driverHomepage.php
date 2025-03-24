<?php
include("dbconn.php");
include("headerHomepage.php");

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Driver Page</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9fafc; /* Light background */
      color: #333;
    }

    .hero {
      background:rgb(0, 0, 0);
      color: white;
      text-align: center;
      padding: 150px 20px;
      margin-top: 70px;
    }

    .hero h1 {
      font-size: 3rem;
      margin-bottom: 20px;
      color: white;
    }

    .hero p {
      font-size: 1.3rem;
      max-width: 700px;
      margin: 0 auto 30px;
      line-height: 1.5;
      color: white;
    }

    .hero .driverButton {
      background: #0073e6;
      color: #fff;
      padding: 15px 30px;
      font-size: 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }

    .hero .driverButton:hover {
      background: #005bb5;
    }

    /***** FEATURES SECTION *****/
    .features {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 100px;
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
      margin-top: 100px;
    }

    .feature-box {
      background: #fff;
      flex: 1 1 250px;
      max-width: 350px;
      padding: 25px;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 4px 15px 0 rgba(0, 0, 0, 0.2);
    }

    .feature-box h3 {
      font-size: 1.5rem;
      margin-bottom: 15px;
    }

    .feature-box p {
      font-size: 1rem;
      line-height: 1.4;
      color: #555;
    }
  </style>
</head>
<body>

  <!-- HERO SECTION -->
  <section class="hero">
    <h1>Drive with APool</h1>
    <p>
      Join our community of drivers and earn money on your own schedule.
      Manage your rides, track your earnings, and grow your driving business.
    </p>
    <br><br><br>
    <a class="driverButton" href="driverRegistration.php">Become a Driver</a>
  </section>

  <!-- FEATURES SECTION -->
  <section class="features">
    <div class="feature-box">
      <h3>Flexible Schedule</h3>
      <p>Drive whenever you want. You’re your own boss with complete flexibility.</p>
    </div>
    <div class="feature-box">
      <h3>Competitive Earnings</h3>
      <p>Earn competitive rates with bonuses during peak hours and busy seasons.</p>
    </div>
    <div class="feature-box">
      <h3>Easy Management</h3>
      <p>Our driver portal makes it easy to manage rides, earnings, and vehicle details.</p>
    </div>
  </section>

  
  <script>
   
  </script>
</body>
</html>
