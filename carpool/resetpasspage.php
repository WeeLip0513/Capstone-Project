<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$conn = require $_SERVER['DOCUMENT_ROOT'] . '/Capstone-Project/carpool/dbconn.php';

$sql = "SELECT * FROM user
        WHERE reset_token_hash = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    echo "<script>alert('token not found.'); window.location.href = '/Capstone-Project/carpool/loginpage.php';</script>";
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo "<script>alert('token has expired.'); window.location.href = '/Capstone-Project/carpool/loginpage.php';</script>";
}
// echo "token is valid and hasnt expired";
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/resetpass.css">
</head>

<body>
    <div class="reset-container">
        <form method="post" action="/Capstone-Project/carpool/php/login/process-reset-pass.php">
            <h1>Reset Password</h1>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div class="panel">
                <input type="password" id="password" name="password" placeholder="New Password">
                <span class="error" id="passwordError">Password is required</span>
            </div>


            <div class="panel">
                <input type="password" id="passwordConfirmation" name="password_confirmation"
                    placeholder="Confirm Password">
                <span class="error" id="passwordConfirmationError">Passwords must match</span>
            </div>


            <button class="confirm-button" type="submit">Send</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('passwordConfirmation');

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

            function validatePasswordConfirm() {
                const confirmValue = passwordConfirm.value.trim();
                const passwordValue = password.value.trim();
                const errorElement = document.getElementById('passwordConfirmationError');
                let valid = true;

                clearVisualState(passwordConfirm);
                errorElement.textContent = '';

                // Check if passwords match
                if (confirmValue === '') {
                    showError(passwordConfirm, 'Please confirm your password');
                    valid = false;
                } else if (confirmValue !== passwordValue) {
                    showError(passwordConfirm, 'Passwords do not match');
                    valid = false;
                }

                if (valid && confirmValue.length > 0) {
                    showSuccess(passwordConfirm);
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

</html>