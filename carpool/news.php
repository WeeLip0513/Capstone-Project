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
        <link rel="stylesheet" href="css/news.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    </head>
<body>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="image/news/safety.jpg" alt="Slide 1"></div>
            <div class="swiper-slide"><img src="image/news/promotion.jpg" alt="Slide 2"></div>
            <div class="swiper-slide"><img src="image/news/bonus2.jpg" alt="Slide 3"></div>
            <div class="swiper-slide"><img src="image/news/newupdate.jpg" alt="Slide 4"></div>
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
                    <img src="image/news/bonus2.jpg" alt="Driver 1">
                    <div class="text-content">
                        <h1>Earnings & Incentives</h1>
                        <br>
                        <p>Stay informed and maximize your income with our dedicated Earnings & Incentives news section. Here, you’ll receive detailed updates on bonus programs, seasonal promotions, and any adjustments to our payment systems. We provide actionable insights and tips to help you make the most out of every ride. Whether it’s a flash bonus for peak hours or special rewards during high-demand periods, our comprehensive coverage ensures you never miss an opportunity to boost your earnings. We’re committed to supporting your financial success by keeping you up-to-date on all the latest incentive programs and payment enhancements available.</p>
                        </div>
                </div>


                <div class="box">
                    <div class="text-content">
                        <h1>Safety & Maintenance Tips</h1>
                        <br>
                        <p>Your safety on the road is our top priority, and this section is devoted to empowering you with the best practices for secure driving. Our Safety & Maintenance Tips provide in-depth guidance on routine vehicle upkeep, proactive maintenance checks, and essential safe driving techniques. We cover everything from seasonal safety advice to emergency procedures and innovative methods to keep your car in top condition. By following our expert recommendations, you can minimize risks, prevent unexpected breakdowns, and ensure that every journey is as safe as possible. Our goal is to equip you with the knowledge needed to drive confidently and securely.</p>
                    </div>
                    <img src="image/news/safety.jpg" alt="Driver 2">
                </div>


                <div class="box">
                    <img src="image/news/newupdate.jpg" alt="Driver 3">
                    <div class="text-content">
                        <h1>Technology & App Updates</h1>
                        <br>
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
                        <h1>Service Updates</h1>
                        <br>
                        <p>Keep passengers in the loop with the latest service updates. In this section, we provide comprehensive information about new routes, adjusted schedules, and any changes to service areas that directly impact your daily commute. We understand how important reliability and convenience are for your travel plans. Our timely updates ensure you’re aware of any modifications or improvements in the network, helping you plan your journeys with confidence. Whether it’s added stops, extended service hours, or seasonal adjustments, you can trust that our service updates will keep you informed and ready for a smooth ride.</p>
                    </div>
                </div>


                <div class="box">
                    <div class="text-content">
                        <h1>Promotions & Discounts</h1>
                        <br>
                        <p>Everyone loves a great deal, and our Promotions & Discounts section is designed to help you save on your travels. Here, you’ll find detailed announcements on exclusive discount codes, limited-time offers, and special deals tailored for our passengers. We regularly feature seasonal promotions and partnership offers that make your ride not only affordable but also more enjoyable. Our goal is to add value to your journey by keeping you informed about every opportunity to benefit from cost-saving incentives. Stay tuned to never miss out on the savings that can enhance your overall travel experience.</p>
                    </div>
                    <img src="image/news/promotion.jpg" alt="Passenger 2">
                </div>


                <div class="box">
                    <img src="image/news/safety.jpg" alt="Passenger 3">
                    <div class="text-content">
                        <h1>Safety Information</h1>
                        <br>
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
<?php include('footer.php'); ?>