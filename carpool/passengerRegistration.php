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
            <form method="post" action="/Capstone-Project/carpool/php/register/passengerValid.php">
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
                        <span class="error" id="tpnumberError">TP Number is required</span>
                    </div>
                    <div class="input-field">
                        <input type="password" id="password" name="password" placeholder="Password">
                        <span class="error" id="passwordError">Password is required</span>
                    </div>
                    <div class="button-group">
                        <button type="button" class="confirm-button prev-btn">Previous</button>
                        <button type="button" class="confirm-button next-btn">Next</button>
                    </div>
                </div>

                <div class="step" data-step="3">
                    <div class="input-field">
                        <input type="text" id="email" name="email" placeholder="Email">
                        <span class="error" id="emailError">Email is required</span>
                    </div>
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
            const form = document.querySelector('form');
            const steps = document.querySelectorAll('.step');
            let currentStep = 0;

            // Prevent Enter key from submitting the form unless on step 3
            // form.addEventListener('keydown', function (e) {
            //     if (e.key === 'Enter' && currentStep < steps.length - 1) {
            //         e.preventDefault();
            //         return false;
            //     }
            // });

            //first step 
            showStep(currentStep);

            form.addEventListener('input', function (e) {
                const input = e.target;
                const parentStep = input.closest('.step');
                if (parentStep && parentStep.classList.contains('active')) {
                    validateStep(currentStep);
                }
            });

            document.querySelectorAll('.next-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    if (validateStep(currentStep)) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            document.querySelectorAll('.prev-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
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

                const currentStepElement = steps[stepIndex];
                currentStepElement.querySelectorAll('.error').forEach(error => {
                    error.textContent = ''; // Clear error message
                    error.style.display = 'none'; // Hide error element
                });

                switch (stepIndex + 1) {
                    case 1:
                        isValid = validateStep1();
                        break;
                    case 2:
                        isValid = validateStep2();
                        break;
                    case 3:
                        isValid = validateStep3();
                        break;
                }
                return isValid;
            }

            function validateStep1() {
                let valid = true;
                const firstName = document.getElementById('firstname');
                const lastName = document.getElementById('lastname');
                const nameFormat = /^[A-Za-z\s]+$/;

                clearError(firstName);
                clearError(lastName);

                const firstNameValue = firstName.value.trim();
                if (firstNameValue === '') {
                    showError(firstName, 'First name is required');
                    valid = false;
                } else if (!nameFormat.test(firstNameValue)) {
                    showError(firstName, 'Only letters and spaces allowed');
                    valid = false;
                } else {
                    showSuccess(firstName);
                }
                const lastNameValue = lastName.value.trim();
                if (lastNameValue === '') {
                    showError(lastName, 'Last name is required');
                    valid = false;
                } else if (!nameFormat.test(lastNameValue)) {
                    showError(lastName, 'Only letters and spaces allowed');
                    valid = false;
                } else {
                    showSuccess(lastName);
                }
                return valid;
            }

            function validateStep2() {
                let valid = true;

                const tpnumber = document.getElementById('tpnumber');
                const tpFormat = /^TP\d{6}$/;
                const tpValue = tpnumber.value.trim();

                clearError(tpnumber);
                if (tpValue === '') {
                    showError(tpnumber, 'TP number is required');
                    valid = false;
                } else if (!tpFormat.test(tpValue)) {
                    showError(tpnumber, 'Invalid TP number format (TP followed by 6 digits)');
                    valid = false;
                } else {
                    showSuccess(tpnumber);
                }

                const password = document.getElementById('password');
                const passwordValue = password.value.trim();
                const minLength = 8;
                const hasUpperCase = /[A-Z]/.test(passwordValue);
                const hasNumber = /\d/.test(passwordValue);
                const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(passwordValue);

                clearError(password);
                if (passwordValue === '') {
                    showError(password, 'Password is required');
                    valid = false;
                } else if (passwordValue.length < minLength) {
                    showError(password, `✖ Password must be at least ${minLength} characters`);
                    valid = false;
                } else if (!hasUpperCase) {
                    showError(password, '✖ Password must contain at least one uppercase letter');
                    valid = false;
                } else if (!hasNumber) {
                    showError(password, '✖ Password must contain at least one number');
                    valid = false;
                } else if (!hasSpecialChar) {
                    showError(password, '✖ Password must contain at least one special character');
                    valid = false;
                } else {
                    showSuccess(password);
                }
                return valid;
            }

            function validateStep3() {
                let valid = true;
                const phoneNo = document.getElementById('phoneNo');
                const phoneFormat = /^(01[2-9]\d{7}|011\d{8})$/;

                const phoneValue = phoneNo.value.trim();
                if (phoneValue === '') {
                    showError(phoneNo, 'Phone number is required');
                    valid = false;
                } else if (!phoneFormat.test(phoneValue)) {
                    showError(phoneNo, 'Invalid phone number format');
                    valid = false;
                } else {
                    showSuccess(phoneNo);
                }

                const email = document.getElementById('email');
                const emailValue = email.value.trim();
                const emailFormat = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                clearError(email);
                if (emailValue === '') {
                    showError(email, 'Email is required');
                    valid = false;
                } else if (!emailFormat.test(emailValue)) {
                    showError(email, 'Invalid email format');
                    valid = false;
                } else {
                    showSuccess(email);
                }
                return valid;
            }

            function clearError(input) {
                const errorElement = document.getElementById(input.id + 'Error');
                if (errorElement) {
                    errorElement.style.display = 'none';
                    errorElement.textContent = '';
                }
                input.classList.remove('error-state', 'success-state');
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
        });
    </script>

</body>

</html>