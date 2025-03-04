<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
            box-sizing: border-box;
        }

        body {
            background: black;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            padding: 1rem 4rem;
            background: #410055;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
            z-index: 10;
        }

        .logo {
            font-size: 1.7rem;
            font-weight: bold;
            color: white;
            cursor: pointer;
        }

        .navlinks {
            list-style: none;
            display: flex;
            gap: 3rem;
            align-items: center;
        }

        .navlinks li a {
            text-decoration: none;
            color: white;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .navlinks li a:hover {
            color: #ffc107;
        }

        /* Contact Page Styles */
        .container {
            margin-top: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 80%;
            max-width: 1000px;
            padding: 50px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .header {
            font-size: 3rem;
            margin-bottom: 30px;
            color: white;
        }

        .content {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
        }

        .contact-info {
            padding-left: 100px;
        }

        .contact-info p {
            font-size: 1.3rem;
            margin: 10px 0;
            color: #d1d1d1;
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 10px;
            transition: background 0.3s ease;
        }

        .contact-info p:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .icon-circle {
            width: 55px;
            height: 55px;
            border-radius: 50%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
        }

        .icon-circle i {
            color: #00aaff;
            font-size: 1.5rem;
        }

        .contact-form {
            width: 50%;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .contact-form h2 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #333;
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-bottom: 2px solid #ddd;
            outline: none;
            font-size: 1rem;
            background-color: #f9f9f9;
        }

        .contact-form button {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #00aaff;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div class="logo">APshare</div>
        <ul class="navlinks">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Support Us</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">Contact Us</div>
        <div class="content">
            <div class="contact-info">
                <p><div class="icon-circle"><i class="fas fa-map-marker-alt"></i></div>Address: XXXXXXXXX</p>
                <p><div class="icon-circle"><i class="fas fa-phone"></i></div>Phone: 507-XXX-XXXX</p>
                <p><div class="icon-circle"><i class="fas fa-envelope"></i></div>Email: example@domain.com</p>
            </div>
            <div class="contact-form">
                <h2>Send Message</h2>
                <form>
                    <input type="text" placeholder="Full Name" required>
                    <input type="email" placeholder="Email" required>
                    <textarea placeholder="Type your Message..." rows="4" required></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
