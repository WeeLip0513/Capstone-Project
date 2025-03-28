<?php
session_start();
include("../dbconn.php");
include("../userHeader.php");
include("../php/passenger/profile.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['id'])) {
    echo "<h2 style='color:red;'>No session ID found!</h2>";
    exit();
}

$userID = $_SESSION['id'];
// echo "<h2 style='color:white;'>$userID</h2>";

$passenger = getProfileDetails($userID, $conn);

// Get passenger ID
$stmt = $conn->prepare("SELECT id FROM passenger WHERE user_id = ?");
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    echo "Passenger ID not found.";
    exit();
}

$passenger_id = $row['id'];
// echo "Passenger ID: " . $passenger_id . "<br>";

// Get ride IDs from passenger_transaction table
$stmt = $conn->prepare("SELECT ride_id FROM passenger_transaction WHERE passenger_id = ?");
$stmt->bind_param("i", $passenger_id);
$stmt->execute();
$result = $stmt->get_result();

$rideIDs = [];
while ($row = $result->fetch_assoc()) {
    $rideIDs[] = $row['ride_id'];
}
$stmt->close();

// Check if we have ride IDs
if (empty($rideIDs)) {
    $rides = []; // Set empty rides array
} else {
    // Convert ride IDs into a comma-separated string
    $rideIDsString = implode(',', array_map('intval', $rideIDs));

    // Query to fetch rides that are not completed
    $query = "SELECT r.* 
              FROM ride r 
              LEFT JOIN passenger_transaction pt ON r.id = pt.ride_id 
              WHERE r.id IN ($rideIDsString) 
              AND r.status IN ('upcoming', 'active', 'waiting', 'ongoing') 
              AND (pt.status IS NULL OR pt.status <> 'complete')";

    $result = $conn->query($query);

    // Fetch ride details
    $rides = [];
    while ($row = $result->fetch_assoc()) {
        $rides[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/passengerPage/passengerPage.css">
    <link rel="stylesheet" href="../css/passengerPage/availablerides.css">
    <link rel="stylesheet" href="../css/passengerPage/upcomingRide.css">
    <link rel="stylesheet" href="../css/passengerPage/passengerProfile.css">
    <link rel="stylesheet" href="../css/passengerPage/ridecart.css">
    <link rel="stylesheet" href="../css/passengerPage/resetpassmodal.css">
    <link rel="stylesheet" href="../css/passengerPage/ridehistory.css">
    <link rel="stylesheet" href="../css/passengerPage/deleteAccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="hamburger" id="hamburger">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>

    <div class="passenger">
        <div class="navigation-user" id="navigation-user">
            <div class="tabs">
                <input type="radio" name="tabs" id="upcomingrides" checked>
                <label for="upcomingrides">Upcoming Rides</label>
                <input type="radio" name="tabs" id="availablerides">
                <label for="availablerides">Search Rides</label>
                <input type="radio" name="tabs" id="tab3">
                <label for="tab3">Rides History</label>
                <input type="radio" name="tabs" id="tab4">
                <label for="tab4">My Profile</label>
                <div class="glider"></div>
            </div>
        </div>

        <div class="tab-content">
            <!-- Upcoming Rides Tab -->
            <div class="content-section" id="content-upcomingrides">
                <h2>Your Upcoming Rides</h2>
                <div class="rides-container">
                    <table border="1" id="upcomingRides"
                        style="width:100%; border-collapse: collapse; text-align: center;">
                        <tr>
                            <th>Day</th>
                            <th>Pick Up Point</th>
                            <th>Drop Off Point</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th></th>
                        </tr>

                        <?php if (!empty($rides)): ?>
                            <?php foreach ($rides as $ride): ?>
                                <tr>
                                    <td><?= $ride['day'] ?></td>
                                    <td><?= htmlspecialchars($ride['pick_up_point']) ?></td>
                                    <td><?= htmlspecialchars($ride['drop_off_point']) ?></td>
                                    <td><?= $ride['date'] ?></td>
                                    <td><?= $ride['time'] ?></td>
                                    <td>
                                        <?php if (in_array($ride['status'], ['active', 'waiting', 'ongoing'])): ?>
                                            <a href="../passenger/viewRide.php?ride_id=<?= $ride['id'] ?>" class="view-link"><button>View</button></a>
                                        <?php else: ?>
                                            <span class="inactive-text">Unavailable</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="color: white;">You have no upcoming rides scheduled.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>


            <!-- Available Rides Tab -->
            <div class="content-section" id="content-availablerides">
                <div class="search-form">
                    <div class="row">
                        <div class="pickup">
                            <h2>Pickup Point</h2>
                            <div class="pickup-selection">
                                <select name="pickup" id="pickup" required>
                                    <option value="">Select Pick-Up Point</option>
                                    <option value="apu">APU</option>
                                    <option value="lrt_bukit_jalil">LRT Bukit Jalil</option>
                                    <option value="pav_bukit_jalil">Pavilion Bukit Jalil</option>
                                    <option value="sri_petaling">Sri Petaling</option>
                                </select>
                                <span class="error" id="pickupError"></span>
                            </div>
                        </div>
                        <div class="dropoff">
                            <h2>Drop-off Point</h2>
                            <div class="dropoff-selection">
                                <select name="dropoff" id="dropoff" required>
                                    <option value="">Select Drop-Off Point</option>
                                    <option value="apu">APU</option>
                                    <option value="lrt_bukit_jalil">LRT Bukit Jalil</option>
                                    <option value="pav_bukit_jalil">Pavilion Bukit Jalil</option>
                                    <option value="sri_petaling">Sri Petaling</option>
                                </select>
                                <span class="error" id="dropoffError"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="date">
                            <h2>Date</h2>
                            <input type="date" id="date">
                            <span class="error" id="txtDateError"></span>
                        </div>
                        <div class="time">
                            <h2>Time</h2>
                            <div class="time-container">
                                <select name="hour" id="hour" required>
                                    <option value="">HH</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                </select>
                                <select name="minute" id="minute" required>
                                    <option value="">MM</option>
                                    <option value="00">00</option>
                                    <option value="05">05</option>
                                    <option value="10">10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="30">30</option>
                                    <option value="35">35</option>
                                    <option value="40">40</option>
                                    <option value="45">45</option>
                                    <option value="50">50</option>
                                    <option value="55">55</option>
                                </select>
                            </div>
                            <span class="error" id="timeError"></span>
                        </div>
                    </div>
                </div>
                <div id="rideResults">
                    <p></p>
                </div>
            </div>

            <!-- Rides History Tab -->
            <div class="content-section" id="content-tab3">
                <h2>Your Ride History</h2>
                <div class="history-container" id="ridesContainer">
                    <div class="loading">Loading rides...</div>
                </div>
            </div>

            <!-- Profile Tab -->
            <?php if ($passenger): ?>
                <div class="content-section" id="content-tab4">
                    <div class="profile-container">
                        <div class="profile-card">
                            <h2>My Profile</h2>
                            <div class="profiledetails">
                                <div class="profilerow">
                                    <div class="profiledetail">
                                        <h3>First Name:</h3>
                                        <div class="show-profile-detail">
                                            <p id="firstname"><?php echo $passenger['firstname']; ?></p>
                                            <i class="fas fa-edit edit-icon"
                                                onclick="openEditProfileModal('firstname', '<?php echo $passenger['firstname']; ?>')"></i>
                                        </div>
                                    </div>
                                    <div class="profiledetail">
                                        <h3>Last Name:</h3>
                                        <div class="show-profile-detail">
                                            <p id="lastname"><?php echo $passenger['lastname']; ?></p>
                                            <i class="fas fa-edit edit-icon"
                                                onclick="openEditProfileModal('lastname', '<?php echo $passenger['lastname']; ?>')"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="profilerow">
                                    <div class="profiledetail">
                                        <h3>Phone:</h3>
                                        <div class="show-profile-detail">
                                            <p id="phone_no"><?php echo $passenger['phone_no']; ?></p>
                                            <i class="fas fa-edit edit-icon"
                                                onclick="openEditProfileModal('phone_no', '<?php echo $passenger['phone_no']; ?>')"></i>
                                        </div>
                                    </div>
                                    <div class="profiledetail">
                                        <h3>Email:</h3>
                                        <div class="show-profile-detail">
                                            <p id="email"><?php echo $passenger['email']; ?></p>
                                            <i class="fas fa-edit edit-icon"
                                                onclick="openEditProfileModal('email', '<?php echo $passenger['email']; ?>')"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="profilerow">
                                    <div class="profiledetail">
                                        <h3>Registered Date:</h3>
                                        <div class="show-profile-detail">
                                            <p><?php echo $passenger['registration_date']; ?></p>
                                        </div>
                                    </div>
                                    <div class="profiledetail">
                                        <h3>Reset Password:</h3>
                                        <div class="show-profile-detail">
                                            <p>**********</p>
                                            <button id="resetProfilePassword" class="forgot">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="profiledelete">
                                <h3>Destroy Account:</h3>
                                <div class="delete-account">
                                    <button id="deletePassenger" class="deleteAccount">Delete Account</button>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p>No passenger record found!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div id="passwordResetModal" class="resetpassmodal" style="display: none !important;">
        <div class="resetpassmodal-content">
            <!-- <span class="close-modal">&times;</span> -->
            <p id="modal-message">Processing<span class="dots">
                    <span class="dot">.</span>
                    <span class="dot">.</span>
                    <span class="dot">.</span>
                </span>
            </p>
        </div>
    </div>

    <!-- <div id="ratingModal" class="rate-modal">
      <div class="rate-modal-content rating-content">
        <span class="close-rating">&times;</span>
        <h3>Please rate your driver</h3>
        <div class="star-rating">
            <span data-value="1" class="star">&#9733;</span>
            <span data-value="2" class="star">&#9733;</span>
            <span data-value="3" class="star">&#9733;</span>
            <span data-value="4" class="star">&#9733;</span>
            <span data-value="5" class="star">&#9733;</span>
        </div>
        <button id="submitRating">Submit Rating</button>
      </div>
    </div> -->

    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="editProfileForm">
                <input type="hidden" id="editFieldName" name="fieldName">
                <label id="editLabel"></label>
                <div class="form-group">
                    <input type="text" id="editFieldValue" name="fieldValue" required>
                    <span id="errorMessage" class="error-message"></span>
                </div>
                <button type="submit">Save Changes</button>
            </form>
        </div>
    </div>

    <div id="cart-modal" class="cart-modal">
        <div class="card-wrap">
            <div class="cart-content">
                <div class="modal-header">
                    <h2>Your Cart</h2>
                    <span id="close" class="close">&times;</span>
                </div>
                <div class="modal-body">
                    <div id="cart-items">
                        <div id="cart-items-container" class="cart-items-container">
                            <!-- Cart items will be loaded here -->
                        </div>
                    </div>
                </div>
                <div class="cart-footer">
                    <div class="total">
                        <h3>Total: <span id="cart-total" class="cart-total">RM 0.00</span></h3>
                    </div>
                    <button id="checkout-btn" class="checkout-btn">Proceed to Payment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this cart icon to your page header/navigation -->
    <div id="cart-icon" class="cart-icon">
        <i class="fa-solid fa-car"></i>
        <span id="cart-count" class="cart-count">0</span>
    </div>

    <script src="../js/passenger/navbar.js"></script>
    <script src="../js/passenger/fetchrides.js"></script>
    <script src="../js/passenger/editProfileModal.js"></script>
    <script src="../js/passenger/cartandpayment.js"></script>
    <script src="../js/passenger/resetpassmodal.js"></script>
    <script src="../js/passenger/ridehistory.js"></script>
    <script src="../js/passenger/searchFormValid.js"></script>
    <script src="../js/passenger/hamburger.js"></script>
    <script src="../js/passenger/deleteAccount.js"></script>
    <script>
        var driverId = <?php echo $driver_id; ?>;
    </script>
    <script>
        // Output the cart count from PHP so your external JS can use it
        var initialCartCount = <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>;
    </script>
    <script>
        function getLocationName(location) {
            const locationMapping = {
                'apu': 'APU (Asia Pacific University)',
                'sri_petaling': 'Sri Petaling',
                'lrt_bukit_jalil': 'LRT Bukit Jalil',
                'pav_bukit_jalil': 'Pavilion Bukit Jalil'
            };

            return locationMapping[location] || location.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        }
    </script>


    <!-- Edit Profile Modal -->
</body>

</html>