<?php
session_start();

// Initialize cart in session if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['test_action'])) {
    echo json_encode([
        'success' => true,
        'message' => 'Test successful',
        'session_data' => $_SESSION,
        'post_data' => $_POST
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Cart Test Page</h1>
    <button id="test-button">Test Cart AJAX</button>
    <div id="result"></div>

    <script>
    document.getElementById('test-button').addEventListener('click', function() {
        fetch('test_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'test_action=true&test_data=123'
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('result').innerHTML = 
                '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            document.getElementById('result').innerHTML = 
                '<p style="color:red">Error: ' + error + '</p>';
        });
    });
    </script>
</body>
</html>