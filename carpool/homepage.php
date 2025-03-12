<?php
include("dbconn.php");
include("headerHomepage.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/homepage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
    <div class="homepage-container">
        <div class="center-wrap">
            <div class="main-content">
                <h1>Travel Smart, Save Together</h1>
                <p>Connect with students going your way - Save money, reduce traffic and make new friends!</p>
                <div class="search-card">
                    <div class="search-selection">
                        <div class="input-wrapper">
                            <div class="input-ride">
                                <i class="fas fa-map-marker-alt"></i>
                                <select id="pickup" class="card-holder" required>
                                    <option value="" disabled selected>Select pickup point</option>
                                    <option value="APU">APU</option>
                                    <option value="LRT Bukit Jalil">LRT Bukit Jalil</option>
                                    <option value="Pavilion Bukit Jalil">Pavilion Bukit Jalil</option>
                                    <option value="Sri Petaling">Sri Petaling</option>
                                </select>
                            </div>
                            <span id="pickup-error" class="error-message">Pickup and
                                drop-off points cannot be the same!</span>
                        </div>
                        <div class="input-wrapper">
                            <div class="input-ride">
                                <i class="fas fa-flag-checkered"></i>
                                <select id="dropoff" class="card-holder" required>
                                    <option value="" disabled selected>Select drop-off point</option>
                                    <option value="APU">APU</option>
                                    <option value="LRT Bukit Jalil">LRT Bukit Jalil</option>
                                    <option value="Pavilion Bukit Jalil">Pavilion Bukit Jalil</option>
                                    <option value="Sri Petaling">Sri Petaling</option>
                                </select>
                            </div>
                            <span id="dropoff-error" class="error-message">Pickup and
                                drop-off points cannot be the same!</span>
                        </div>
                        <div class="input-ride">
                            <i class="fas fa-calendar-alt"></i>
                            <input class="card-holder" type="date" required>
                        </div>
                        <div class="input-ride">
                            <i class="fas fa-clock"></i>
                            <input class="card-holder" type="time" required>
                        </div>
                    </div>
                    <button class="btn-login">Search Rides</button>
                </div>
            </div>
        </div>
        <div class="wrapper">
            <div class="ads">
                <input type="radio" name="slide" id="a1">
                <label for="a1" class="card">
                    <div class="row">
                        <div class="description">
                            <h4>Welcome to APshare</h4>
                            <p>Check it out</p>
                        </div>
                    </div>
                </label>
                <input type="radio" name="slide" id="a2" checked>
                <label for="a2" class="card">
                    <div class="row">
                        <div class="description">
                            <h2>Welcome to APshare</h2>
                            <p>Check it out</p>
                        </div>
                    </div>
                </label>
                <input type="radio" name="slide" id="a3">
                <label for="a3" class="card">
                    <div class="row">
                        <div class="description">
                            <h4>Passenger</h4>
                            <p>Check it out</p>
                        </div>
                    </div>
                </label>
            </div>
        </div>
        <br><br><br><br><br><br>
        <div class="second-section">
            <div class="driver-features-slider">
                <div class="driver-content-container">
                    <h5>Driver Features</h5>
                    <h2>Create your ride and start earning!</h2>
                    <div class="driver-list-style">
                        <ul>Create your own ride</ul>
                        <ul>Create your own ride</ul>
                        <ul>Create your own ride</ul>
                    </div>
                </div>
                <div class="slider">
                    <div class="slide-track">
                        <div class="slide">
                            <img src="image/homepage/driver1.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver2.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver3.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver4.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver5.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver6.jpg" alt="Driver Features">
                        </div>
                    </div>
                </div>
            </div>
            <div class="driver-features-slider">
                <div class="slider">
                    <div class="slide-track">
                        <div class="slide">
                            <img src="image/homepage/driver1.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver2.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver3.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver4.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver5.jpg" alt="Driver Features">
                        </div>
                        <div class="slide">
                            <img src="image/homepage/driver6.jpg" alt="Driver Features">
                        </div>
                    </div>
                </div>
                <div class="driver-content-container">
                    <h5>Passenger Features</h5>
                    <h2>Create your ride and start earning!</h2>
                    <div class="driver-list-style">
                        <ul>Create your own ride</ul>
                        <ul>Create your own ride</ul>
                        <ul>Create your own ride</ul>
                    </div>
                </div>
            </div>
            <div class="wave" id="wave1" style="--i:1;"></div>
            <div class="wave" id="wave2" style="--i:2;"></div>
            <div class="wave" id="wave3" style="--i:3;"></div>
            <div class="wave" id="wave4" style="--i:4;"></div>
        </div>
        <div class="ourservices">
            <br><br><br>
            <h1>Choose Your Role</h1>
            <br><br><br>
            <div class="rolecard">
                <div class="role">
                    <div class="icon">
                        <img src="image/homepage/driver.png" alt="driver icon" width="130px" height="120px">
                    </div>
                    <h2>Driver</h2>
                    <p>Join our community of drivers and start earning by sharing your rides with passengers heading in
                        the same direction.</p>
                    <a href="/driver" class="learn-more">Sign Up</a>
                </div>
                <div class="role">
                    <div class="icon">
                        <img src="image/homepage/passenger.png" alt="passenger icon" width="120px" height="110px">
                    </div>
                    <h2>Passenger</h2>
                    <p>Find convenient and affordable rides to your destination. Connect with reliable drivers in your
                        area.</p>
                    <a href="/passenger" class="learn-more">Sign Up</a>
                </div>
            </div>
        </div>
        <div class="benefits">
            <br><br><br>
            <h1>Carpool Today, produce a better day!</h1>
            <div class="feature-container swiper">
                <div class="feature-wrapper">
                    <div class="feature-list swiper-wrapper">
                        <div class="feature-item swiper-slide">
                            <h2>Cost Saving & Convenience</h2>
                            <p>Share the Ride, Split the Cost, Enjoy the Journey!</p>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>Earnings</h2>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>name</h2>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>name</h2>
                        </div>
                    </div>
                    <br><br>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-slide-button swiper-button-prev"></div>
                    <div class="swiper-slide-button swiper-button-next"></div>
                </div>
            </div>
        </div>
        <script>
            let wave1 = document.getElementById('wave1');
            let wave2 = document.getElementById('wave2');
            let wave3 = document.getElementById('wave3');
            let wave4 = document.getElementById('wave4');

            windows.addEventListener('scroll', function () {
                let value = window.scrollY;

                wave1.style.backgroundPositionX = 400 + value * 4 + 'px';
                wave2.style.backgroundPositionX = 300 + value * -4 + 'px';
                wave3.style.backgroundPositionX = 200 + value * 2 + 'px';
                wave4.style.backgroundPositionX = 100 + value * -2 + 'px';
            })
        </script>
        <script>
            // Add event listeners for real-time validation
            document.getElementById('pickup').addEventListener('change', validateSelection);
            document.getElementById('dropoff').addEventListener('change', validateSelection);

            function validateSelection() {
                let pickup = document.getElementById('pickup').value;
                let dropoff = document.getElementById('dropoff').value;
                let pickupError = document.getElementById('pickup-error');
                let dropoffError = document.getElementById('dropoff-error');

                if (pickup && dropoff && pickup === dropoff) {
                    pickupError.style.display = 'inline';
                    dropoffError.style.display = 'inline';
                } else {
                    pickupError.style.display = 'none';
                    dropoffError.style.display = 'none';
                }
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="js/homepage/swiper.js"></script>
    </div>
</body>

</html>