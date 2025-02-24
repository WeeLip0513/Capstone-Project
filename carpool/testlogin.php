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
                    <input type="text" placeholder="TP Number" name="tpnumber" />
                    <label></label>
                    <div class="error"></div>
                </div>
                <div class="infield">
                    <input type="password" placeholder="Password" name="password" />
                    <label></label>
                    <div class="error"></div>
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById('form');
            const tpnumber = document.querySelector('input[name="tpnumber"]');
            const password = document.querySelector('input[name="password"]');

            form.addEventListener('submit', (e) => {
                let isValid = validateInputs();
                if (!isValid) {
                    e.preventDefault(); // Prevent form submission if validation fails
                }
            });

            const setError = (element, message) => {
                const inputControl = element.parentElement;
                const errorDisplay = inputControl.querySelector('.error');

                errorDisplay.innerText = message;
                inputControl.classList.add('error');
                inputControl.classList.remove('success')
            }

            const setSuccess = element => {
                const inputControl = element.parentElement;
                const errorDisplay = inputControl.querySelector('.error');

                errorDisplay.innerText = '';
                inputControl.classList.add('success');
                inputControl.classList.remove('error');
            };

            const validateInputs = () => {
                const tpnumberValue = tpnumber.value.trim();
                const passwordValue = password.value.trim();

                if (tpnumberValue === '') {
                    setError(tpnumber, 'Username is required');
                } else {
                    setSuccess(tpnumber);
                }
                if (passwordValue === '') {
                    setError(password, 'Password is required');
                } else {
                    setSuccess(password);
                }
                
            }
            return isValid;
        });

        //     function setError(element, message) {
        //         const inputGroup = element.parentElement;
        //         const label = inputGroup.querySelector('label');
        //         let errorMsg = inputGroup.querySelector('.error-message');

        //         if (!errorMsg) {
        //             errorMsg = document.createElement('div');
        //             errorMsg.className = 'error-message';
        //             inputGroup.appendChild(errorMsg);
        //         }

        //         errorMsg.textContent = message;
        //         errorMsg.style.color = "red";
        //         label.style.color = "red";
        //         element.classList.add('error-input');
        //     }

        //     function setSuccess(element, defaultText) {
        //         const inputGroup = element.parentElement;
        //         const label = inputGroup.querySelector('label');
        //         let errorMsg = inputGroup.querySelector('.error-message');

        //         if (errorMsg) {
        //             errorMsg.remove();
        //         }

        //         label.style.color = "green";
        //         element.classList.remove('error-input');
        //     }

        //     function validateInputs() {
        //         let isValid = true;

        //         if (tpnumber.value.trim() === '') {
        //             setError(tpnumber, 'TP Number is required');
        //             isValid = false;
        //         } else {
        //             setSuccess(tpnumber, 'TP Number');
        //         }

        //         if (password.value.trim() === '') {
        //             setError(password, 'Password is required');
        //             isValid = false;
        //         } else {
        //             setSuccess(password, 'Password');
        //         }

        //         return isValid;
        //     }
        // });

    </script>



</body>

</html>