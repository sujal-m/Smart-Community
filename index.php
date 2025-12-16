<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomEase - Professional Handyman Services</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Navigation Header -->
    <header class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <span><img src="assets/images/logo.png" alt=""></span>
            </div>
            <nav class="nav-menu">
                <a href="index.php" class="nav-link active">Home</a>
                <a href="pages/services.php" class="nav-link">Services</a>
                <a href="pages/contact.php" class="nav-link">Contact</a>
                <a href="pages/blog.php" class="nav-link">Blog</a>
            </nav>
            <div class="navbar-right">
              <?php
              if (isset($_SESSION['user_id'])) {
                  echo '<a href="pages/user_dashboard.php" class="cta-btn">Dashboard</a>';
              } elseif (isset($_SESSION['pro_id'])) {
                  echo '<a href="pages/pro_dashboard.php" class="cta-btn">Dashboard</a>';
              } else {
                  echo '<a href="pages/login.php" class="cta-btn">Login</a>';
              }
              ?>
            </div>


        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <p class="hero-subtitle">PROFESSIONAL SOLUTIONS</p>
            <h1 class="hero-title">Expert Handyman Services<br>for Your Home</h1>
            <p class="hero-description">
                From plumbing to carpentry, electrical work to home renovations, 
                HomEase provides comprehensive handyman services to keep your home in perfect condition.
            </p>
            <button class="btn btn-primary">Get Started</button>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <h3 class="light-text">SERVICES</h3>
        <div class="container">
            <h2 class="section-title">We can handle all types of handyman services</h2>
            <br><br>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon"><img src="assets/images/1-1.png" alt=""></div>
                    <h3>Plumbing</h3>
                    <p>Expert plumbing solutions for all your water system needs, from repairs to installations.</p>
                    <a class="service-link" href="pages/service_detail.php?service=plumbing">Read More</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><img src="assets/images/1-2.png" alt=""></div>
                    <h3>Electrical</h3>
                    <p>Professional electrical services including wiring, repairs, and safety inspections.</p>
                    <a class="service-link" href="pages/service_detail.php?service=electrical">Read More</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><img src="assets/images/1-3.png" alt=""></div>
                    <h3>Carpentry</h3>
                    <p>Custom carpentry work for furniture, shelving, doors, and structural repairs.</p>
                    <a class="service-link" href="pages/service_detail.php?service=carpentry">Read More</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><img src="assets/images/1-4.png" alt=""></div>
                    <h3>Painting</h3>
                    <p>Interior and exterior painting services with premium quality finishes.</p>
                    <a class="service-link" href="pages/service_detail.php?service=painting">Read More</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><img src="assets/images/1-5.png" alt=""></div>
                    <h3>Flooring</h3>
                    <p>Professional flooring installation and repair for all types of surfaces.</p>
                    <a class="service-link" href="pages/service_detail.php?service=flooring">Read More</a>
                </div>
                <div class="service-card">
                    <div class="service-icon"><img src="assets/images/1-6.png" alt=""></div>
                    <h3>Home Renovation</h3>
                    <p>Complete home renovation services to transform your living space.</p>
                    <a class="service-link" href="pages/service_detail.php?service=renovation">Read More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <div class="container">
            <h3 class="light-text">WHY US</h3>
            <h2 class="section-title">Why Choose HomEase for Your Handyman Needs</h2>
            <div class="reasons-grid">
                <div class="reason-card">
                    <div class="reason-icon"><img src="assets/images/1-1.jpg" alt=""></div>
                    <h3>Experienced Professionals</h3>
                    <p>Our team of experienced professionals ensures top-notch service every time.</p>
                </div>  
                <div class="reason-card">
                    <div class="reason-icon"><img src="assets/images/1-2.jpg" alt=""></div> 
                    <h3>Quality Workmanship</h3>
                    <p>We pride ourselves on delivering high-quality workmanship and attention to detail.</p>
                </div>  
                <div class="reason-card">
                    <div class="reason-icon"><img src="assets/images/1-3.jpg" alt=""></div>
                    <h3>Customer Satisfaction</h3>
                    <p>Your satisfaction is our priority. We guarantee customer satisfaction with every job.</p>
                </div>  
                <div class="reason-card">
                    <div class="reason-icon"><img src="assets/images/1-4.jpg" alt=""></div>
                    <h3>Competitive Pricing</h3>
                    <p>We offer competitive pricing without compromising on quality or service.</p>
                </div>  
                <div class="reason-card">
                    <div class="reason-icon"><img src="assets/images/1-6.jpg" alt=""></div>
                    <h3>Customer Reviews</h3>
                    <p>Read what our satisfied customers have to say about our services.</p>
                </div>  
                <div class="reason-card">
                    <div class="reason-icon"><img src="assets/images/1-5.jpg" alt=""></div>
                    <h3>Emergency Services</h3>
                    <p>We provide 24/7 emergency services to handle unexpected issues promptly.</p>
                </div>  
            </div>
    </section>

    <!-- About us -->
    <section class="about-section" id="about">
        
  <div class="about-container">
    <div class="about-images">
      <div class="image image1">
        <img src="assets/images/about-1-1.jpg" alt="Handyman 1">
      </div>
      <div class="image image2">
        <img src="assets/images/about-1-2.jpg" alt="Handyman 2">
      </div>
    </div>

    <div class="about-content">
        <h3 class="light-text">ABOUT US</h3>
        <h2 class="section-title2">We make handyman <br> service for your home</h2>
        <p class="section-description">
        We offer trusted handyman services for your home.  <br>
        Our team provides expert repairs, maintenance, and improvements with reliable quality and care.
        </p>

      <div class="about-points">
        <div class="point">
          <span class="icon">✔</span>
          <p>Professional Worker</p>
        </div>
        <div class="point">
          <span class="icon">✔</span>
          <p>Trusted Company</p>
        </div>
        <div class="point">
          <span class="icon">✔</span>
          <p>Best Quality Materials</p>
        </div>
        <div class="point">
          <span class="icon">✔</span>
          <p>Affordable Price</p>
        </div>
      </div>

      <a href="#" class="btn-learn">Learn More</a>
    </div>
  </div>
    </section>

    <!-- contact us -->
     <section class="contact-section">
        <div class="contact-container">
            <h1>We make creative solutions.</h1>
            <a href="#" class="btn-contact">Contact Us</a>
        </div>
     </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="testimonial-header">
            <h4 class="light-text">TESTIMONIAL</h4>
            <h2 class="section-title">Happy Client Says <br> About Us</h2>
        </div>

        <div class="testimonial-container">
            <!-- Testimonial 1 -->
            <div class="testimonial-card">
            <div class="quote-icon"><img src="assets/images/quote.png" alt=""></div>
            <p class="testimonial-text">"The magic formula that successful businesses have discovered is to treat customers"</p>
            <div class="client-info">
                <img src="https://randomuser.me/api/portraits/men/45.jpg" alt="Bill Lorris">
                <div>
                    <h4>Bill Lorris</h4>
                <p>Business Man</p>
                </div>
            </div>
        </div>

        <!-- Testimonial 2 (active) -->
        <div class="testimonial-card">
        <div class="quote-icon"><img src="assets/images/quote.png" alt=""></div>
        <p class="testimonial-text">"The team was professional, quick, and did an excellent job fixing everything in my home!"
        </p>
      <div class="client-info">
        <img src="https://randomuser.me/api/portraits/men/52.jpg" alt="Josh Batlar">
        <div>
          <h4>Josh Batlar</h4>
          <p>Factory Foreman</p>
        </div>
      </div>
    </div>

    <!-- Testimonial 3 -->
    <div class="testimonial-card">
      <div class="quote-icon"><img src="assets/images/quote.png" alt=""></div>
      <p class="testimonial-text">
        "Fantastic service — they arrived on time and the results were even better than expected."
      </p>
      <div class="client-info">
        <img src="https://randomuser.me/api/portraits/men/58.jpg" alt="Joe Root">
        <div>
          <h4>Joe Root</h4>
          <p>Supervisor</p>
        </div>
      </div>
    </div>
          <div class="testimonial-card">
        <div class="quote-icon"><img src="assets/images/quote.png" alt=""></div>
        <p class="testimonial-text">"Fantastic electrical repair team—efficient and polite."</p>
        <div class="client-info">
          <img src="https://randomuser.me/api/portraits/men/68.jpg" alt="Client 4">
          <div>
            <h4>John Carter</h4>
            <p>Business Owner</p>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="quote-icon"><img src="assets/images/quote.png" alt=""></div>
        <p class="testimonial-text">"Love their cleaning service—super quick and spotless results!"</p>
        <div class="client-info">
          <img src="https://randomuser.me/api/portraits/women/22.jpg" alt="Client 5">
          <div>
            <h4>Emma Brown</h4>
            <p>Designer</p>
          </div>
        </div>
      </div>

      <div class="testimonial-card">
        <div class="quote-icon"><img src="assets/images/quote.png" alt=""></div>
        <p class="testimonial-text">"Very responsive team. HomEase never disappoints!"</p>
        <div class="client-info">
          <img src="https://randomuser.me/api/portraits/men/15.jpg" alt="Client 6">
          <div>
            <h4>David Lee</h4>
            <p>Manager</p>
          </div>
        </div>
      </div>
     </div>
  </div>

  <!-- Pagination dots -->
  <div class="testimonial-dots">
    <span class="dot active-dot"></span>
    <span class="dot"></span>
  </div>
    </section>
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <img src="assets/images/logo_white.png" alt="">
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
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>For Professionals</h4>
                    <ul>
                        <li><a href="pages/pro_login.php">Login as Professional</a></li>
                        <li><a href="pages/contact.php">Contact</a></li>  
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
    <script src="script.js"></script>
</body>

</html>
