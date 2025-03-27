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
    /* *{
    border: 2px solid red;
    } */

    body {
      font-family: Arial, sans-serif;
      background: #0B0D14; /* Light background */
      color: #333;
    }

    .hero {
      color: white;
      text-align: center;
      padding: 150px 20px;
      margin-top: 70px;
      height: 680px;
      border-bottom: 3px solid #333;
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
    }

    .feature-box {
      background: #0B0D14;
      color: white;
      flex: 1 1 250px;
      max-width: 300px;
      height: 250px;
      padding: 25px;
      text-align: center;
      border-radius: 8px;
      box-shadow: 0 4px 15px 0 rgba(0, 0, 0, 0.2);
      text-align: justify;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-box:hover {
      transform: scale(1.03);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    }

    .feature-box h3 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      margin-top: 30px;
    }

    .feature-box p {
      font-size: 1rem;
      line-height: 1.4;
      max-width: 250px;
    }

    /* ========== DRIVER FEATURES SECTION ========== */
    .driver-features {
      text-align: center;
      padding: 60px 20px;
      max-width: 1200px;
      margin: 0 auto;
      margin-top: 50px;
    }

    .driver-features::after {
      content: "";
      display: block;
      width: 100vw; /* 100% of viewport width */
      height: 3px; /* Thickness of the line */
      background: #333; 
      position: relative;
      left: 50%;
      transform: translateX(-50%);
      margin-top: 150px; /* Space between section and the line */
    }

    .driver-features h2 {
      font-size: 2rem;
      font-weight: 700;
      margin-bottom: 40px;
      color: #fff;
    }

    /* ========== FEATURE GRID ========== */
    .feature-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 40px;
      justify-items: center; /* Centers items in each column */
    }

    /* ========== FEATURE CARD ========== */
    .feature-card {
      background-color: #141824;  /* Slightly lighter than the background */
      padding: 30px;
      border-radius: 8px;
      width: 100%;
      max-width: 450px;           /* Controls the max width of each card */
      text-align: center;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .feature-icon {
      margin-bottom: 20px;
    }

    /* Adjust icon size or use a font icon / SVG if preferred */
    .feature-icon img {
      width: 50px;
      height: 50px;
      object-fit: cover;
    }

    .feature-card h3 {
      font-size: 1.2rem;
      font-weight: 500;
      margin-bottom: 10px;
      color: #fff;
    }

    .feature-card p {
      font-size: 1rem;
      line-height: 1.5;
      color: #ccc; /* Subtle contrast for paragraph text */
      text-align: justify;
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
