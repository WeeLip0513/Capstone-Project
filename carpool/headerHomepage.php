<?php
include("dbconn.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/homePage/headerHomepage.css">
    <link rel="stylesheet" href="css/mobile/headermobile.css">
    <link rel="icon" type="image/png" href="image/icon-logo.png">

    <!-- <title>headerHomepage</title> -->
</head>

<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <div class="navbar">
        <div class="logo">
            <a href="homepage.php">
                <img src="image/logo.png" alt="logo">
            </a>
        </div>
        <ul class="navlinks">
            <li><a href="homepage.php" class="<?= ($currentPage == 'homepage.php') ? 'active' : '' ?>">Home</a></li>
            <li><a href="#" class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>">About Us</a></li>
            <li><a href="passengerRegistration.php"
                    class="<?= ($currentPage == 'passengerRegistration.php') ? 'active' : '' ?>">Passenger</a></li>
            <li><a href="driverRegistration.php"
                    class="<?= ($currentPage == 'driverRegistration.php') ? 'active' : '' ?>">Driver</a></li>
            <li><a href="#" class="<?= ($currentPage == 'news.php') ? 'active' : '' ?>">News</a></li>
            <li><a href="#" class="<?= ($currentPage == 'support.php') ? 'active' : '' ?>">Support</a></li>
        </ul>
        <div class="buttons">
            <a href="loginpage.php"><button class="login">Login</button></a>
            <a href="loginpage.php?action=signup"><button class="signup">Sign Up</button></a>
        </div>
        <div class="hamburger" onclick="toggleMenu()">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
    <script>
        function toggleMenu() {
            const hamburger = document.querySelector('.hamburger');
            const navlinks = document.querySelector('.navlinks');
            const buttons = document.querySelector('.buttons');
            hamburger.classList.toggle('active');
            navlinks.classList.toggle('active');
            buttons.classList.toggle('active');
        }
        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            const hamburger = document.querySelector('.hamburger');
            const navlinks = document.querySelector('.navlinks');
            const buttons = document.querySelector('.buttons');

            if (!hamburger.contains(event.target) &&
                !navlinks.contains(event.target) &&
                !buttons.contains(event.target)) {
                hamburger.classList.remove('active');
                navlinks.classList.remove('active');
                buttons.classList.remove('active');
            }
        });

        // Close menu when clicking nav items
        document.querySelectorAll('.navlinks a').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelector('.hamburger').classList.remove('active');
                document.querySelector('.navlinks').classList.remove('active');
                document.querySelector('.buttons').classList.remove('active');
            });
        });
    </script>
</body>

</html>