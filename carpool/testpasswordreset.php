<?php

$conn = require __DIR__ . "/dbconn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];

    $token = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    date_default_timezone_set("Asia/Kuala_Lumpur");

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $sql = "UPDATE user
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sss", $token_hash, $expiry, $email);
    $stmt->execute();

    // echo "Password reset token generated successfully!";
}

?>