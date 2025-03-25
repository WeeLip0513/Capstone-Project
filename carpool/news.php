<?php
    include ("dbconn.php");
    include ("headerHomepage.php");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>News</title>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="css/news.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
        <style>
            body {
  margin: 0;
  font-family: Arial, Helvetica;
  background-color: black;
  color: white;
}

.swiper-container {
  width: 100%;
  height: 750px;
  margin: 100px auto 0; /* Adds 50px margin from the top */
  overflow: hidden;
  position: relative; /* Ensures elements inside stay positioned properly */
}

.swiper-pagination {
  width: 100%;
  text-align: center;
  bottom: 10px; /* Adjust as needed */
  left: 0;
  transform: none;
}

/* Ensure images fill slides */
.swiper-slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 10px;
}

.swiper-button-next,
.swiper-button-prev {
  width: 50px;  
  height: 50px;
}

.swiper-button-next {
  right: 40px;
  font-weight: bold;
}

.swiper-button-prev {
  left: 40px;
  font-weight: bold;
}

.swiper-pagination .swiper-pagination-bullet {
  background: rgb(0, 0, 0) !important;/* Inactive bullet color */
  width: 12px;
  height: 12px;
}

.swiper-pagination .swiper-pagination-bullet-active {
  background: #2b64ff !important;
}

/*2*/

.tablink {
  background-color: transparent;
  color:rgb(153, 164, 193); 
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 50px;
  font-weight: bold;
  transition: background-color 0.3s, color 0.3s, border-color 0.3s;
  border: none;
  position: relative;
}

.tablink.active {
  color: #2b64ff;
}

.tablink.active::after {
  content: "";
  position: absolute;
  left: 50%;               /* Start at the center */
  transform: translateX(-50%); /* Move back by 50% to center it */
  bottom: 0;              /* Position at the bottom edge of the button */
  width: 100%;             /* Underline width: adjust as needed (e.g., 50%, 100%, etc.) */
  height: 3px;            /* Thickness of the underline */
  background-color: #2b64ff;
}

/* Hover effect only on non-active tabs */
.tablink:not(.active):hover {
  color: white;
}

.tab-container {
margin-top: 50px; /* Adjust the value as needed */
}

.tablinks-container {
  display: inline-block;
  margin-left: 150px;           
  width: 1600px;
  border: none;
}

.tablink + .tablink {
margin-left: 30px;
}

/* Style the tab content */
.tabcontent {
  background-color: black;
  color: white;
  display: none;
  padding: 50px;
  text-align: center;
}

#Driver {background-color:black;}
#Passenger {background-color:black;}

/* Box container to align items */
.box-container {
  display: flex;
  flex-direction: column; /* Stack boxes vertically */
  align-items: center; /* Center items horizontally */
  width: 100%;
}

/* Box styles */
.box {
  width: 90%;
  background-color: #1e1e1e;
  border: none;
  display: flex;
  align-items: flex-start;
  font-size: 18px;
  font-weight: bold;
  color: #ffc107;
  border-radius: 10px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
  padding: 20px;
  margin-top: 50px;
  
}

.box h1 {
  color: #2b64ff;
  font-size: 2.4rem; 
}

.box p {
  color:rgb(208, 220, 255); 
  font-size: 18px;
  font-weight: 200;
  line-height: 1.5;
  text-align: justify !important;   
}

.box:hover {
  transform: scale(1.008);  /* Slightly enlarge the box */
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); /* Optional shadow for depth */
}

/* Image styling */
.box img {
  width: 400px;   
  height: 300px;
  object-fit: cover; 
  border-radius: 5px;
}

.text-content {
  font-size: 16px;
  text-align: left;   
  flex-direction: column;
  margin-left: 30px;
  margin-right: 60px;
}

/* Center and style the NEWS header */
.news-header {
  text-align: center;
  margin-top: 500px; /* Adjust top spacing as needed */
  margin-bottom: 40px; /* Adjust bottom spacing as needed */
}

/* Make the text large, bold, and white */
.news-header h1 {
  color: #fff;            /* White text */
  font-size: 8rem;       
  margin: 0;
  letter-spacing: 2px;    /* Slight spacing between letters */
  font-weight: 400;
}

/* Create a gradient line underneath */
.news-underline {
  width: 400px;           /* Adjust width to your liking */
  height: 8px;            /* Thickness of the line */
  margin: 10px auto 0;    /* Center it below the text */
  border-radius: 2px;     /* Rounded corners */
  background: #2b64ff;
  margin-bottom: 20px;
}

.news-slogan {
  color: #ccc;            /* Lighter grey for the slogan */
  font-size: 2rem;        /* Adjust font size as needed */
  margin-top: 10px;
  margin-bottom: 500px;
}



        </style>
    </head>
<body>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="image/news/safety.jpg" alt="Slide 1"></div>
            <div class="swiper-slide"><img src="image/news/promotion.jpg" alt="Slide 2"></div>
            <div class="swiper-slide"><img src="image/news/bonus.jpg" alt="Slide 3"></div>
            <div class="swiper-slide"><img src="image/news/serviceUpdate.jpg" alt="Slide 4"></div>
        </div>

 
        <div class="swiper-pagination"></div>

  
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>


    <div class="news-header">
        <h1>NEWS</h1>
        <div class="news-underline"></div>
        <p class="news-slogan">Where every ride meets excellence.</p>
    </div>


    <div class="tab-container">
        <div class="tablinks-container">
            <button class="tablink" onclick="openCity('Driver', this, 'black')" id="defaultOpen">Driver</button>
            <button class="tablink" onclick="openCity('Passenger', this, 'black')">Passenger</button>
        </div>   

        <div id="Driver" class="tabcontent">
            <div class="box-container">

                <div class="box">
                    <img src="image/news/bonus.jpg" alt="Driver 1">
                    <div class="text-content">
                        <br><br>
                        <h1>Earnings & Incentives</h1>
                        <br><br>
                        <p>Stay informed and maximize your income with our dedicated Earnings & Incentives news section. Here, you’ll receive detailed updates on bonus programs, seasonal promotions, and any adjustments to our payment systems. We provide actionable insights and tips to help you make the most out of every ride. Whether it’s a flash bonus for peak hours or special rewards during high-demand periods, our comprehensive coverage ensures you never miss an opportunity to boost your earnings. We’re committed to supporting your financial success by keeping you up-to-date on all the latest incentive programs and payment enhancements available.</p>
                        </div>
                </div>


                <div class="box">
                    <div class="text-content">
                        <br><br>
                        <h1>Safety & Maintenance Tips</h1>
                        <br><br>
                        <p>Your safety on the road is our top priority, and this section is devoted to empowering you with the best practices for secure driving. Our Safety & Maintenance Tips provide in-depth guidance on routine vehicle upkeep, proactive maintenance checks, and essential safe driving techniques. We cover everything from seasonal safety advice to emergency procedures and innovative methods to keep your car in top condition. By following our expert recommendations, you can minimize risks, prevent unexpected breakdowns, and ensure that every journey is as safe as possible. Our goal is to equip you with the knowledge needed to drive confidently and securely.</p>
                    </div>
                    <img src="image/news/safety.jpg" alt="Driver 2">
                </div>


                <div class="box">
                    <img src="image/news/new.jpg" alt="Driver 3">
                    <div class="text-content">
                        <br><br>
                        <h1>Technology & App Updates</h1>
                        <br><br>
                        <p>Experience the cutting edge of driver support with our Technology & App Updates news section. Here, we share comprehensive insights on the latest improvements to our mobile application, new features, and technology integrations designed to simplify your driving experience. Stay informed about enhanced navigation tools, performance upgrades, and user-friendly interface changes that make managing your rides effortless. We also offer tips and tutorials on how to leverage these updates for better efficiency and productivity on the road. Our commitment is to ensure that you have access to state-of-the-art technology that supports your success and makes every drive smoother.</p>
                    </div>
                </div>


            </div>
        </div>


        <div id="Passenger" class="tabcontent">
            <div class="box-container">


                <div class="box">
                    <img src="image/news/serviceUpdate.jpg" alt="Passenger 1">
                    <div class="text-content">
                        <br><br>
                        <h1>Service Updates</h1>
                        <br><br>
                        <p>Keep passengers in the loop with the latest service updates. In this section, we provide comprehensive information about new routes, adjusted schedules, and any changes to service areas that directly impact your daily commute. We understand how important reliability and convenience are for your travel plans. Our timely updates ensure you’re aware of any modifications or improvements in the network, helping you plan your journeys with confidence. Whether it’s added stops, extended service hours, or seasonal adjustments, you can trust that our service updates will keep you informed and ready for a smooth ride.</p>
                    </div>
                </div>


                <div class="box">
                    <div class="text-content">
                        <br><br>
                        <h1>Promotions & Discounts</h1>
                        <br><br>
                        <p>Everyone loves a great deal, and our Promotions & Discounts section is designed to help you save on your travels. Here, you’ll find detailed announcements on exclusive discount codes, limited-time offers, and special deals tailored for our passengers. We regularly feature seasonal promotions and partnership offers that make your ride not only affordable but also more enjoyable. Our goal is to add value to your journey by keeping you informed about every opportunity to benefit from cost-saving incentives. Stay tuned to never miss out on the savings that can enhance your overall travel experience.</p>
                    </div>
                    <img src="image/news/promotion.jpg" alt="Passenger 2">
                </div>


                <div class="box">
                    <img src="image/news/safety.jpg" alt="Passenger 3">
                    <div class="text-content">
                        <br><br>
                        <h1>Safety Information</h1>
                        <br><br>
                        <p>Your safety is our utmost priority. In our Safety Information section, we share in-depth updates on the measures we’ve implemented to ensure a secure ride experience for every passenger. Learn about our rigorous driver background checks, the latest safety protocols, and real-time alerts on any service concerns. We provide practical tips for staying safe during your journey, along with updates on technological enhancements designed to monitor and improve security. This commitment to transparency and continuous improvement helps build trust, ensuring that each ride is as safe and comfortable as possible.</p>
                    </div>
                </div>


            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="js/homepage/news.js"></script>

</body>
</html>