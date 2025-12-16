<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomEase - Professional Services</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>

    .contact-row {
        display: flex;
        justify-content: center;
        gap: 32px;
        padding: 54px 0;
        background: #fff;
    }

    .contact-card {
        width: 340px;
        background: #fff;
        border: 1.6px solid #f2f2ee;
        box-shadow: 0 0px 9px rgba(160,150,156,0.045);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 42px 20px 28px 20px;
        transition: box-shadow 0.18s;
    }

    .contact-card:hover {
        box-shadow: 0 8px 24px rgba(254,134,0,0.11);
    }

    .icon-circle {
        width: 68px;
        height: 68px;
        background: #FF7700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2.3rem;
        margin-bottom: 22px;
        box-shadow: 0 2px 8px rgba(254,134,0,0.12);
        transition: background 0.3s;
    }
    .icon-circle:hover {
        background: #1a2332;
    }
    .contact-details {
        color: #868686;
        text-align: center;
        font-size: 1.10rem;
        line-height: 1.6;
    }

    @media (max-width: 900px) {
        .contact-row {
            flex-direction: column;
            align-items: center;
            gap: 26px;
            padding: 24px 0;
        }
        .contact-card {
            width: 97vw;
            max-width: 360px;
            margin: 0 auto;
        }
    }
      .contact-container {
        margin: 0 auto;
        padding: 0;
        display: flex;
        flex-direction: row;
        align-items: stretch; 
        min-height: 600px;
        width: 100%;
      }

      .image {
        flex: 1; 
        width: 50%;
      }

      .image img {
        width: 100%;
        height: 100%;
        object-fit: cover; 
      }

      .contact-form {
        flex: 1; 
        width: 50%;
        background: #F6F5ED;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 56px 40px;
      }

      .contact-form .touch {
        font-size: 1rem;
        color: #747474;
        letter-spacing: 2px;
        margin-bottom: 12px;
      }

      .contact-form .heading {
        font-family: sans-serif;
        font-size: 2.4rem;
        color: #1F2747;
        font-weight: 600;
        margin-bottom: 32px;
        line-height: 1.21;
      }

      form {
        display: flex;
        flex-direction: column;
        gap: 18px;
        margin-top: 5px;
      }

      input, textarea {
        padding: 13px 16px;
        font-size: 1.02rem;
        border: none;
        background: #fff;
        box-shadow: 0 2px 6px rgba(180,180,162,0.08);
      }

      textarea {
        resize: vertical;
        font-size: 1.02rem;
      }

      .send-btn {
        max-width: 200px;
        background: #FF7700;
        color: #fff;
        border: none;
        padding: 13px 0;
        font-size: 1.1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
      }

      .send-btn:hover {
        background: #212529;
      }

      @media (max-width: 900px) {
        .contact-container {
          flex-direction: column;
        }
        .image {
          display: none; /* Hide the image */
        } .contact-form {
          width: 100%;
        }
        .image {
          height: 300px; /* Fixed height for mobile */
        }
        .contact-form {
          padding: 30px 20px;
        }
      }
    </style>
</head>
<body>

    <!-- Navigation Header -->
    <header class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <span><img src="../assets/images/logo.png" alt=""></span>
            </div>
            <nav class="nav-menu">
                <a href="../index.php" class="nav-link ">Home</a>
                <a href="services.php" class="nav-link">Services</a>
                <a href="#" class="nav-link active">Contact</a>
                <a href="blog.php" class="nav-link">Blog</a>
            </nav>
            <div class="navbar-right">
                <a href="login.php" class="cta-btn">Login</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="display-hero" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/bread-bg.jpg') no-repeat center center/cover;
">
        <div class="display-hero-content">
            <h1 class="display-heading">Contact Us</h1>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- links Section -->
    <section class="links">
      <div class="contact-row">
        <div class="contact-card">
            <div class="icon-circle">
                <img src="../assets/images/1.png" alt="">
            </div>
            <div class="contact-details">
                Munshi Nagar,<br>
                Andheri (W), 400-058
            </div>
        </div>
        <div class="contact-card">
            <div class="icon-circle">
                <img src="../assets/images/2.png" alt="">
            </div>
            <div class="contact-details">
                info@homease.com
            </div>
        </div>
        <div class="contact-card">
            <div class="icon-circle">
              <img src="../assets/images/3.png" alt="">
            </div>
            <div class="contact-details">
                +91-83569 61950
            </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
     <div class="contact-container">
        <div class="image">
            <img src="../assets/images/contact-img.jpg" alt="Engineer">
        </div>
        <div class="contact-form">
            <h6 class="touch">GET IN TOUCH</h6>
            <h1 class="heading">Don't hesitate to contact us for info</h1>
            <form>
                <input type="text" placeholder="Name" required>
                <input type="email" placeholder="Email" required>
                <textarea placeholder="Message" rows="5" required></textarea>
                <button type="submit" class="send-btn">Send</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <img src="../assets/images/logo_white.png" alt="">
                    <p>Your trusted partner for all handyman services.</p>
                </div>
                <div class="footer-section">
                    <h4>Office</h4>
                    <ul>
                        <li>Bhavan's Campus, Old D N Nagar, Munshi Nagar, Andheri (W), 400-058</li>
                        <li><a href="mailto:info@homeease.com">info@homeease.com</a></li>
                        <li><a href="tel:+917208248380">+91 7208248380</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="services.php">Services</a></li>
                        <li><a href="../index.php#about">About Us</a></li>
                        <li><a href="blog.php">Pricing</a></li>
                        <li><a href="blog.php">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>For Professionals</h4>
                    <ul>
                        <li><a href="pro_login.php">Login as Professional</a></li>
                        <li><a href="contact.php">Contact</a></li>  
                    </ul>    
                    <div class="social-icons">
                        <a href="https://www.facebook.com/" aria-label="Facebook" ><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/" aria-label="Twitter" ><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.instagram.com/" aria-label="Instagram" ><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/" aria-label="LinkedIn" ><i class="fa-brands fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 HomEase. All rights reserved.</p>
            </div>
        </div>
    </footer>
<div class="cursor-dot"></div>
<div class="cursor-outline"></div>
    <script src="../script.js"></script>
</body>
</html>