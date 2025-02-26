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
            <form id="form" action="testloginvalid.php" method="POST">
                <h1>Login</h1>
                <div class="infield">
                    <input type="text" placeholder="TP Number" name="tpnumber" id="tpnumber" />
                    <label id="tpLabel"></label>
                </div>
                <span class="error" id="tpError">TP Number is required</span>
                <div class="infield">
                    <input type="password" placeholder="Password" name="password" id="password" />
                    <label id="passwordLabel"></label>
                </div>
                <span class="error" id="passwordError">Password is required</span>
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('form');
        const tpInput = document.getElementById('tpnumber');
        const passwordInput = document.getElementById('password');
        const tpError = document.getElementById('tpError');
        const passwordError = document.getElementById('passwordError');
        const tpLabel = document.getElementById('tpLabel');
        const passwordLabel = document.getElementById('passwordLabel');

        // Initially hide error messages
        tpError.style.display = 'none';
        passwordError.style.display = 'none';

        // Add focus events to animate label width
        tpInput.addEventListener('focus', function() {
            tpLabel.style.width = '100%';
        });

        tpInput.addEventListener('blur', function() {
            // Only shrink the line if there's no value AND no error showing
            if (!this.value.trim() && tpError.style.display === 'none') {
                tpLabel.style.width = '0%';
            }
        });

        passwordInput.addEventListener('focus', function() {
            passwordLabel.style.width = '100%';
        });

        passwordInput.addEventListener('blur', function() {
            // Only shrink the line if there's no value AND no error showing
            if (!this.value.trim() && passwordError.style.display === 'none') {
                passwordLabel.style.width = '0%';
            }
        });

        // Form validation on submit
        form.addEventListener('submit', function(event) {
            let isValid = true;

            // Validate TP number
            if (!tpInput.value.trim()) {
                tpError.style.display = 'block';
                tpLabel.style.width = '100%';
                tpLabel.style.background = 'red';
                isValid = false;
            } else {
                tpError.style.display = 'none';
                tpLabel.style.background = 'var(--linear-grad)';
            }

            // Validate password
            if (!passwordInput.value.trim()) {
                passwordError.style.display = 'block';
                passwordLabel.style.width = '100%';
                passwordLabel.style.background = 'red';
                isValid = false;
            } else {
                passwordError.style.display = 'none';
                passwordLabel.style.background = 'var(--linear-grad)';
            }

            // Prevent submission if validation fails
            if (!isValid) {
                event.preventDefault();
            }
        });

        // Real-time validation feedback
        tpInput.addEventListener('input', function() {
            if (this.value.trim()) {
                tpError.style.display = 'none';
                tpLabel.style.background = 'green';
                tpLabel.style.width = '100%';
            }
        });

        passwordInput.addEventListener('input', function() {
            if (this.value.trim()) {
                passwordError.style.display = 'none';
                passwordLabel.style.background = 'green';
                passwordLabel.style.width = '100%';
            }
        });
    });
    </script>



</body>

</html>