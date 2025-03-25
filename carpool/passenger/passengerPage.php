<?php
session_start();
include("../dbconn.php");
include("../userHeader.php");
include("../php/passenger/profile.php");


if (isset($_SESSION['id'])) {
    $userID = $_SESSION['id'];
    echo "<h2 style='color:white;'>$userID</h2>";
} else {
    echo "<h2 style='color:red;'>No session ID found!</h2>";
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
}
$passenger = getProfileDetails($userID, $conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/passengerPage/availablerides.css">
    <link rel="stylesheet" href="../css/passengerPage/passengerPage.css">
    <link rel="stylesheet" href="../css/passengerPage/passengerProfile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <button class="hamburger" id="hamburger">
        <div></div>
        <div></div>
        <div></div>
    </button>

    <!-- Mobile Navigation Menu -->
    <div id="mobileMenu" class="mobile-menu">
        <button class="featureBtn" data-content="content-upcomingrides">Upcoming Rides</button>
        <button class="featureBtn" data-content="content-availablerides">Available Rides</button>
        <button class="featureBtn" data-content="content-tab3">Rides History</button>
        <button class="featureBtn" data-content="content-tab4">My Profile</button>
    </div>

    <div class="passenger">
        <div class="navigation-user">
            <div class="tabs">
                <input type="radio" name="tabs" id="upcomingrides">
                <label for="upcomingrides">Upcoming Rides</label>
                <input type="radio" name="tabs" id="availablerides" checked>
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
                                    <!-- <option value="">Select Pick-Up Point</option> -->
                                    <option value="apu">APU</option>
                                    <!-- <option value="lrt_bukit_jalil">LRT Bukit Jalil</option> -->
                                    <!-- <option value="pav_bukit_jalil">Pavilion Bukit Jalil</option>
                                    <option value="sri_petaling">Sri Petaling</option> -->
                                </select>
                                <span class="error" id="pickupError"></span>
                            </div>
                        </div>
                        <div class="dropoff">
                            <h2>Drop-off Point</h2>
                            <div class="dropoff-selection">
                                <select name="dropoff" id="dropoff" required>
                                    <!-- <option value="">Select Drop-Off Point</option> -->
                                    <!-- <option value="apu">APU</option> -->
                                    <option value="lrt_bukit_jalil">LRT Bukit Jalil</option>
                                    <!-- <option value="pav_bukit_jalil">Pavilion Bukit Jalil</option> -->
                                    <!-- <option value="sri_petaling">Sri Petaling</option> -->
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
                                    <!-- <option value="">HH</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option> -->
                                    <option value="08">08</option>
                                    <!-- <option value="09">09</option> -->
                                    <!-- <option value="10">10</option>
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
                                    <option value="21">21</option> -->
                                </select>
                                <select name="minute" id="minute" required>
                                    <!-- <option value="">MM</option> -->
                                    <!-- <option value="00">00</option> -->
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
                                        <a href="#"><button class="forgot">Reset Password</button></a>
                                    </div>
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
                    <span class="close">&times;</span>
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
    <script src="../js/passenger/hamburger.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cartIcon = document.getElementById('cart-icon');
            const cartModal = document.getElementById('cart-modal');
            const cartCount = document.getElementById('cart-count');
            const cartItemsContainer = document.getElementById('cart-items-container');
            const cartTotal = document.getElementById('cart-total');
            const checkoutBtn = document.getElementById('checkout-btn');
            const closeBtn = document.querySelector('.close');

            // Update cart count on page load
            if (cartCount) {
                updateCartCount(<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>);
            }

            // Cart icon click event
            if (cartIcon && cartModal) {
                cartIcon.addEventListener('click', function () {
                    cartModal.style.display = 'flex';
                    // Load cart items when modal is opened
                    loadCartItems();
                });
            }

            // Close button event
            if (closeBtn && cartModal) {
                closeBtn.addEventListener('click', function () {
                    cartModal.style.display = 'none';
                });
            }

            // Close when clicking outside modal
            window.onclick = function (event) {
                if (cartModal && event.target == cartModal) {
                    cartModal.style.display = 'none';
                }
            };

            // Add item to cart
            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('book-ride') && !e.target.classList.contains('in-cart')) {
                    const rideId = e.target.getAttribute('data-ride-id');
                    addToCart(rideId, e.target);
                }
            });

            // Checkout button
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', function () {
                    proceedToPayment();
                });
            }

            // Rest of your functions remain the same...
            function addToCart(rideId, buttonElement) {
                console.log('Adding ride to cart:', rideId);

                fetch('http://localhost/Capstone-Project/carpool/php/passenger/displayrides.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=add_to_cart&ride_id=' + encodeURIComponent(rideId),
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Response received:', data);
                        if (data.success) {
                            buttonElement.textContent = 'In Cart';
                            buttonElement.classList.add('in-cart');
                            updateCartCount(data.cart_count);
                            showNotification('Ride added to cart');
                        } else {
                            showNotification(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        showNotification('An error occurred. Please try again.');
                    });
            }

            function loadCartItems() {
                if (!cartItemsContainer) return;

                fetch('http://localhost/Capstone-Project/carpool/php/passenger/displayrides.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=get_cart_items'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            renderCartItems(data.items, data.total_price);
                        } else {
                            cartItemsContainer.innerHTML = '<div class="empty-cart-message"><p>Your cart is empty</p></div>';
                            if (cartTotal) cartTotal.textContent = 'RM 0.00';
                            if (checkoutBtn) checkoutBtn.disabled = true;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        cartItemsContainer.innerHTML = '<div class="empty-cart-message"><p>Failed to load cart items</p></div>';
                    });
            }

            function renderCartItems(items, totalPrice) {
                if (!cartItemsContainer) return;

                if (items.length === 0) {
                    cartItemsContainer.innerHTML = '<div class="empty-cart-message"><p>Your cart is empty</p></div>';
                    if (cartTotal) cartTotal.textContent = 'RM 0.00';
                    if (checkoutBtn) checkoutBtn.disabled = true;
                    return;
                }

                let html = '';
                items.forEach(item => {
                    html += `
                    <div class="cart-item" data-ride-id="${item.id}">
                        <div class="cart-item-details">
                            <h4>${getLocationName(item.pick_up_point)} to ${getLocationName(item.drop_off_point)}</h4>
                            <p>${item.date} at ${item.time}</p>
                            <p>${item.brand} ${item.model} • ${item.firstname} ${item.lastname}</p>
                        </div>
                        <div class="cart-item-price">RM ${item.price}</div>
                        <div class="remove-item" data-ride-id="${item.id}">
                            <i class="fas fa-trash"></i>
                        </div>
                    </div>`;
                });

                cartItemsContainer.innerHTML = html;
                if (cartTotal) cartTotal.textContent = 'RM ' + totalPrice.toFixed(2);
                if (checkoutBtn) checkoutBtn.disabled = false;

                // Add remove item event listeners
                document.querySelectorAll('.remove-item').forEach(button => {
                    button.addEventListener('click', function () {
                        const rideId = this.getAttribute('data-ride-id');
                        removeFromCart(rideId);
                    });
                });
            }

            function removeFromCart(rideId) {
                fetch('http://localhost/Capstone-Project/carpool/php/passenger/displayrides.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=remove_from_cart&ride_id=' + rideId
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update UI
                            const cartItem = document.querySelector(`.cart-item[data-ride-id="${rideId}"]`);
                            if (cartItem) cartItem.remove();

                            const bookButton = document.querySelector(`.book-ride[data-ride-id="${rideId}"]`);
                            if (bookButton) {
                                bookButton.textContent = 'Add To Ride';
                                bookButton.classList.remove('in-cart');
                            }
                            updateCartCount(data.cart_count);

                            // Check if cart is empty
                            if (data.cart_count === 0) {
                                if (cartItemsContainer) cartItemsContainer.innerHTML = '<div class="empty-cart-message"><p>Your cart is empty</p></div>';
                                if (cartTotal) cartTotal.textContent = 'RM 0.00';
                                if (checkoutBtn) checkoutBtn.disabled = true;
                            } else {
                                // Recalculate total
                                let total = 0;
                                document.querySelectorAll('.cart-item-price').forEach(price => {
                                    total += parseFloat(price.textContent.replace('RM ', ''));
                                });
                                if (cartTotal) cartTotal.textContent = 'RM ' + total.toFixed(2);
                            }

                            showNotification('Ride removed from cart');
                        } else {
                            showNotification(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred. Please try again.');
                    });
            }

            function proceedToPayment() {
                fetch('http://localhost/Capstone-Project/carpool/php/passenger/displayrides.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'action=proceed_to_payment'
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = data.checkout_url;
                        } else {
                            showNotification(data.message || 'Payment processing failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('An error occurred. Please try again.');
                    });
            }

            const urlParams = new URLSearchParams(window.location.search);
            const paymentStatus = urlParams.get('payment');

            if (paymentStatus === 'success') {
                showNotification('Payment successful! Your ride has been booked.');

                // Update all "In Cart" buttons to "Booked" for items that were in the cart
                document.querySelectorAll('.book-ride.in-cart').forEach(button => {
                    button.textContent = 'Booked';
                    button.classList.remove('in-cart');
                    button.classList.add('booked');
                    button.disabled = true;
                });

                // Clear URL parameter to prevent showing the notification on page refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            } else if (paymentStatus === 'error') {
                showNotification('Payment was not completed. Please try again.');

                // Clear URL parameter to prevent showing the notification on page refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            }

            // Add this function to check if a ride is already booked by the passenger
            function checkBookedRides() {
                fetch('http://localhost/Capstone-Project/carpool/php/passenger/displayrides.php')
                    .then(response => response.json())
                    console.log('Response from checkBookedRides:', data);
                    .then(data => {
                        if (data.success) {
                            data.bookedRides.forEach(rideId => {
                                const bookButton = document.querySelector(`.book-ride[data-ride-id="${rideId}"]`);
                                if (bookButton) {
                                    bookButton.textContent = 'Booked';
                                    bookButton.classList.add('booked');
                                    bookButton.disabled = true;
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error checking booked rides:', error);
                    });
            }

            // Call this function when the page loads
            checkBookedRides();

            function updateCartCount(count) {
                if (cartCount) {
                    cartCount.textContent = count;
                }
                if (checkoutBtn) {
                    checkoutBtn.disabled = count === 0;
                }
            }

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.className = 'notification';
                notification.textContent = message;
                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.classList.add('show');
                }, 10);

                setTimeout(() => {
                    notification.classList.remove('show');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 300);
                }, 3000);
            }

            function getLocationName(location) {
                const locationMapping = {
                    'apu': 'APU (Asia Pacific University)',
                    'sri_petaling': 'Sri Petaling',
                    'lrt_bukit_jalil': 'LRT Bukit Jalil',
                    'pav_bukit_jalil': 'Pavilion Bukit Jalil'
                };

                return locationMapping[location] || location.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
            }
        });
    </script>
    <!-- Edit Profile Modal -->
</body>

</html>