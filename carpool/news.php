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
        <link rel="stylesheet" href="css/news.css">
   
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


    <div class="New">
        <span class="letter">N</span>
        <span class="letter">E</span>
        <span class="letter">W</span>
        <span class="letter">S</span>
        <span class="letter">!</span>
    </div>


    <div class="tab-container">
        <div class="tablinks-container">
            <button class="tablink" onclick="openCity('Driver', this, 'black')" id="defaultOpen">Driver</button>
            <button class="tablink" onclick="openCity('Passenger', this, 'black')">Passenger</button>
        </div>   

        <div id="Driver" class="tabcontent">
            <div class="box-container">

                <div class="box">
                    <img src="image/homepage/driver2.jpg" alt="Driver 1">
                    <div class="text-content">
                        <br><br>
                        <h1>Earnings & Incentives</h1>
                        <br><br>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo inventore vero corporis sequi quis temporibus iusto voluptatem vel vitae veniam, est saepe, magnam soluta quos provident corrupti? Culpa esse incidunt eligendi optio dignissimos perspiciatis? Ipsum quam ea maiores quasi ratione quis doloremque saepe illo, quod veritatis placeat possimus cum officiis facere recusandae tenetur a et ullam unde vitae! Error nobis eligendi fuga delectus est, aliquam eos accusantium hic accusamus, perferendis nesciunt cupiditate laudantium necessitatibus voluptates dolor modi, possimus itaque optio dignissimos in odit! Rem ipsum officiis atque cum optio exercitationem itaque veritatis inventore voluptatum, obcaecati incidunt ut assumenda rerum quidem.
                        </p>
                        </div>
                </div>


                <div class="box">
                    <div class="text-content">
                        <br><br>
                        <h1>Driver Goods 2</h1>
                        <br><br>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo inventore vero corporis sequi quis temporibus iusto voluptatem vel vitae veniam, est saepe, magnam soluta quos provident corrupti? Culpa esse incidunt eligendi optio dignissimos perspiciatis? Ipsum quam ea maiores quasi ratione quis doloremque saepe illo, quod veritatis placeat possimus cum officiis facere recusandae tenetur a et ullam unde vitae! Error nobis eligendi fuga delectus est, aliquam eos accusantium hic accusamus, perferendis nesciunt cupiditate laudantium necessitatibus voluptates dolor modi, possimus itaque optio dignissimos in odit! Rem ipsum officiis atque cum optio exercitationem itaque veritatis inventore voluptatum, obcaecati incidunt ut assumenda rerum quidem.
                        </p>
                    </div>
                    <img src="image/homepage/driver2.jpg" alt="Driver 2">
                </div>


                <div class="box">
                    <img src="image/homepage/driver2.jpg" alt="Driver 3">
                    <div class="text-content">
                        <br><br>
                        <h1>Driver Goods 3</h1>
                        <br><br>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo inventore vero corporis sequi quis temporibus iusto voluptatem vel vitae veniam, est saepe, magnam soluta quos provident corrupti? Culpa esse incidunt eligendi optio dignissimos perspiciatis? Ipsum quam ea maiores quasi ratione quis doloremque saepe illo, quod veritatis placeat possimus cum officiis facere recusandae tenetur a et ullam unde vitae! Error nobis eligendi fuga delectus est, aliquam eos accusantium hic accusamus, perferendis nesciunt cupiditate laudantium necessitatibus voluptates dolor modi, possimus itaque optio dignissimos in odit! Rem ipsum officiis atque cum optio exercitationem itaque veritatis inventore voluptatum, obcaecati incidunt ut assumenda rerum quidem.
                        </p>
                    </div>
                </div>


            </div>
        </div>


        <div id="Passenger" class="tabcontent">
            <div class="box-container">


                <div class="box">
                    <img src="image/homepage/driver1.jpg" alt="Passenger 1">
                    <div class="text-content">
                        <br><br>
                        <h1>Passenger Goods 1</h1>
                        <br><br>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo inventore vero corporis sequi quis temporibus iusto voluptatem vel vitae veniam, est saepe, magnam soluta quos provident corrupti? Culpa esse incidunt eligendi optio dignissimos perspiciatis? Ipsum quam ea maiores quasi ratione quis doloremque saepe illo, quod veritatis placeat possimus cum officiis facere recusandae tenetur a et ullam unde vitae! Error nobis eligendi fuga delectus est, aliquam eos accusantium hic accusamus, perferendis nesciunt cupiditate laudantium necessitatibus voluptates dolor modi, possimus itaque optio dignissimos in odit! Rem ipsum officiis atque cum optio exercitationem itaque veritatis inventore voluptatum, obcaecati incidunt ut assumenda rerum quidem.
                        </p>
                    </div>
                </div>


                <div class="box">
                    <div class="text-content">
                        <br><br>
                        <h1>Passenger Goods 2</h1>
                        <br><br>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo inventore vero corporis sequi quis temporibus iusto voluptatem vel vitae veniam, est saepe, magnam soluta quos provident corrupti? Culpa esse incidunt eligendi optio dignissimos perspiciatis? Ipsum quam ea maiores quasi ratione quis doloremque saepe illo, quod veritatis placeat possimus cum officiis facere recusandae tenetur a et ullam unde vitae! Error nobis eligendi fuga delectus est, aliquam eos accusantium hic accusamus, perferendis nesciunt cupiditate laudantium necessitatibus voluptates dolor modi, possimus itaque optio dignissimos in odit! Rem ipsum officiis atque cum optio exercitationem itaque veritatis inventore voluptatum, obcaecati incidunt ut assumenda rerum quidem.
                        </p>
                    </div>
                    <img src="image/homepage/driver1.jpg" alt="Passenger 2">
                </div>


                <div class="box">
                    <img src="image/homepage/driver1.jpg" alt="Passenger 3">
                    <div class="text-content">
                        <br><br>
                        <h1>Passenger Goods 3</h1>
                        <br><br>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo inventore vero corporis sequi quis temporibus iusto voluptatem vel vitae veniam, est saepe, magnam soluta quos provident corrupti? Culpa esse incidunt eligendi optio dignissimos perspiciatis? Ipsum quam ea maiores quasi ratione quis doloremque saepe illo, quod veritatis placeat possimus cum officiis facere recusandae tenetur a et ullam unde vitae! Error nobis eligendi fuga delectus est, aliquam eos accusantium hic accusamus, perferendis nesciunt cupiditate laudantium necessitatibus voluptates dolor modi, possimus itaque optio dignissimos in odit! Rem ipsum officiis atque cum optio exercitationem itaque veritatis inventore voluptatum, obcaecati incidunt ut assumenda rerum quidem.
                        </p>
                    </div>
                </div>


            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="js/homepage/news.js"></script>

</body>
</html>