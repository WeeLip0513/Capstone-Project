<?php
include("../dbconn.php");
include("../userHeader.php")
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Page</title>
    <link rel="stylesheet" href="../css/userNavigate.css">
</head>
<body>
    <div class="navigation-user">
        <div class="tabs">
            <input type="radio" name="tabs" id="tab1" checked>
            <label for="tab1">Upcoming Rides</label>
            <input type="radio" name="tabs" id="tab2">
            <label for="tab2">Available rides</label>
            <input type="radio" name="tabs" id="tab3">
            <label for="tab3">Rides History</label>
            <input type="radio" name="tabs" id="tab4">
            <label for="tab4">My Profile</label>
            <div class="glider"></div>
        </div>
    </div>
</body>
</html>