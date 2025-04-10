<?php
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Passenger Home Page</title>
  <link rel="stylesheet" href="css/passengerHomePage.css"/>    
</head>
<body>
    <div class="scroll-wrapper">
        <!-- SECTION 1: Hero Section -->
        <section class="hero-container">
            <div class="left">
                <h1>Easy to School, Cool with <span style="color: #2b64ff;">APool</span></h1>
                <p>Hop in quick, the ride is slick APool takes you to class without a single trick.</p>
            </div>
        </section>
        
        <!-- NEW SECTION: How to Use APool as a Passenger -->
        <section class="how-to-use-section">
            <div class="how-to-use-container">
                <h1>How to Use APool as a Passenger</h1>

                <!-- Step 1: Image on LEFT, text on RIGHT -->
                <div class="step-container">
                    <div class="image-container">
                        <img 
                            src="image/homepage/passenger2.jpg" 
                            alt="passenger1" 
                            class="step-image"
                        >
                    </div>
                    <div class="step-text">
                        <div class="step-header">
                            <div class="step-number">1</div>
                            <h2 class="step-title">Search for Rides</h2>
                        </div>
                        <p class="step-description">
                            Open the APool app or website and navigate to the "Request Ride" section.
                            Enter your pickup location, destination, and preferred time.
                            Once you submit, your ride request is visible to drivers going your way.
                        </p>
                    </div>
                </div>

                <!-- Step 2: Text on LEFT, image on RIGHT -->
                <div class="step-container reverse">
                    <div class="image-container">
                        <img 
                            src="image/homepage/passenger3.jpg" 
                            alt="passenger2" 
                            class="step-image"
                        >
                    </div>
                    <div class="step-text">
                        <div class="step-header">
                            <div class="step-number">2</div>
                            <h2 class="step-title">Book & Pay</h2>
                        </div>
                        <p class="step-description">
                            Once a driver accepts your request, confirm the pickup details and wait 
                            at the designated location. During the ride, you can view trip details 
                            and driver info. Arrive safely at your destination, and don't forget 
                            to leave a rating!
                        </p>
                    </div>
                </div>

                <!-- Step 3: Image on LEFT, text on RIGHT -->
                <div class="step-container">
                    <div class="image-container">
                        <img 
                            src="image/homepage/passenger5.png" 
                            alt="passenger3" 
                            class="step-image"
                        >
                    </div>
                    <div class="step-text">
                        <div class="step-header">
                            <div class="step-number">3</div>
                            <h2 class="step-title">Rate Your Ride</h2>
                        </div>
                        <p class="step-description">
                            After completing your journey, you'll be prompted to rate your driver and 
                            the overall experience. Payment is processed automatically through your 
                            preferred payment method in the app. You'll receive a detailed receipt 
                            via email with a breakdown of the fare and any applicable discounts.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- SECTION 3: Why Passengers Love APool -->
        <section class="services-container">
            <h2 class="section-h2">Why Passenger Love Apool</h2>    
            <div class="cards-wrapper">
                <!-- Card 1 -->
                <div class="service-card">
                    <!-- Icon + decorative circles -->
                    <div class="icon-wrapper">
                        <div class="circle circle-yellow"></div>
                        <div class="circle circle-green"></div>
                        <!-- Replace with your actual icon image -->
                        <img src="image/homepage/saveTime.png" alt="Save Time Icon" />
                    </div>
                    <h3 class="service-title">SAVE TIME</h3>
                    <p class="service-description">
                        Avoid long waits or bus delays – ride directly to class or home.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="service-card">
                    <div class="icon-wrapper">
                        <div class="circle circle-yellow"></div>
                        <div class="circle circle-green"></div>
                        <img src="image/homepage/affortableRides.png" alt="Affortable Rides Icon" />
                    </div>
                    <h3 class="service-title">AFFORTABLE RIDES</h3>
                    <p class="service-description">
                        Split costs with others and save money every trip.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="service-card">
                    <div class="icon-wrapper">
                        <div class="circle circle-yellow"></div>
                        <div class="circle circle-green"></div>
                        <img src="image/homepage/seamlessExperience.png" alt="Seamless Experience Icon" />
                    </div>
                    <h3 class="service-title">SEAMLESS EXPERIENCE</h3>
                    <p class="service-description">
                        Simple to book, easy to track, and smooth to ride.
                    </p>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
<?php include('footer.php'); ?>