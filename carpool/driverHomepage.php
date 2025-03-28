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
  <link rel="stylesheet" href="css/driverHomepage.css">
</head>
<body>

  <!-- HERO SECTION -->
  <section class="hero">
    <h1>Drive with APool</h1>
    <p>
      Join our community of drivers and earn money on your own schedule.
      Manage your rides, track your earnings, and grow your driving business.
    </p>
  </section>

  <section class="driver-features">
    <h2>What You Can Do as a Driver</h2>
    <div class="feature-grid">
      
      <!-- Feature 1 -->
      <div class="feature-card">
        <div class="feature-icon">
          <img src="image/news/car2.png" alt="Manage Vehicles Icon">
        </div>
        <h3>Manage Vehicles</h3>
        <p>Add multiple vehicles to your profile and choose which one to use for each ride.</p>
      </div>

      <!-- Feature 2 -->
      <div class="feature-card">
        <div class="feature-icon">
          <img src="image/news/address.png" alt="Create Rides Icon">
        </div>
        <h3>Create Rides</h3>
        <p>Set up one-time or recurring rides with your preferred routes, times, and pricing.</p>
      </div>

      <!-- Feature 3 -->
      <div class="feature-card">
        <div class="feature-icon">
          <img src="image/news/money.png" alt="Track Earnings Icon">
        </div>
        <h3>Track Earnings</h3>
        <p>Monitor your income and withdraw your earnings directly to your bank account.</p>
      </div>

      <!-- Feature 4 -->
      <div class="feature-card">
        <div class="feature-icon">
          <img src="image/news/profile.png" alt="Manage Profile Icon">
        </div>
        <h3>Manage Profile</h3>
        <p>Keep your driver details up to date and maintain your driver verification status.</p>
      </div>

    </div>
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

</body>
</html>
