<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blogs - HomEase</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
      <style>
        .faq-accordion {
        background: #fafaf4;
        border-radius: 11px;
        overflow: hidden;
        box-shadow: 0 3px 22px rgba(40,30,8,0.06);
        border: 1px solid #f2ebd7;
        }
        .faq-item + .faq-item {
        border-top: 1px solid #f2ebd7;
        }
        .faq-question {
        width: 100%;
        background: none;
        border: none;
        text-align: left;
        padding: 28px 38px 28px 38px;
        font-size: 1.36rem;
        color: #181710;
        font-weight: 500;
        cursor: pointer;
        outline: none;
        transition: background 0.15s;
        position: relative;
        }
        .faq-question::before {
        content: "+";
        position: absolute;
        left: 12px;
        top: 28%;
        font-size: 2.1rem;
        color: #9d8c65;
        transition: color 0.2s;
        }
        .faq-item.active .faq-question::before {
        content: "–";
        color: #FF7700;
        }
        .faq-answer {
        max-height: 0;
        overflow: hidden;
        background: #fff;
        color: #585757;
        padding: 0 38px;
        font-size: 1.08rem;
        transition: max-height 0.58s cubic-bezier(.61,1.01,.37,1.0);
        }
        .faq-item.active .faq-answer {
        max-height: 200px;
        padding-bottom: 22px;
        padding-top: 20px;
        transition: max-height 0.38s;
        }
        </style>
</head>
<body>

    <!-- Navigation Header -->
    <header class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <span><img src="../assets/images/logo.png" alt="HomEase Logo" /></span>
            </div>
            <nav class="nav-menu">
                <a href="../index.php" class="nav-link">Home</a>
                <a href="services.php" class="nav-link">Services</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="#" class="nav-link active">Blog</a>
            </nav>
            <div class="navbar-right">
                <!-- Both buttons for toggle -->
                <a href="login.php" class="cta-btn btn-login">Login</a>
                <a href="#" class="btn-logout" style="display:none;">Logout</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="display-hero" style="background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('../assets/images/blog.jpg') no-repeat center center/cover;">
        <div class="display-hero-content">
            <h1 class="display-heading">Services</h1>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!--  -->
    <main class="blog-container" style="max-width: 1100px; margin: 48px auto; padding: 0 18px; font-family: 'Segoe UI', Arial, sans-serif;">
        <h1 style="color: #FF7700; font-weight: 700; margin-bottom: 32px;">Latest Blogs</h1>
        
        <article class="blog-post" style="background: #fff; border-radius: 14px; box-shadow: 0 8px 30px rgba(255, 119, 0, 0.1); padding: 22px 28px; margin-bottom: 36px;">
            <h2 style="color: #222042; margin-bottom: 14px;">How to Choose the Right Home Service Professional</h2>
            <p style="color: #444; font-size: 1.1rem; line-height: 1.6; margin-bottom: 20px;">
            Finding a trusted professional for your home repair or maintenance can be daunting. This guide helps you identify quality, reliability, and fair pricing.
            </p>
            <a href="https://www.hdfcergo.com/blogs/home-insurance/regular-home-maintenance" style="color: #FF7700; font-weight: 600; text-decoration: none;">Read More &rarr;</a>
        </article>

        <article class="blog-post" style="background: #fff; border-radius: 14px; box-shadow: 0 8px 30px rgba(255, 119, 0, 0.1); padding: 22px 28px; margin-bottom: 36px;">
            <h2 style="color: #222042; margin-bottom: 14px;">Benefits of Regular Home Maintenance</h2>
            <p style="color: #444; font-size: 1.1rem; line-height: 1.6; margin-bottom: 20px;">
            Regular maintenance extends the life of your home's essential systems and reduces costly emergency repairs. Learn the must-do tasks.
            </p>
            <a href="https://www.hdfcergo.com/blogs/home-insurance/regular-home-maintenance" style="color: #FF7700; font-weight: 600; text-decoration: none;">Read More &rarr;</a>
        </article>

        <article class="blog-post" style="background: #fff; border-radius: 14px; box-shadow: 0 8px 30px rgba(255, 119, 0, 0.1); padding: 22px 28px;">
            <h2 style="color: #222042; margin-bottom: 14px;">Top Trends in Home Service Technology for 2025</h2>
            <p style="color: #444; font-size: 1.1rem; line-height: 1.6; margin-bottom: 20px;">
            Discover the latest innovations improving home repairs, bookings, and customer satisfaction in the home services industry.
            </p>
            <a href="https://www.hdfcergo.com/blogs/home-insurance/regular-home-maintenance" style="color: #FF7700; font-weight: 600; text-decoration: none;">Read More &rarr;</a>
        </article>
    </main>

        <!-- FAQ Section -->
    <section class="faq-container" style="max-width:900px; margin:40px auto;">
        <h2 style="font-size:2rem; color:#27231c; margin-bottom:32px;">Frequently Asked Questions</h2>
        
        <div class="faq-accordion">
            <div class="faq-item active">
            <button class="faq-question" aria-expanded="true">What services does HomEase provide?</button>
            <div class="faq-answer">
                <p>HomEase offers a range of home services including plumbing, electrical works, cleaning, carpentry, painting, AC servicing, appliance repair, pest control, and more—all vetted for safety and quality.</p>
            </div>
            </div>

            <div class="faq-item">
            <button class="faq-question" aria-expanded="false">When should I book a professional from HomEase?</button>
            <div class="faq-answer">
                <p>You should book when you notice a maintenance issue or want to schedule preventive care, cleaning, or upgrades. Immediate booking is available for urgent repairs.</p>
            </div>
            </div>

            <div class="faq-item">
            <button class="faq-question" aria-expanded="false">How do I know a professional is trustworthy?</button>
            <div class="faq-answer">
                <p>All HomEase professionals are background-verified and customer-rated. You can view ratings, reviews, and service history before booking.</p>
            </div>
            </div>

            <div class="faq-item">
            <button class="faq-question" aria-expanded="false">Is HomEase affordable?</button>
            <div class="faq-answer">
                <p>Yes, all services are transparently priced. You get upfront estimates, and only pay for completed work, with no hidden charges.</p>
            </div>
            </div>
        </div>
    </section>
      

        <!-- Minimal JS for toggling (add before </body>): -->
        <script>
        document.querySelectorAll('.faq-question').forEach(function(btn){
        btn.onclick = function() {
            document.querySelectorAll('.faq-item').forEach(function(item){
            if(item.contains(btn)) {
                item.classList.toggle('active');
                btn.setAttribute('aria-expanded', item.classList.contains('active'));
            } else {
                item.classList.remove('active');
                item.querySelector('.faq-question').setAttribute('aria-expanded', 'false');
            }
            });
        };
        });
        </script>


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <img src="../assets/images/logo_white.png" alt="HomEase Logo White" />
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
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">FAQs</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>For Professionals</h4>
                    <ul>
                        <li><a href="pro_login.php">Login as Professional</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://www.twitter.com/" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://www.instagram.com/" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
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

    <!-- Cookie-based Login/Logout toggle -->
    <script>
        function getCookie(name) {
            const m = document.cookie.match(new RegExp('(?:^|; )'+ name + '=([^;]*)'));
            return m ? decodeURIComponent(m[1]) : null;
        }
        function setCookie(name, value, seconds) {
            const max = seconds ? ';max-age=' + seconds : '';
            document.cookie = name + '=' + value + ';path=/' + max;
        }
        function deleteCookie(name) {
            document.cookie = name + '=;path=/;max-age=0';
        }
        function refreshAuthUI() {
            const authed = getCookie('logged_in') === '1';
            document.querySelectorAll('.btn-login, .cta-btn.btn-login')
                .forEach(el => el.style.display = authed ? 'none' : 'inline-flex');
            document.querySelectorAll('.btn-logout')
                .forEach(el => el.style.display = authed ? 'inline-flex' : 'none');
        }
        document.addEventListener('DOMContentLoaded', refreshAuthUI);
        document.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-logout');
            if (!btn) return;
            e.preventDefault();
            deleteCookie('logged_in');
            refreshAuthUI();
        });
    </script>

</body>
</html>
