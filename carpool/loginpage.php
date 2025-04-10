<?php
include("dbconn.php");
include("headerHomepage.php");

$showSignup = isset($_GET['action']) && $_GET['action'] === 'signup';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="css/loginPage/login.css">
    <link rel="stylesheet" href="css/mobile/loginmobile.css">
</head>

<body>
    <div class="login-wrap">
        <div class="login-all-container <?= $showSignup ? 'signup-right-active' : '' ?>" id="login-all-container">
            <div class="login-container sign-in-container <?= !$showSignup ? 'active' : '' ?>">
                <form id="form" action="/Capstone-Project/carpool/php/login/loginValid.php" method="POST">
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
            <div class="login-container sign-up-container <?= $showSignup ? 'active' : '' ?>">
                <h1>Register As</h1>
                <button class="log-button" onclick="location.href='passengerRegistration.php'">Passenger</button>
                <button class="log-button" onclick="location.href='driverRegistration.php'">Driver</button>
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
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Check if we came from navbar signup
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('action') === 'signup') {
                // Trigger the sliding effect after short delay
                setTimeout(() => {
                    document.querySelector('.login-all-container').classList.add('signup-right-active');
                }, 100);
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const overlayBtn = document.getElementById('overlayBtn');
            const container = document.getElementById('login-all-container');
            const signInBtn = document.getElementById('signInBtn');
            const signUpBtn = document.getElementById('signUpBtn');

            if (overlayBtn) {
                overlayBtn.addEventListener('click', function () {
                    container.classList.toggle('signup-right-active');
                    overlayBtn.classList.toggle('btnScaled');
                });
            }

            if (signInBtn) {
                signInBtn.addEventListener('click', function () {
                    container.classList.remove('signup-right-active');
                });
            }

            if (signUpBtn) {
                signUpBtn.addEventListener('click', function () {
                    container.classList.add('signup-right-active');
                });
            }

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
            tpInput.addEventListener('focus', function () {
                tpLabel.style.width = '100%';
            });

            tpInput.addEventListener('blur', function () {
                // Only shrink the line if there's no value AND no error showing
                if (!this.value.trim() && tpError.style.display === 'none') {
                    tpLabel.style.width = '0%';
                }
            });

            passwordInput.addEventListener('focus', function () {
                passwordLabel.style.width = '100%';
            });

            passwordInput.addEventListener('blur', function () {
                // Only shrink the line if there's no value AND no error showing
                if (!this.value.trim() && passwordError.style.display === 'none') {
                    passwordLabel.style.width = '0%';
                }
            });

            // Form validation on submit
            form.addEventListener('submit', function (event) {
                let isValid = true;

                // Validate TP number
                if (!tpInput.value.trim()) {
                    tpError.style.display = 'block';
                    tpLabel.style.width = '100%';
                    tpLabel.style.background = 'red';
                    isValid = false;
                } else {
                    tpError.style.display = 'none';
                    tpLabel.style.background = 'green';
                }

                // Validate password
                if (!passwordInput.value.trim()) {
                    passwordError.style.display = 'block';
                    passwordLabel.style.width = '100%';
                    passwordLabel.style.background = 'red';
                    isValid = false;
                } else {
                    passwordError.style.display = 'none';
                    passwordLabel.style.background = 'green';
                }

                // Prevent submission if validation fails
                if (!isValid) {
                    event.preventDefault();
                }
            });

            // Real-time validation feedback
            tpInput.addEventListener('input', function () {
                if (this.value.trim()) {
                    tpError.style.display = 'none';
                    tpLabel.style.background = 'green';
                    tpLabel.style.width = '100%';
                } else {
                    tpError.style.display = 'block';
                    tpLabel.style.background = 'red';
                    tpLabel.style.width = '100%';
                }
            });

            passwordInput.addEventListener('input', function () {
                if (this.value.trim()) {
                    passwordError.style.display = 'none';
                    passwordLabel.style.background = 'green';
                    passwordLabel.style.width = '100%';
                } else {
                    passwordError.style.display = 'block';
                    passwordLabel.style.background = 'red';
                    passwordLabel.style.width = '100%';
                }
            });
        });
    </script>

    <iframe name="hiddenFrame" style="display:none;"></iframe>

    <div id="passwordResetModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h2>Reset Password</h2>
            <form action="/Capstone-Project/carpool/php/login/token-sent.php" method="POST" id="resetPasswordForm"
                target="hiddenFrame">
                <div class="infield">
                    <input type="email" name="email" id="email" placeholder="Registered email">
                    <label></label>
                </div>
                <br>
                <button type="submit" class="log-button">Send Reset Link</button>
            </form>
            <div id="resetFeedback"></div>
        </div>
    </div>

    <script src="js/login/forgotpassword.js">//show modal script</script>

</body>

</html>
<?php include('footer.php'); ?>