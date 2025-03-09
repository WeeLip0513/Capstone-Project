<?php
include("dbconn.php");
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Registration</title>
    <link rel="stylesheet" href="css/passengerPage/passengerReg.css">
</head>

<body>
    <div class="regContainer">
        <div class="pass-register">
            <form method="post" action="/Capstone-Project/carpool/passenger/passengerValid.php">
                <h1>Register as Passenger</h1>

                <div class="step active" data-step="1">
                    <div class="input-field">
                        <input type="text" id="firstname" name="firstname" placeholder="First Name">
                        <span class="error" id="firstnameError">First Name is required</span>
                    </div>
                    <div class="input-field">
                        <input type="text" id="lastname" name="lastname" placeholder="Last Name">
                        <span class="error" id="lastnameError">Last Name is required</span>
                    </div>
                    <div class="button-group">
                        <button type="button" class="confirm-button next-btn">Next</button>
                    </div>
                </div>

                <div class="step" data-step="2">
                    <div class="input-field">
                        <input type="text" id="tpnumber" name="tpnumber" placeholder="TP Number">
                        <span class="error" id="tpError">TP Number is required</span>
                    </div>
                    <div class="input-field">
                        <input type="password" id="password" name="password" placeholder="Password">
                        <span class="error" id="passwordError">Passwords is required</span>
                    </div>
                    <div class="button-group">
                        <button type="button" class="confirm-button prev-btn">Previous</button>
                        <button type="button" class="confirm-button next-btn">Next</button>
                    </div>
                </div>

                <div class="step" data-step="3">
                    <div class="input-field">
                        <input type="text" id="phoneNo" name="phoneNo" placeholder="Phone No.">
                        <span class="error" id="phoneNoError">Phone No is required</span>
                    </div>
                    <div class="button-group">
                        <button type="button" class="confirm-button prev-btn">Previous</button>
                        <button type="submit" class="confirm-button">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const steps = document.querySelectorAll('.step');
            let currentStep = 0;

            //first step 
            showStep(currentStep);

            document.querySelectorAll('.next-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    if (validateStep(currentStep)) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            document.querySelectorAll('.prev-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    currentStep--;
                    showStep(currentStep);
                });
            });

            function showStep(stepIndex) {
                steps.forEach((step, index) => {
                    step.classList.toggle('active', index === stepIndex);
                });
            }

            function validateStep(stepIndex) {
                let isValid = true;
                const currentStepInputs = steps[stepIndex].querySelectorAll('input');

                currentStepInputs.forEach(input => {
                    if (!input.checkValidity()) {
                        input.classList.add('error-state');
                        isValid = false;
                    } else {
                        input.classList.remove('error-state');
                    }
                });

                return isValid;
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const firstName = document.getElementById('firstname');
            const lastName= document.getElementById('lastname');
            const tpNumber= document.getElementById('tpnumber');
            const password= document.getElementById('lastname');
            const phoneNo= document.getElementById('phoneNo');

            // password validation 
            const minLength = 8;
            const requiresUppercase = true;
            const requiresNumber = true;
            const requiresSpecialChar = true;

            function validatePassword() {
                const value = password.value.trim();
                let valid = true;
                const errorElement = document.getElementById('passwordError');

                clearVisualState(password);
                errorElement.textContent = '';

                if (value.length < minLength) {
                    showError(password, `Password must be at least ${minLength} characters`);
                    valid = false;
                }
                if (requiresUppercase && !/[A-Z]/.test(value)) {
                    showError(password, 'Password must contain at least one uppercase letter');
                    valid = false;
                }
                if (requiresNumber && !/[0-9]/.test(value)) {
                    showError(password, 'Password must contain at least one number');
                    valid = false;
                }
                if (requiresSpecialChar && !/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value)) {
                    showError(password, 'Password must contain at least one special character');
                    valid = false;
                }
                if (valid && value.length > 0) {
                    showSuccess(password);
                }

                return valid;
            }


            function showError(input, message) {
                const errorElement = document.getElementById(input.id + 'Error');
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                input.classList.add('error-state');
                input.classList.remove('success-state');
            }

            function showSuccess(input) {
                input.classList.add('success-state');
                input.classList.remove('error-state');
                document.getElementById(input.id + 'Error').style.display = 'none';
            }

            function clearVisualState(input) {
                input.classList.remove('error-state', 'success-state');
            }

            // real-time validation
            password.addEventListener('input', function () {
                const isPasswordValid = validatePassword();
                // validate confirmation if password is valid
                if (isPasswordValid && passwordConfirm.value.trim() !== '') {
                    validatePasswordConfirm();
                }
            });

            passwordConfirm.addEventListener('input', function () {
                if (password.value.trim() !== '') {
                    validatePasswordConfirm();
                }
            });

            // final validation on form submission
            form.addEventListener('submit', function (e) {
                const isPasswordValid = validatePassword();
                const isConfirmValid = validatePasswordConfirm();

                if (!isPasswordValid || !isConfirmValid) {
                    e.preventDefault();
                    // display all errors
                    document.querySelectorAll('.error').forEach(error => {
                        error.style.display = 'block';
                    });
                }
            });
        });
    </script>

</body>
</body>

</html>