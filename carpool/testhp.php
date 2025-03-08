<?php
include("dbconn.php");
include("headerHomepage.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APshare - Smart Carpool Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="testhomepage.css">
</head>
<body>
    <div class="homepage-container">
        <!-- Ads Carousel Section -->
        <div class="wrapper">
            <div class="ads">
                <input type="radio" name="slide" id="a1">
                <label for="a1" class="card" style="background-image: url('image/homepage/image2.jpg')">
                    <div class="row">
                        <div class="description">
                            <h4>Welcome to APshare</h4>
                            <p>Connect with commuters going your way</p>
                        </div>
                    </div>
                </label>
                <input type="radio" name="slide" id="a2" checked>
                <label for="a2" class="card" style="background-image: url('image/homepage/image4.jpg')">
                    <div class="row">
                        <div class="description">
                            <h2>Travel Smarter</h2>
                            <p>Save money and reduce your carbon footprint</p>
                        </div>
                    </div>
                </label>
                <input type="radio" name="slide" id="a3">
                <label for="a3" class="card" style="background-image: url('image/homepage/image3.jpg')">
                    <div class="row">
                        <div class="description">
                            <h4>Start Sharing</h4>
                            <p>Join our community today</p>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        <!-- Features Sliders Section -->
        <div class="second-section">
            <!-- Driver Features -->
            <div class="driver-features-slider">
                <div class="driver-content-container">
                    <h5>Driver Features</h5>
                    <h2>Create your ride and start earning!</h2>
                    <div class="driver-list-style">
                        <ul>Set your own schedule</ul>
                        <ul>Choose your passengers</ul>
                        <ul>Earn extra income</ul>
                    </div>
                </div>
                <div class="slider">
                    <div class="slide-track">
                        <?php for($i=1; $i<=6; $i++): ?>
                        <div class="slide">
                            <img src="image/homepage/driver<?= $i ?>.jpg" alt="Driver Features">
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Passenger Features -->
            <div class="driver-features-slider passenger-features">
                <div class="driver-content-container">
                    <h5>Passenger Features</h5>
                    <h2>Find reliable rides easily!</h2>
                    <div class="driver-list-style">
                        <ul>Affordable prices</ul>
                        <ul>Verified drivers</ul>
                        <ul>Flexible scheduling</ul>
                    </div>
                </div>
                <div class="slider">
                    <div class="slide-track">
                        <?php for($i=1; $i<=6; $i++): ?>
                        <div class="slide">
                            <img src="image/homepage/passenger<?= $i ?>.jpg" alt="Passenger Features">
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <!-- Wave Effects -->
            <div class="wave" id="wave1" style="--i:1;"></div>
            <div class="wave" id="wave2" style="--i:2;"></div>
            <div class="wave" id="wave3" style="--i:3;"></div>
            <div class="wave" id="wave4" style="--i:4;"></div>
        </div>

        <!-- Role Selection Section -->
        <div class="ourservices">
            <h1>Choose Your Role</h1>
            <div class="rolecard">
                <div class="role">
                    <div class="icon">
                        <img src="image/homepage/driver.png" alt="Driver">
                    </div>   
                    <h2>Driver</h2>             
                    <p>Join our community of drivers and start earning by sharing your rides.</p>
                    <a href="/driver" class="learn-more">Sign Up</a>
                </div>
                <div class="role">
                    <div class="icon">
                        <img src="image/homepage/passenger.png" alt="Passenger">
                    </div>
                    <h2>Passenger</h2>
                    <p>Find convenient and affordable rides to your destination.</p>
                    <a href="/passenger" class="learn-more">Sign Up</a>
                </div>
            </div>
        </div>

        <!-- Benefits Carousel -->
        <div class="benefits">
            <h1>Carpool Today, Create a Better Tomorrow!</h1>
            <div class="feature-container swiper">
                <div class="feature-wrapper">
                    <div class="feature-list swiper-wrapper">
                        <div class="feature-item swiper-slide">
                            <h2>Cost Saving</h2>
                            <p>Share the Ride, Split the Cost</p>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>Eco Friendly</h2>
                            <p>Reduce your carbon footprint</p>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>Community</h2>
                            <p>Connect with local commuters</p>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-slide-button swiper-button-prev"></div>
                    <div class="swiper-slide-button swiper-button-next"></div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="js/homepage/swiper.js"></script>
        <script>
            // Wave Animation
            window.addEventListener('scroll', function(){
                let value = window.scrollY;
                document.querySelectorAll('.wave').forEach((wave, index) => {
                    wave.style.backgroundPositionX = (400 + value * (4 - index)) + 'px';
                });
            });

            // Mobile Menu Toggle
            const mobileMenuBtn = document.createElement('button');
            mobileMenuBtn.className = 'mobile-menu-btn';
            mobileMenuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            document.querySelector('.navbar').appendChild(mobileMenuBtn);

            mobileMenuBtn.addEventListener('click', () => {
                document.querySelector('.navlinks').classList.toggle('active');
            });
        </script>
    </div>
</body>
</html>