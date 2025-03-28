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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
        <!-- <link rel="stylesheet" href="css/news.css"> -->
        
<style>
  /* *{
 border: 2px solid red;
} */

body {
  margin: 0;
  font-family: Arial, Helvetica;
  background-color: black;
  color: white;
}

.swiper-container {
  width: 100%;
  height: 600px;
  max-height: 600px;
  margin: 100px auto 0;
  overflow: hidden;
  position: relative; /* Ensures elements inside stay positioned properly */
}

.swiper-pagination {
  width: 100%;
  text-align: center;
  bottom: 10px;
  left: 0;
  transform: none;
}

  .swiper-slide {
    width: 100%;
    height: 100%;
    display: flex;  
    justify-content: center;
    align-items: center;
    object-fit: cover;
  }

/* Ensure images fill slides */ 
.swiper-slide img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-fit: contain;
  border-radius: 0;
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
.tab-container {
  margin-top: 50px;
}

.tablink {
  background-color: transparent;
  color: rgb(160, 160, 160); 
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 40px;
  font-weight: bold;
  transition: background-color 0.3s, color 0.3s, border-color 0.3s;
  border: none;
  position: relative;
}


.tablink.active {
  color: #2b83ff;
}

.tablink.active::after {
  content: "";
  position: absolute;
  left: 50%;               /* Start at the center */
  transform: translateX(-50%); /* Move back by 50% to center it */
  bottom: 0;              /* Position at the bottom edge of the button */
  width: 100%;
  height: 3px;            /* Thickness of the underline */
  background-color: #2b83ff;
}

/* Hover effect only on non-active tabs */
.tablink:not(.active):hover {
  color: white;
}

.tablinks-container {
  display: inline-block;   
  margin-left: 130px;
  width: auto;
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
  text-align: center;
  padding: 0px;
  margin-bottom: 65px;
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
  border-radius: 10px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
  padding: 20px;
  margin: 20px;  
}

.box h1 {
  margin-top: 10px;
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
  min-width: 420px;   
  min-height: 300px;
  max-width: 420px;   
  max-height: 300px;
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
  margin-top: 500px; 
  margin-bottom: 40px; 
}

/* Make the text large, bold, and white */
.news-header h1 {
  color: #fff;       
  font-size: 8rem;       
  margin: 0;
  letter-spacing: 2px;    /* Slight spacing between letters */
  font-weight: 400;
}

/* Create a gradient line underneath */
.news-underline {
  width: 400px;          
  height: 8px;            /* Thickness of the line */
  margin: 10px auto 0;    /* Center it below the text */
  border-radius: 2px;     /* Rounded corners */
  background: #2b64ff;
  margin-bottom: 20px;
}

.news-slogan {
  color: #ccc;  /* Lighter grey for the slogan */
  font-size: 2rem; 
  margin-top: 10px;
  margin-bottom: 500px;
}

@media (max-width: 768px) {
  .tablink {
    font-size: 28px;    /* Smaller font size */
    padding: 10px 12px;  /* Reduced padding */
  }
  
  .tablinks-container {
    margin-left: 50px;
  }

.box {
    flex-direction: column;   /* Stacks vertically */
    align-items: center;      
    text-align: center;       
  }
  /* Force the image to appear first */
  .box img {
    order: -1;               /* This ensures image is placed before text-content */
    width: 50% !important;
    height: auto !important;
    margin: 0 auto 20px;     /* Center the image & add spacing below */
    min-width: auto;
    min-height: 200px;
    max-width: auto;
    max-height: 200px;
  }

  .text-content {
    margin-left: 0;
    margin-right: 0;
    max-width: 90%;
    order: 0; /* Text after the image */
  }

  .text-content h1 {
    font-size: 1.5rem;
  }

  .text-content p {
    font-size: 1rem;
  }
}

</style>      
    </head>
<body>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="image/news/promoteSlide1.png" alt="Slide 1"></div>
            <div class="swiper-slide"><img src="image/news/promotion.jpg" alt="Slide 2"></div>
            <div class="swiper-slide"><img src="image/news/safety.jpg" alt="Slide 3"></div>
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
<script>
  var swiper = new Swiper('.swiper-container', {
  slidesPerView: 1.5, // Show part of previous & next slides
  spaceBetween: 2, // Spacing between slides
  centeredSlides: true, // Center active slide
  watchSlidesProgress: true, // Helps Swiper track slides correctly
  loop: true, // Enable infinite scrolling
  autoplay: {
      delay: 3000, // Auto-slide every 3 seconds
      disableOnInteraction: false, // Continue autoplay after user interaction
  },
  pagination: {
      el: ".swiper-pagination",
      clickable: true, // Allow clicking on dots
  },
  navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
  },
});

//2
function openCity(cityName,elmnt,color) {
  var i, tabcontent, tablinks;

   // Hide all tab content
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
  }

   // Reset background color for all tab links
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
      tablinks[i].style.backgroundColor = ""; // Remove previous color
      tablinks[i].classList.remove("active");
  }
</script>

</body>
</html>
<?php include('footer.php'); ?>