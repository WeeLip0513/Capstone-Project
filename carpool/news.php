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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <style>
 /* Ensure the slider takes full width */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: black;
    color: white;
}

.swiper-container {
    width: 100%;
    height: 750px;
    margin: 40px auto 0; /* Adds 50px margin from the top */
    overflow: hidden;
    position: relative; /* Ensures elements inside stay positioned properly */
}

/* Make sure dots stay inside the slider */
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

/* Navigation button styles */
.swiper-button-next,
.swiper-button-prev {
    color: white;
    background: rgba(0, 0, 0, 0.5);
    padding: 20px;
    border-radius: 50%;
}

/* Dot (pagination) styles */
.swiper-pagination-bullet {
    background: white;
    width: 12px;
    height: 12px;
}

/*2*/

.tablink {
  background-color: #555;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 50%;
}

.tablink:hover {
  background-color: #777;
}

.tab-container {
    margin-top: 50px; /* Adjust the value as needed */
}

/* Style the tab content */
.tabcontent {
  color: white;
  display: none;
  padding: 50px;
  text-align: center;
}

#Driver {background-color:#410055;}
#Passenger {background-color:#410055;}

/* Box container to align items */
.box-container {
    display: flex;
    flex-direction: column; /* Stack boxes vertically */
    align-items: center; /* Center items horizontally */
    width: 100%;
}

/* Box styles */
.box {
    width: 60%;
    background-color: white;
    border: 2px solid black;
    display: flex;
    flex-direction: coloum;
    align-items: center;
    font-size: 18px;
    font-weight: bold;
    color: black;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
    padding: 20px;
    margin-top: 50px
}

/* Image styling */
.box img {
    width: 500px; /* Make images responsive */
    height: 500px; /* Adjust image height */
    object-fit: cover; /* Ensures images fit nicely */
    border-radius: 5px;
    margin-right: 10px;
}

.text-content {
    flex: 1; /* Allow text to take remaining space */
    font-size: 16px;
    text-align: left;
}

</style>
</head>
<body>

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="image/news/whitebg.jpeg" alt="Slide 1"></div>
            <div class="swiper-slide"><img src="image/news/whitebg.jpeg" alt="Slide 2"></div>
            <div class="swiper-slide"><img src="image/news/whitebg.jpeg" alt="Slide 3"></div>
            <div class="swiper-slide"><img src="image/news/whitebg.jpeg" alt="Slide 4"></div>
        </div>

 
        <div class="swiper-pagination"></div>

  
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>


    <div class="tab-container">
        <button class="tablink" onclick="openCity('Driver', this, '#410055')" id="defaultOpen">Driver</button>
        <button class="tablink" onclick="openCity('Passenger', this, '#410055')">Passenger</button>

        <div id="Driver" class="tabcontent">
            <div class="box-container">

                <div class="box">
                    <img src="image/homepage/driver1.jpg" alt="Driver 1">
                    <div class="text-content">
                        <h1>Driver Goods 1</h1>
                        <br><br><br>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit, accusamus? In, necessitatibus quibusdam? Accusamus quaerat corrupti corporis consequuntur cumque nisi.</p>
                    </div>
                </div>


                <div class="box">
                    <img src="image/homepage/driver1.jpg" alt="Driver 2">
                    <div class="text-content">
                    <h1>Driver Goods 2</h1>
                        <br><br><br>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit, accusamus? In, necessitatibus quibusdam? Accusamus quaerat corrupti corporis consequuntur cumque nisi.</p>
                    </div>
                </div>


                <div class="box">
                    <img src="image/homepage/driver1.jpg" alt="Driver 3">
                    <div class="text-content">
                    <h1>Driver Goods 3</h1>
                        <br><br><br>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit, accusamus? In, necessitatibus quibusdam? Accusamus quaerat corrupti corporis consequuntur cumque nisi.</p>
                    </div>
                </div>


            </div>
        </div>


        <div id="Passenger" class="tabcontent">
            <div class="box-container">


                <div class="box">
                    <img src="image/homepage/driver2.jpg" alt="Passenger 1">
                    <div class="text-content">
                    <h1>Passenger Goods 1</h1>
                        <br><br><br>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit, accusamus? In, necessitatibus quibusdam? Accusamus quaerat corrupti corporis consequuntur cumque nisi.</p>
                    </div>
                </div>


                <div class="box">
                    <img src="image/homepage/driver2.jpg" alt="Passenger 2">
                    <div class="text-content">
                    <h1>Passenger Goods 2</h1>
                        <br><br><br>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit, accusamus? In, necessitatibus quibusdam? Accusamus quaerat corrupti corporis consequuntur cumque nisi.</p>
                    </div>
                </div>


                <div class="box">
                    <img src="image/homepage/driver2.jpg" alt="Passenger 3">
                    <div class="text-content">
                    <h1>Passenger Goods 3</h1>
                        <br><br><br>
                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Suscipit, accusamus? In, necessitatibus quibusdam? Accusamus quaerat corrupti corporis consequuntur cumque nisi.</p>
                    </div>
                </div>


            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script>
        var swiper = new Swiper('.swiper-container', {
            slidesPerView: 1.5, // Show part of previous & next slides
            spaceBetween: 20, // Spacing between slides
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
            }

            // Show the selected tab content
            document.getElementById(cityName).style.display = "block";
            elmnt.style.backgroundColor = color;

            }
            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
</script>

</body>
</html>