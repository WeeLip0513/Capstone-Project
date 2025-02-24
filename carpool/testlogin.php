<?php
include("dbconn.php");
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="login-all-container" id="login-all-container">
        <div class="login-container sign-up-container">
            <h1>Register As</h1>
            <button class="log-button" onclick="location.href='passengerRegistration.php'">Passenger</button>
            <button class="log-button" onclick="location.href='driverRegistration.php'">Driver</button>
        </div>
        <div class="login-container sign-in-container">
            <form action="testloginvalid.php" method="POST">
                <h1>Login</h1>
                <div class="infield">
                    <input type="text" placeholder="TP Number" name="tpnumber" required />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" name="password" required />
                    <label></label>
                </div>
                <a href="#" class="forgot">Forgot your password?</a>
                <br>
                <button class="log-button" id="loginBtn" type="submit">Login</button>
            </form>
        </div>

        <div class="overlay-container" id="overlay-Con">
            <div class="overlay">
                <div class="overlay-panel signup-left">
                    <h1>Welcome Back!</h1>
                    <p>Experience Unique Service</p>
                    <button class="log-button">Sign In</button>
                </div>
                <div class="overlay-panel signup-right">
                    <h1>Let's Ride!</h1>
                    <p>Start your journey with us</p>
                    <button class="log-button" id="signUpBtn">Sign Up</button>
                </div>
            </div>
            <button id="overlayBtn"></button>
        </div>
    </div>

    <script>
        const loginallcontainer = document.getElementById('login-all-container')
        const overlayCon = document.getElementById('overlay-Con')
        const overlayBtn = document.getElementById('overlayBtn')

        overlayBtn.addEventListener('click', () => {
            loginallcontainer.classList.toggle('signup-right-active')

            overlayBtn.classList.remove('btnScaled');
            window.requestAnimationFrame(() => {
                overlayBtn.classList.add('btnScaled');
            })
        })
    </script>
    


</body>

</html>