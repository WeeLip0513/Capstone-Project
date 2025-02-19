<?php
    include ("dbconn.php");
    include ("headerHomepage.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="css/homepage.css">
</head>
<body>
    <div class="homepage-container">
        <div class="wrapper">
            <div class="ads">
                <input type="radio" name="slide" id="a1">
                <label for="a1" class="card">
                    <div class="row">
                        <div class="description">
                            <h4>Welcome to APshare</h4>
                            <p>Check it out</p>
                        </div>
                    </div>
                </label>
                <input type="radio" name="slide" id="a2" checked>
                <label for="a2" class="card">
                    <div class="row">
                        <div class="description">
                            <h2>Welcome to APshare</h2>
                            <p>Check it out</p>
                        </div>
                    </div>
                </label>
                <input type="radio" name="slide" id="a3">
                <label for="a3" class="card">
                    <div class="row">
                        <div class="description">
                            <h4>Passenger</h4>
                            <p>Check it out</p>
                        </div>
                    </div>
                </label>
            </div>
        </div>
        <div class="slogan-1">
            <br><br><br>
            <h1>Lorem ipsum dolor sit amet.</h1>
            <h4>Lorem ipsum dolor sit amet, consectetur adipisicing elit. 
                Cupiditate iure enim odio necessitatibus dolorem aut vel, blanditiis 
                laborum doloremque consequuntur similique facilis quo facere minima saepe 
                ipsa perferendis tempore molestiae reiciendis, veniam sequi fuga ab optio 
                adipisci! Aperiam ad, dolorum at quia et deleniti molestias neque cumque assumenda 
                distinctio quo? sefehofeoveivee esfneofnei.
            </h4>
            <div class="wave" id="wave1" style="--i:1;"></div>
            <div class="wave" id="wave2" style="--i:2;"></div>
            <div class="wave" id="wave3" style="--i:3;"></div>
            <div class="wave" id="wave4" style="--i:4;"></div>
        </div>
        <div class="ourservices">
            <br><br><br>
            <h1>Choose Your Role</h1>
            <br><br><br>
            <div class="rolecard">
                <div class="role">
                    <div class="icon">
                        <img src="image/homepage/driver.png" alt="driver icon" width="130px" height="120px">
                    </div>   
                    <h2>Driver</h2>             
                    <p>Join our community of drivers and start earning by sharing your rides with passengers heading in the same direction.</p>
                    <a href="/driver" class="learn-more">Learn More</a>
                </div>
                <div class="role">
                    <div class="icon">
                        <img src="image/homepage/passenger.png" alt="passenger icon" width="120px" height="110px">
                    </div>
                    <h2>Passenger</h2>
                    <p>Find convenient and affordable rides to your destination. Connect with reliable drivers in your area.</p>
                    <a href="/passenger" class="learn-more">Learn More</a>
                </div>
            </div>
        </div>
        <div class="feature">
            <br><br><br>
            <h1>Our Features</h1>
            <div class="feature-container swiper">
                <div class="feature-wrapper">
                    <div class="feature-list swiper-wrapper">
                        <div class="feature-item swiper-slide">
                            <h2>Ride Creation</h2>
                            <p>Create your own ride</p>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>Earnings</h2>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>name</h2>
                        </div>
                        <div class="feature-item swiper-slide">
                            <h2>name</h2>
                        </div>
                    </div>
                    <br><br>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-slide-button swiper-button-prev"></div>
                    <div class="swiper-slide-button swiper-button-next"></div>
                </div>
            </div>
        </div>
        <script>
            let wave1 = document.getElementById('wave1');
            let wave2 = document.getElementById('wave2');
            let wave3 = document.getElementById('wave3');
            let wave4 = document.getElementById('wave4');
    
            windows.addEventListener('scroll', function(){
                let value = window.scrollY;
    
                wave1.style.backgroundPositionX = 400 + value * 4 + 'px';
                wave2.style.backgroundPositionX = 300 + value * -4 + 'px';
                wave3.style.backgroundPositionX = 200 + value * 2 + 'px';
                wave4.style.backgroundPositionX = 100 + value * -2 + 'px';
            })
        </script>
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="js/homepage/swiper.js"></script>
    </div>
</body>
</html>