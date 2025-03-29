<?php
include("dbconn.php");
include("headerHomepage.php");
?>
<!DOCTYPE html>
<html lang="en">
<hr>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="css/homepage/aboutUs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="about-container">
        <div class="introduction">
            <h1>About</h1>
            <div class="logo-image">
                <img src="image/logo.png" alt="APool logo">
            </div>
        </div>
        <div class="intro-description">
            <h3>Who We Are, What We Do, and Why We Ride.</h3>
        </div>
        <div class="about-us">
            <div class="about-container-2">
                <div class="about-des">
                    <div class="about-image">
                    <img src="image/logo.png" alt="APool logo">
                    </div>
                    <div class="our-story">
                    <h1>Our Story</h1>
                    <p>
                    Welcome to APool! Our website is a reliable and user-friendly carpooling platform designed to 
                    make commuting more affordable and eco-friendly. 
                    We connect riders with trusted drivers, helping reduce traffic congestion, fuel costs, 
                    and carbon emissions. Whether you're commuting to work, school, or traveling long distances, 
                    our service ensures a safe, convenient, and cost-effective journey.
                    With an intuitive interface, real-time ride tracking, and secure payment options, 
                    we prioritize safety and ease of use. Our mission is to build a strong community 
                    of commuters who share rides, save money, and contribute to a greener planet.
                    We believe in creating a smarter way to travel by encouraging carpooling as a 
                    sustainable alternative to solo driving. By joining us, you become part of a movement 
                    that promotes shared mobility, fosters social connections, makes daily travel more 
                    enjoyable.
                    </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mission-vision-container">
            <div class="mission-vision-des">
                <h1>Mission and Vision</h1>
                <div class="mission">
                    <h2>Our Mission</h2>
                    <p>Our mission is to provide a reliable, affordable, and eco-friendly carpooling platform 
                        that connects commuters for a smarter way to travel. We aim to reduce traffic congestion, 
                        lower commuting costs, and minimize carbon emissions while ensuring a safe, convenient, 
                        and user-friendly experience for both drivers and riders.We strive to foster a shared passion for 
                        discovery and ride exploration across Asia Pacific University, promoting sustainability and shared mobility.
                        We are committed to creating a transportation network that 
                        enhances connectivity and improves overall travel experiences.</p>
                </div>
                <div class="vision">
                    <h2>Our Vision</h2>
                    <p>Our vision is to create a world where shared mobility is the preferred choice for daily commuting. 
                        By fostering a strong community of carpoolers, we strive to build a future with reduced traffic, 
                        lower pollution, and a more connected society, making transportation more efficient, sustainable, 
                        and accessible for everyone, ensuring convenience, affordability, and environmental responsibility.
                        By integrating smart and user-friendly features, we strive to make sustainable transportation 
                        effortless.Together, we drive toward a smarter and more sustainable future for generations to come.</p>
                </div>
            </div>
        </div>
        <div class="core-values-container">
            <div class="core-values">
                <h1>Our Core Values</h1>
                <div class="core-elements">
                    <div class="element">
                        <i class="fas fa-shield-alt"></i>
                        <h3>Safety</h3>
                    </div>
                    <div class="element">
                        <i class="fas fa-users"></i>
                        <h3>Community</h3>
                    </div>
                    <div class="element">
                        <i class="fas fa-hand-holding-usd"></i>
                        <h3>Affordability</h3>
                    </div>
                    <div class="element">
                        <i class="fas fa-leaf"></i>
                        <h3>Sustainability</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="our-team-container">
            <div class="our-team">
                <h1>Meet Our Team</h1>
                <div class="member-row">
                    <div class="member">
                        <h3>Nicole Ho Ni Hung</h3>
                        <p>Frontend & Backend Developer</p>
                    </div>
                    <div class="member">
                        <h3>Ong Wei Zhi</h3>
                        <p>Project Manager</p>
                    </div>
                    <div class="member">
                        <h3>Ng Wee Lip</h3>
                        <p>Frontend & Backend Developer</p>
                    </div>
                </div>
                <div class="member-row-2">
                    <div class="member">
                        <h3>Sean Ng Zhi Xuan</h3>
                        <p>Frontend Developer</p>
                    </div>
                    <div class="member">
                        <h3>Nicholas Ong Kah Hao</h3>
                        <p>Frontend Developer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php include('footer.php'); ?>