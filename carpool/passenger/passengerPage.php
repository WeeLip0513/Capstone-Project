<?php
session_start();
include("../dbconn.php");
include("../userHeader.php")

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Page</title>
    <link rel="stylesheet" href="../css/passengerPage/availablerides.css">
    <link rel="stylesheet" href="../css/passengerPage/passengerPage.css">
</head>
<body>
    <div class="passenger">
        <div class="navigation-user">
            <div class="tabs">
                <input type="radio" name="tabs" id="upcomingrides">
                <label for="upcomingrides">Upcoming Rides</label>
                <input type="radio" name="tabs" id="availablerides"checked>
                <label for="availablerides">Available rides</label>
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
                    <p>You have no upcoming rides scheduled.</p>
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
                <div class="history-container">
                    <p>You haven't taken any rides yet.</p>
                </div>
            </div>
            
            <!-- Profile Tab -->
            <div class="content-section" id="content-tab4">
                <h2>My Profile</h2>
                <div class="profile-container">
                    <p>Your profile information will appear here.</p>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/passenger/navbar.js"></script>
    <script src="../js/passenger/fetchrides.js"></script>
</body>
</html>