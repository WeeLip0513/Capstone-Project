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
    <h1>Drive with <span class="highlight">APool</span></h1>
    <p>
      Join our community of drivers and earn money on your own schedule.
      Manage your rides, track your earnings, and grow your driving business.
    </p>
  </section>



  <section class="driver-howto">
  <h2>How to Use APool as a Driver</h2>


  <!-- Step 1 -->
  <div class="step">
    <div class="step-img">
      <img src="image/news/createRide.jpg" alt="Create Rides Screenshot">
    </div>
    <div class="step-text">
      <h3>1. Create Rides</h3>
      <p>
        Set up one-time or recurring rides with your preferred routes, times, and pricing.
        Passengers can then request a seat, making it easy to fill your schedule.
      </p>
    </div>
  </div>

  <!-- Step 2 -->
  <div class="step reverse">
    <div class="step-img">
      <img src="image/news/trackEarning.jpg" alt="Track Earnings Screenshot">
    </div>
    <div class="step-text">
      <h3>2. Track Earnings</h3>
      <p>
        Monitor your income in real-time and withdraw earnings directly to your bank account.
        Stay informed about your weekly or monthly ride income at a glance.
      </p>
    </div>
  </div>

  <!-- Step 3 -->
  <div class="step">
    <div class="step-img">
      <img src="image/news/manageProfile.jpg" alt="Manage Profile Screenshot">
    </div>
    <div class="step-text">
      <h3>3. Manage Profile</h3>
      <p>
        Keep your driver details up to date, maintain your verification status, and
        build trust with passengers by showcasing your driving history and ratings.
      </p>
    </div>
  </div>

</section>


</body>
</html>
<?php include('footer.php'); ?>
