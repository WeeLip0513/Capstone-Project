<?php include("../dbconn.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adminPage/adminsidebar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" type="image/png" href="../image/icon-logo.png">
</head>
<body>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    // Define all report pages
    $reportPages = ['userReport.php', 'summaryReport.php', 'earningsReport.php', 'popularRoutesReport.php'];

    // Check if the current page is in the report pages list
    $isReportActive = in_array($currentPage, $reportPages);
    ?>

    <div class="menu-btn">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="admin-sidebar">
            <div class="close-btn">
                <i class="fas fa-times"></i>
            </div>
        <header>
            <img src="../image/logo.png" alt="logo">
            <h1>Welcome Admin</h1>
        </header>
        <div class="menu">
            <div class="item"><a href="adminDashboard.php" class=" <?= ($currentPage == 'adminDashboard.php') ? 'active' : '' ?>">Dashboard</a></div>
            <div class="item"><a href="adminDriverApproval.php" class=" <?= ($currentPage == 'adminDriverApproval.php'|| $currentPage == 'adminViewDriver.php') ? 'active' : '' ?>">Driver Approvals</a></div>
            <div class="item">
                <a class="sub-btn<?= $isReportActive ? 'active' : '' ?>">Reports
                    <i class="fas fa-angle-right dropdown"></i>
                </a>
                <div class="sub-menu" <?= $isReportActive ? 'style="display: block;"' : '' ?>>
                    <a href="summaryReport.php" class="sub-item <?= ($currentPage == 'summaryReport.php') ? 'active' : '' ?>">Summary Report</a>
                    <a href="userReport.php" class="sub-item <?= ($currentPage == 'userReport.php') ? 'active' : '' ?>">User Report</a>
                    <a href="earningsReport.php" class="sub-item <?= ($currentPage == 'earningsReport.php') ? 'active' : '' ?>">Earnings Report</a>
                    <a href="popularRoutesReport.php" class="sub-item <?= ($currentPage == 'popularRoutesReport.php') ? 'active' : '' ?>">Popular Routes Report</a>
                </div>
            </div>
            <div class="item"><a href="adminFeedback.php" class="sub-item <?= ($currentPage == 'adminFeedback.php') ? 'active' : '' ?>">Feedbacks</a></div>
            <div class="item"><a href="../logout.php">Log Out</a></div>
        </div>
    </div>
    
    <!-- Main content container -->

    <!--Scripts-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        // Check if we're on mobile view on page load
        function checkWidth() {
            if($(window).width() <= 768) {
                $('.admin-sidebar').removeClass('active');
                // Don't change menu-btn visibility here
            }
        }
        
        // Run on page load
        checkWidth();
        
        // Run on window resize
        $(window).resize(function() {
            checkWidth();
        });
        
        // Hamburger menu click
        $('.menu-btn').click(function(){
            $('.admin-sidebar').addClass('active');
            $(this).css("visibility", "hidden"); // Only hide after clicking
        });
        
        // Close button click
        $('.close-btn').click(function(){
            $('.admin-sidebar').removeClass('active');
            $('.menu-btn').css("visibility", "visible"); // Show again after closing
        });
        
        // jQuery for sub menus
        $('.sub-btn').click(function(){
            $(this).next('.sub-menu').slideToggle();
            $(this).find('.dropdown').toggleClass('rotate');
        });
    });    
    </script>
</body>
</html>