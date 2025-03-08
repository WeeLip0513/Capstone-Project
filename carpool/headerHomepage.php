<?php
include("dbconn.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/headerHomepage.css">
    <link rel="icon" type="image/png" href="image/icon-logo.png">

    <!-- <title>headerHomepage</title> -->
</head>

<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    ?>

    <div class="navbar">
        <div class="logo"><img src="image/logo.png" alt="logo"></div>
        <ul class="navlinks">
            <li><a href="homepage.php" class="<?= ($currentPage == 'homepage.php') ? 'active' : '' ?>">Home</a></li>
            <li><a href="#" class="<?= ($currentPage == 'about.php') ? 'active' : '' ?>">About Us</a></li>
            <li><a href="passenger/passengerPage.php"
                    class="<?= ($currentPage == 'passengerPage.php') ? 'active' : '' ?>">Passenger</a></li>
            <li><a href="driverRegistration.php"
                    class="<?= ($currentPage == 'driverRegistration.php') ? 'active' : '' ?>">Driver</a></li>
            <li><a href="#" class="<?= ($currentPage == 'news.php') ? 'active' : '' ?>">News</a></li>
            <li><a href="#" class="<?= ($currentPage == 'support.php') ? 'active' : '' ?>">Support</a></li>
        </ul>
        <div class="buttons">
            <a href="loginpage.php"><button class="login">Login</button></a>
            <a href="loginpage.php?action=signup"><button class="signup">Sign Up</button></a>
        </div>
    </div>

</body>

</html>