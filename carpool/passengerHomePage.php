<?php
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Passenger Home Page</title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    body, html {
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Remove horizontal scroll */
        width: 100vw;
        scroll-behavior: smooth;
        font-family: Arial, sans-serif;
        background-color: #000;
        color: #fff;
        line-height: 1.5;
    }
    
    section {
        min-height: 100vh;
        scroll-snap-align: start;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 60px 80px;
    }
    
    .scroll-wrapper {
        height: 100vh;
        scroll-snap-type: y mandatory;
        overflow-y: scroll;
        scrollbar-width: none;     /* Firefox */
        -ms-overflow-style: none;  /* IE and Edge */
    }

    /* Hero Section Styles */
    .hero-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 80px;
    }
    
    .left {
        margin-left: 30px;
    }

    .left h1 {
        font-size: 80px;
        margin-top: 40px;
        font-weight: bold;
        margin-bottom: 20px;
        color: white;
    }

    .left p {
        font-size: 26px;
        color: #a0a0a0;
        margin-bottom: 30px;
        text-align: center;
    }

    .right img {
        width: 650px;
        padding-top: 60px;
    }

    /* Section 2 */
    .how-to-use-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 48px 16px 80px;
        background-color: #000;
    }

    /* Heading styles */
    .how-to-use-container h1 {
        font-weight: 700;
        margin-bottom: 20px;
        padding: 0 16px;
        text-align: left;
    }

    /* Step container styles */
    .step-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 32px;
        margin-bottom: 64px;
        padding: 0 16px;
    }

    /* Image container styles */
    .image-container {
        width: 100%;
        overflow: hidden;
        border-radius: 16px;
        box-shadow: 0 0 20px rgba(43, 99, 255, 0.3);
    }

    .step-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        transition: transform 0.7s ease;
    }

    .step-image:hover {
        transform: scale(1.05);
    }

    /* Text container styles */
    .step-text {
        width: 100%;
        padding: 0;
    }

    /* Step number and title container */
    .step-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 12px;
    }

    /* Step number circle */
    .step-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #2b63ff;
        color: white;
        font-weight: 700;
    }

    /* Step title */
    .step-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2b63ff;
    }

    /* Step description */
    .step-description {
        font-size: 1.125rem;
        color: #cccccc;
        line-height: 1.6;
        padding-left: 0;
    }

    /* Why Love Section Styles */
    .services-container {
        padding: 60px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: white;
        color: black;
    }

    /* Section 2 header */
    .section-h2 {
        font-size: 75px;
        margin-top: 60px;
        margin-bottom: 40px;
        font-weight: 600;
        color: black;
        text-align: center;
    }

    /* Cards wrapper to arrange three cards in a row (responsive) */
    .cards-wrapper {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;  /* center all cards horizontally */
        gap: 40px;                /* space between cards */
        max-width: 1500px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Each card */
    .service-card {
        background-color: rgba(30, 30, 30, 0.08);
        width: 400px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 40px 20px;
        text-align: center;
    }

    /* Icon wrapper for the decorative circles + icon */
    .icon-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 20px auto;
    }

    /* The two overlapping circles */
    .circle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.8;
        margin-top: 20px;
    }

    /* Adjust the color and size of each circle */
    .circle-yellow {
        background-color: #FFD25B; /* pastel yellow */
        width: 150px;
        height: 150px;
        top: -20px;
        left: -40px;
    }

    .circle-green {
        background-color: #90E1C4; /* pastel green */
        width: 100px;
        height: 100px;
        top: 30px;
        left: 45px;
    }

    /* Icon styling */
    .icon-wrapper img {
        position: absolute;
        top: 10px;
        left: -10px;
        width: 110px;
        height: 110px;
        margin-top: 20px;
    }

    /* Card titles and descriptions */
    .service-title {
        font-size: 25px;
        margin-top: 105px;
        font-weight: bold;
    }

    .service-description {
        font-size: 20px;
        margin-top: 10px;
        color: #555;
    }

    /* Responsive styles */
    @media (min-width: 768px) {
        .how-to-use-container h1 {
            font-size: 2.5rem;
        }

        .step-container {
            flex-direction: row;
        }

        .step-container.reverse {
            flex-direction: row-reverse;
        }

        .image-container {
            width: 40%;
        }

        .step-text {
            width: 60%;
            padding: 0 24px;
        }

        .step-title {
            font-size: 1.875rem;
        }

        /* Right alignment for second step */
        .step-container.reverse .step-text {
            text-align: right;
        }

        .step-container.reverse .step-header {
            justify-content: flex-end;
        }

        .step-container.reverse .step-number {
            order: 2;
        }
    }

    @media (max-width: 768px) {
        .left h1 {
            font-size: 40px;
        }
        
        .left p {
            font-size: 18px;
        }
        
        .section-h2 {
            font-size: 40px;
        }
        
        section {
            padding: 40px 20px;
        }
    }
  </style>
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
                            src="image/homepage/driver1.jpg" 
                            alt="Save Time" 
                            class="step-image"
                        >
                    </div>
                    <div class="step-text">
                        <div class="step-header">
                            <div class="step-number">1</div>
                            <h2 class="step-title">Request a Ride</h2>
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
                            src="image/homepage/driver1.jpg" 
                            alt="Confirm and ride with APool" 
                            class="step-image"
                        >
                    </div>
                    <div class="step-text">
                        <div class="step-header">
                            <div class="step-number">2</div>
                            <h2 class="step-title">Confirm & Ride</h2>
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
                            src="image/homepage/driver1.jpg" 
                            alt="Rate and pay for your APool ride" 
                            class="step-image"
                        >
                    </div>
                    <div class="step-text">
                        <div class="step-header">
                            <div class="step-number">3</div>
                            <h2 class="step-title">Rate & Pay</h2>
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