<?php
    include("dbconn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/headerHomepage.css">
    <!-- <title>headerHomepage</title> -->
</head>
<body>
    <div class="navbar">
        <div class="logo">APool</div>
        <ul class = "navlinks">
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">Passenger</a></li>
            <li><a href="#">Driver</a></li>
            <li><a href="#">News</a></li>
            <li class="dropdown">
                <a href="#">Support</a>
                <ul class="dropdown-content">
                    <li><a href="">FAQ</a></li>
                </ul>   
            </li>
        </ul>
        <div class="buttons">
            <button class="login">Login</button>
            <button class="signup">Sign Up</button>
        </div>
    </div>
    <!-- for home page -->
</body>
</html>