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
</head>
<style>
    body, html {
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* Remove horizontal scroll */
        width: 100vw;
        scroll-behavior: smooth;
    }
    section {
        height: 100vh;
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

    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 60px 80px;
    }
    

    .left {
        max-width: 600px;
        margin-left: 30px;
    }

    .left h1 {
        font-size:60px;
        margin-top: 40px;
        font-weight: bold;
        margin-bottom: 20px;
        color: white;
        font-weight: bold;
    }

    .left p {
        font-size: 26px;
        color: #6e6e6e;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .right img {
        width: 650px;
        padding-top: 60px;
    }

    /* section 2 */
    .services-container {
        padding: 60px 20px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: white;
    }

    /* Section 2 header */
    .section-h2 {
        font-size: 75px;
        margin-top: 60px;
        margin-bottom:40px;
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
        background-color: #fff;
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
        margin-top:20px;
    }

    /* Card titles and descriptions */
    .service-title {
        font-size: 25px;
        margin-top: 105px;
        font-weight: 600;
    }

    .service-description {
        font-size: 20px;
        line-height: 1.4;
        color: #555;
    }

</style>
<body>
    <div class="scroll-wrapper">
        <section class="container">
            <div class="left">
                <h1>Easy to School<br>Cool with APool</h1>
                <p>Hop in quick, the ride is slick <br>APool takes you to class without a single trick.</p>
            </div>
            <div class="right">
                <img src="image/homepage/passengerHomePage.jpg" alt="Carpool Image" />
            </div>
        </section>
        <section class="services-container">
            <h2 class="section-h2">WHY PASSENGERS LOVE APOOL</h2>    
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
