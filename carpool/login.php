<?php
include("dbconn.php");
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">

</head>

<body>
    <div class="login-all-container">
        <div class="login-container">
            <form action="#">
                <h1>Login</h1>
                <div class="infield">
                    <input type="email" placeholder="Email" name="email" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" />
                    <label></label>
                </div>
                <a href="#" class="forgot">Forgot your password?</a>
                <br>
                <button class="log-button">Login</button>
            </form>
        </div>
        <div class="overlay-container" id="overlay-Con">
            <div class="overlay">
                <div class="overlay-signup">
                    <h1>Let's Ride!</h1>
                    <p>Starts your journey with us</p>
                    <button class="log-button">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>