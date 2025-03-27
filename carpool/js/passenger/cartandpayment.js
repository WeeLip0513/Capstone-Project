document.addEventListener('DOMContentLoaded', function () {
    const cartIcon = document.getElementById('cart-icon');
    const cartModal = document.getElementById('cart-modal');
    const cartCount = document.getElementById('cart-count');
    const cartItemsContainer = document.getElementById('cart-items-container');
    const cartTotal = document.getElementById('cart-total');
    const checkoutBtn = document.getElementById('checkout-btn');
    const closeBtn = document.getElementById('close');

    // Update cart count on page load
    if (cartCount) {
        // updateCartCount(<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>);
        updateCartCount(initialCartCount);
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
        // console.log('Proceeding to payment');
        // console.log('Current cart:', <?php echo json_encode($_SESSION['cart'] ?? []); ?>);

        // Use the full path to ensure correct routing
        fetch('http://localhost/Capstone-Project/carpool/php/passenger/payment.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            credentials: 'include',
            body: 'action=proceed_to_payment'
        })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                return response.json();
            })
            .then(data => {
                console.log('Full response data:', data);

                if (data.success) {
                    window.location.href = data.checkout_url;
                } else {
                    console.error('Payment processing error:', data);
                    showNotification(data.message || 'Payment processing failed');

                    // Additional debug information
                    if (data.debug) {
                        console.error('Debug info:', data.debug);
                    }
                }
            })
            .catch(error => {
                console.error('Fetch error details:', error);

                // Try to get more information about the error
                if (error.response) {
                    error.response.text().then(errorText => {
                        console.error('Error response text:', errorText);
                    });
                }

                showNotification('An error occurred. Please check the console for details.');
            });
    }
    function checkBookedRides() {
        fetch('../php/passenger/displayrides.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            credentials: 'include',
            body: 'action=check_booked_rides'
        })
            .then(response => response.json())
            .then(data => {
                console.log('DEBUG: Full response:', data);
                console.log('DEBUG: Booked Rides:', data.bookedRides);

                if (data.success && Array.isArray(data.bookedRides)) {
                    if (data.bookedRides.length === 0) {
                        console.warn('No booked rides found');
                    }

                    data.bookedRides.forEach(rideId => {
                        console.log('Processing ride ID:', rideId);
                        const bookButton = document.querySelector(`.book-ride[data-ride-id="${rideId}"]`);

                        if (bookButton) {
                            console.log('Found button for ride ID:', rideId);
                            bookButton.textContent = 'Booked';
                            bookButton.classList.remove('in-cart');
                            bookButton.classList.add('booked');
                            bookButton.disabled = true;
                        } else {
                            console.warn('No button found for ride ID:', rideId);
                        }
                    });
                } else {
                    console.error('Invalid response structure:', data);
                }
            })
    }


    // Call this function after payment success (for example, if URL parameter is "payment=success")
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('payment') === 'success') {
        // Show a notification if needed, then check for booked rides.
        showNotification('Payment successful! Your ride has been booked.');

        // Clear the URL parameter so the message is not repeated.
        window.history.replaceState({}, document.title, window.location.pathname);
    }
    if (urlParams.get('payment') === 'error') {
        showNotification('Payment was canceled or failed.');
        window.history.replaceState({}, document.title, window.location.pathname);
    }

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


});