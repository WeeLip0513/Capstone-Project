<?php

// $token = $_GET["token"];

// $token_hash = hash("sha256", $token);

// $conn = require __DIR__ . "/dbconn.php";

// $sql = "SELECT * FROM user
//         WHERE reset_token_hash = ?";

// $stmt = $conn->prepare($sql);

// $stmt->bind_param("s", $token_hash);

// $stmt->execute();

// $result = $stmt->get_result();

// $user = $result->fetch_assoc();

// if ($user === null) {
//     die("token not found");
// }

// if (strtotime($user["reset_token_expires_at"]) <= time()) {
//     die("token has expired");
// }
// echo "token is valid and hasnt expired";
include("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/resetpass.css">
</head>

<body>
    <div class="reset-container">
        <form method="post" action="process-reset-password.php">
            <h1>Reset Password</h1>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <div class="infield">
                <input type="password" id="password" name="password" placeholder="New Password">
                <label id="passwordLabel"></label>
            </div>
            <span class="error" id="passwordError">Password is required</span>

            <div class="infield">
                <input type="password" id="password_confirmation" name="password_confirmation"
                    placeholder="Confirm Password">
                <label id="passwordConfirmationLabel"></label>
            </div>
            <span class="error" id="passwordConfirmationError">Passwords must match</span>

            <button class="confirm-button" type="submit">Send</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('form');
            const passInput = document.getElementByID('password');
            const passError = document.getElementById('passwordError');
            const passConfirm = document.getElementById('password_confirmation');
            const passConfirmError = document.getElementById('passwordConfirmationError');
            const passLabel = document.getElementById('passwordLabel');
            const passConfirmLabel = document.getElementById('passwordConfirmationLabel');


            passError.style.display = 'none';
            passConfirmError.style.display = 'none';

            passInput.addEventListener('focus', function () {
                passLabel.style.width = '70%';
            })

            passInput.addEventListener('blur', function(){
                if(!this.value.trim() && passError.style.display === 'none'){
                    passLabel.style.width = '0%';
                }
            })
        });
    </script>

</body>

</html>