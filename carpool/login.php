<!-- <?php
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
    <div class="login-all-container" id="login-all-container">
        <div class="login-container sign-up-container">
            <form action="#">
                <h1>Register</h1>
                <div class="infield">
                    <input type="name" placeholder="Name" name="name" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="text" placeholder="TP Number" name="tpnumber" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="email" placeholder="Email" name="email" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" />
                    <label></label>
                </div>
                <button class="log-button">Register</button>
            </form>
        </div>
        <div class="login-container sign-in-container">
            <form action="#">
                <h1>Login</h1>
                <div class="infield">
                    <input type="text" placeholder="TP Number" name="tpnumber" />
                    <label></label>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" />
                    <label></label>
                </div>
                <a href="#" class="forgot">Forgot your password?</a>
                <br>
                <button class="log-button" id="loginBtn">Login</button>
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
                    <p>Starts your journey with us</p>
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


</html> -->