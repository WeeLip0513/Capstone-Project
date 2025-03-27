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
    <link rel="stylesheet" href="css/homePage/homepage.css">
    <link rel="stylesheet" href="css/homePage/whychooseApool.css">
    <link rel="stylesheet" href="css/homePage/howitworks.css">
    <link rel="stylesheet" href="css/homePage/featuresSlider.css">
    <link rel="stylesheet" href="css/homePage/cardFeature.css">
    <link rel="stylesheet" href="css/homePage/roleSelect.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>

<body>
    <div class="homepage-container">
        <div class="center-wrap">
            <div class="main-content">
                <h1>Travel Smart, Save Together</h1>
                <p>Connect with students going your way - Save money, reduce traffic and make new friends!</p>
                <div class="search-card">
                    <div class="search-selection" id="rideSearch">
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
                        <div class="input-wrapper">
                            <div class="input-ride">
                                <i class="fas fa-calendar-alt"></i>
                                <input class="card-holder" type="date" required>
                            </div>
                            <span id="date-error" class="error-message">Please select a date!</span>
                        </div>
                        <div class="input-wrapper">
                            <div class="input-ride">
                                <i class="fas fa-clock"></i>
                                <input class="card-holder" type="time" required>
                            </div>
                            <span id="time-error" class="error-message">Please select a time!</span>
                        </div>
                    </div>
                    <button class="btn-login">Search Rides</button>
                </div>
            </div>
        </div>
        <div id="modal" class="modal" style="display: none;">
            <div class="modal-content">
                <p id="modal-message">
                    Searching<span class="dots">
                        <span class="dot">.</span>
                        <span class="dot">.</span>
                        <span class="dot">.</span>
                    </span>
                </p>
            </div>
        </div>
        <section class=" section features-section">
            <div class="features-title">
                <h2>Why Choose APool ?</h2>
                <p>Introducing the new convenient and affordable commuting solutions for students</p>
            </div>
            <div class="feature-container">
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <h3>Save Money</h3>
                        <p>Split travel costs with fellow students and reduce your daily commuting expenses. Perfect for
                            budget-conscious students.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h3>Save Time</h3>
                        <p>Skip waiting for public transport and enjoy direct rides to your destination, making your
                            schedule more efficient.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-content">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Meet New People</h3>
                        <p>Connect with like-minded students, expand your social circle, and make your commute more
                            enjoyable.</p>
                    </div>
                </div>
            </div>
        </section>
        <section class="section how-it-works">
            <h2>How It Works</h2>
            <div class="steps-container">
                <div class="step">
                    <h3>1. Search/Post</h3>
                    <p>Find or offer a ride in seconds</p>
                </div>
                <div class="step">
                    <h3>2. Match & Connect</h3>
                    <p>Get instant ride matches</p>
                </div>
                <div class="step">
                    <h3>3. Ride & Share</h3>
                    <p>Travel together and save</p>
                </div>
            </div>
            <div class="progress-container">
                <div class="progress-bar">
                    <div class="progress-fill"></div>
                </div>
                <div class="progress-car"></div>
                <div class="progress-markers">
                    <div class="marker" data-step="1"></div>
                    <div class="marker" data-step="2"></div>
                    <div class="marker" data-step="3"></div>
                </div>
            </div>
        </section>
        <section class="section second-section">
            <div class="slider-wrap">
                <div class="driver-features-slider">
                    <div class="driver-content-container">
                        <h5>Driver Features</h5>
                        <h2>Create your ride and start earning!</h2>
                        <div class="driver-list-style">
                            <ul>Create your own ride</ul>
                            <ul>Set your own schedule</ul>
                            <ul>Earn money flexibly</ul>
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
            </div>
            <div class="slider-wrap">
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
                        <h2>Find rides that match your need!</h2>
                        <div class="driver-list-style">
                            <ul>Search for rides easily</ul>
                            <ul>Choose preferred drivers</ul>
                            <ul>Travel comfortably</ul>
                        </div>
                    </div>
                </div>
            </div>

        </section>
        <div class="wave-container">
            <div class="wave" id="wave1" style="--i:1;"></div>
            <div class="wave" id="wave2" style="--i:2;"></div>
            <div class="wave" id="wave3" style="--i:3;"></div>
            <div class="wave" id="wave4" style="--i:4;"></div>
        </div>

        <script>
            let wave1 = document.getElementById('wave1');
            let wave2 = document.getElementById('wave2');
            let wave3 = document.getElementById('wave3');
            let wave4 = document.getElementById('wave4');

            window.addEventListener('scroll', function () {
                let value = window.scrollY;

                wave1.style.backgroundPositionX = 400 + value * 4 + 'px';
                wave2.style.backgroundPositionX = 300 + value * -4 + 'px';
                wave3.style.backgroundPositionX = 200 + value * 2 + 'px';
                wave4.style.backgroundPositionX = 100 + value * -2 + 'px';
            })
        </script>
        <section class="roles-section">
            <div class="section-title">
                <h2>Choose Your Role</h2>
                <p>Whether you're offering rides or looking for one, we've got you covered</p>
            </div>
            <div class="role-cards">
                <div class="role-card">
                    <div class="role-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3>Driver</h3>
                    <p>Have a car? Turn empty seats into extra cash by offering rides to fellow students. Set your own
                        schedule and routes while helping others commute.</p>
                    <a href="driverRegistration.php" class="btn-role">Become a Driver</a>
                </div>
                <div class="role-card">
                    <div class="role-icon">
                        <i class="fas fa-walking"></i>
                    </div>
                    <h3>Passenger</h3>
                    <p>Need a ride? Find convenient and affordable transportation with verified student drivers. Book
                        rides in advance and travel with peace of mind.</p>
                    <a href="passengerRegistration.php" class="btn-role">Ride as Passenger</a>
                </div>
            </div>
        </section>

        <section class="benefits-section">
            <div class="benefits-container">
                <div class="benefits-header">
                    <h1>Carpool Today, produce a better day!</h1>
                    <a href="loginpage.php" class="shop-link">Book Now ></a>
                </div>

                <div class="benefits-cards-wrapper">
                    <div class="benefits-cards">
                        <div class="benefit-card" data-title="Reasonable Price Range"
                            data-subtitle="Save Big on Your Commute"
                            data-description="Share the ride and split the expenses! Reduce your commute costs by up to 50%">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="currentColor">
                                    <rect x="9" y="2" width="6" height="20" rx="2" />
                                    <rect x="4" y="7" width="16" height="10" rx="2" />
                                    <path d="M12 22v-4" />
                                </svg>
                            </div>
                            <h2>Cost Saving</h2>
                            <h3>&amp; Convenience.</h3>
                            <p>Share the ride, split the cost, and enjoy the journey together! Save up to 50% on your
                                daily commute costs.</p>
                            <button class="expand-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    stroke="currentColor">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="benefit-card" data-title="Extra Incomes for Drivers"
                            data-subtitle="Earn Extra Income Today"
                            data-description="Make money effortlessly by sharing your ride on routes you already take">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 2v6.5l3-3" />
                                    <path d="M12 2v6.5l-3-3" />
                                    <path d="M3.4 16.7L12 7.5l8.6 9.2" />
                                    <path d="M12 7.5V22" />
                                    <line x1="4" y1="12" x2="20" y2="12" />
                                </svg>
                            </div>
                            <h2>Earnings</h2>
                            <h3>for drivers.</h3>
                            <p>Turn your empty seats into extra income. Earn money on trips you're already taking with
                                minimal
                                detours.</p>
                            <button class="expand-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="benefit-card" data-title="Go Green with Shared Rides"
                            data-subtitle="Eco-friendly Transportation"
                            data-description="Enjoy sustainable EV transportation and help create a cleaner, greener world">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                            </div>
                            <h2>Eco-friendly</h2>
                            <h3>transportation.</h3>
                            <p>Reduce your carbon footprint and help the environment by sharing rides with others. Fewer
                                cars
                                means
                                less pollution.</p>
                            <button class="expand-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="benefit-card" data-title="Smooth Commutes, Less Stress"
                            data-subtitle="Reduced Traffic & Stress"
                            data-description="Wait too long for APU bus? Experience a peaceful journey back to home">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
                                </svg>
                            </div>
                            <h2>Reduced Traffic</h2>
                            <h3>& stress.</h3>
                            <p>Fewer vehicles on the road means less congestion. Enjoy a more relaxed commute when you
                                don't
                                have to
                                drive.</p>
                            <button class="expand-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>

                        <div class="benefit-card" data-title="Ride Safely Every Mile" data-subtitle="Safety & Security"
                            data-description="Your security is paramount. With verified users, enjoy a ride where safety is always guaranteed.">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                </svg>
                            </div>
                            <h2>Safety</h2>
                            <h3>& security.</h3>
                            <p>All users are verified with profiles and ratings. Our priority matching system ensures a
                                comfortable
                                experience.</p>
                            <button class="expand-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="benefit-card" data-title="Rides Just Around the Corner"
                            data-subtitle="Convenient Locations"
                            data-description="Never wait long for a ride. Our platform connects APU students with rides at your favorite spots, ensuring a quick and hassle-free commute.">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <h2>Convenient</h2>
                            <h3>locations.</h3>
                            <p>Find rides to and from your most frequent destinations. Set up recurring rides for
                                regular
                                commutes.
                            </p>
                            <button class="expand-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="carousel-footer">
                    <div class="divider-line"></div>
                    <div class="carousel-navigation">
                        <button class="prev-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <button class="next-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-overlay" id="modalOverlay">
                <div class="modal-container">
                    <!-- Left content (text) -->
                    <div class="modal-content-left">
                        <button class="modal-close" id="modalCloseBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                        <div class="modal-header">
                            <div class="modal-subtitle" id="modalSubtitle"></div>
                            <h2 id="modalTitle"></h2>
                        </div>
                        <p id="modalDescription"></p>
                    </div>
                </div>
            </div>
        </section>
        <script src="js/homepage/searchForm.js"></script>
        <script src="js/homepage/howitworks.js"></script>
        <script src="js/homepage/featureSlider.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="js/homepage/swiper.js"></script>
        <script>

        </script>
    </div>
</body>

</html>