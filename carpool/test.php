<?php
include("dbconn.php");

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check DB connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get the date range for last week's Sunday to Saturday
$last_sunday = date('Y-m-d', strtotime('last sunday -6 days')); // Previous week's Sunday
$last_saturday = date('Y-m-d', strtotime('last sunday')); // Previous week's Saturday

$sql = "SELECT id, date, DAYNAME(date) AS day, TIME_FORMAT(time, '%h:%i %p') AS formatted_time, 
               pick_up_point, drop_off_point, slots_available, price
        FROM ride 
        WHERE date BETWEEN '$last_sunday' AND '$last_saturday'
        ORDER BY date ASC";

$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ride Schedule</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        input[type="checkbox"] {
            transform: scale(1.3);
            cursor: pointer;
        }
        .selected-row {
            background-color: #f0f8ff; /* Light blue background for selected row */
        }
    </style>
</head>
<body>

<h2>Ride Schedule (Last Week's Rides)</h2>
<p>Showing rides from <strong><?php echo $last_sunday; ?></strong> to <strong><?php echo $last_saturday; ?></strong></p>

<table>
    <tr>
        <th>Select</th>
        <th>Date</th>
        <th>Day</th>
        <th>Time</th>
        <th>Pick-Up</th>
        <th>Drop-Off</th>
        <th>Slots Available</th>
        <th>Price</th>
    </tr>

    <?php 
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><input type='checkbox' class='rideCheckbox' data-ride='" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . "'></td>";
            echo "<td>" . htmlspecialchars($row['date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['day']) . "</td>";
            echo "<td>" . htmlspecialchars($row['formatted_time']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pick_up_point']) . "</td>";
            echo "<td>" . htmlspecialchars($row['drop_off_point']) . "</td>";
            echo "<td>" . htmlspecialchars($row['slots_available']) . "</td>";
            echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No rides found for last week.</td></tr>";
    }
    ?>
</table>

<!-- Selected Ride Details -->
<h3>Selected Ride Details:</h3>
<p id="selectedRideDetails">No rides selected.</p>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const checkboxes = document.querySelectorAll(".rideCheckbox");
    const selectedRideDetails = document.getElementById("selectedRideDetails");

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            updateSelectedRides();
        });
    });

    function updateSelectedRides() {
        let selectedRides = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const rideData = JSON.parse(checkbox.getAttribute("data-ride"));
                selectedRides.push(`
                    <strong>Date:</strong> ${rideData.date} <br>
                    <strong>Day:</strong> ${rideData.day} <br>
                    <strong>Time:</strong> ${rideData.formatted_time} <br>
                    <strong>Pick-Up:</strong> ${rideData.pick_up_point} <br>
                    <strong>Drop-Off:</strong> ${rideData.drop_off_point} <br>
                    <strong>Slots Available:</strong> ${rideData.slots_available} <br>
                    <strong>Price:</strong> $${rideData.price}
                    <hr>
                `);
                checkbox.closest("tr").classList.add("selected-row");
            } else {
                checkbox.closest("tr").classList.remove("selected-row");
            }
        });

        selectedRideDetails.innerHTML = selectedRides.length ? selectedRides.join("") : "No rides selected.";
    }
});
</script>

</body>
</html>
