<?php
session_start();
require __DIR__ . "/dbconn.php";

// Force passenger_id = 1 for testing
$_SESSION['passenger_id'] = 1;

$sql = "SELECT 
            pick_up_point,
            drop_off_point,
            date,
            day,
            time,
            price
        FROM ride 
        WHERE id IN (
            SELECT ride_id 
            FROM passenger_transaction 
            WHERE passenger_id = 1 
            AND status = 'unpaid'
        )";

$result = $conn->query($sql);
$rides = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .route-icon {
            color: #6c757d;
            font-size: 1.2rem;
        }

        .time-badge {
            background: #e9ecef;
            color: #495057;
        }

        body {
            background: black;
        }

        /* Cart button styles matching the reference image */
        body .cart-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #2979ff;
            /* Bright blue background */
            border: none;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            cursor: pointer;
            padding: 0;
        }

        body .cart-button .cart-icon {
            color: white;
            /* White icon */
            font-size: 24px;
        }

        body .cart-button .cart-badge {
            position: absolute;
            top: 0px;
            right: 0px;
            min-width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #f44336;
            /* Red notification badge */
            color: white;
            font-size: 12px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            padding: 0 4px;
        }

        .modal-content {
            border-radius: 20px;
            overflow: hidden;
        }

        .modal-backdrop {
            z-index: 1040;
        }

        .modal {
            z-index: 1050;
        }

        .modal-dialog {
            margin: 1.75rem auto;
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <!-- Content here -->
    </div>

    <!-- Cart button matching the reference image -->
    <button class="cart-button" data-bs-toggle="modal" data-bs-target="#checkoutModal">
        <i class="fas fa-shopping-cart cart-icon"></i>
        <?php if (!empty($rides)): ?>
            <span class="cart-badge"><?= count($rides) ?></span>
        <?php endif; ?>
    </button>

    <div class="modal fade" id="checkoutModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ride Payment Summary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($rides)): ?>
                        <div class="ride-list">
                            <?php foreach ($rides as $ride): ?>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="route-details mb-3">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fas fa-map-marker-alt text-success route-icon"></i>
                                                        <div class="ms-2">
                                                            <div class="fw-bold"><?= htmlspecialchars($ride['pick_up_point']) ?>
                                                            </div>
                                                            <small class="text-muted">Pick-up point</small>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-map-marker-alt text-danger route-icon"></i>
                                                        <div class="ms-2">
                                                            <div class="fw-bold">
                                                                <?= htmlspecialchars($ride['drop_off_point']) ?></div>
                                                            <small class="text-muted">Drop-off point</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="time-details">
                                                    <span class="badge time-badge me-2">
                                                        <i class="fas fa-calendar-day"></i>
                                                        <?= htmlspecialchars($ride['date']) ?>
                                                    </span>

                                                    <span class="badge time-badge">
                                                        <i class="fas fa-clock"></i>
                                                        <?= htmlspecialchars($ride['time']) ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="col-4 text-end">
                                                <div class="price-display">
                                                    <div class="text-muted small">Total Fare</div>
                                                    <div class="h4 text-primary">
                                                        RM <?= number_format($ride['price'] / 100, 2) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <div class="total-summary bg-light p-3 rounded">
                            <div class="row fw-bold">
                                <div class="col-6">Total Rides:</div>
                                <div class="col-6 text-end"><?= count($rides) ?></div>

                                <div class="col-6 mt-2">Total Amount:</div>
                                <div class="col-6 text-end mt-2">
                                    RM <?= number_format(
                                        array_sum(array_column($rides, 'price')) / 100,
                                        2
                                    ) ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-muted py-4">No pending ride payments found</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <?php if (!empty($rides)): ?>
                        <form action="checkout.php" method="POST">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-wallet"></i> Confirm Payment
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>