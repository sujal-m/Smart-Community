<?php
session_start();

// helper: build link based on login state
function book_link_for($service) {
    // if user logged in -> go to service_detail
    if (isset($_SESSION['user_id'])) {
        return "service_detail.php?service=" . urlencode($service);
    }

    // not logged in -> go to login with redirect back to service_detail
    $target = "service_detail.php?service=" . urlencode($service);
    return "login.php?redirect=" . urlencode($target);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Our Services - HomEase</title>
    <link rel="stylesheet" href="../assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body style="background: #F6F5ED;">

    <!-- Navigation Header -->
    <header class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <span><img src="../assets/images/logo.png" alt="HomEase logo" /></span>
            </div>
            <nav class="nav-menu">
                <a href="../index.php" class="nav-link">Home</a>
                <a href="#" class="nav-link active">Services</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="blog.php" class="nav-link">Blog</a>
            </nav>
            <div class="navbar-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="user_dashboard.php" class="cta-btn">Dashboard</a>
                    <a href="logout.php" class="btn-logout" style="margin-left:8px;">Logout</a>
                <?php elseif (isset($_SESSION['pro_id'])): ?>
                    <a href="pro_dashboard.php" class="cta-btn">Pro Dashboard</a>
                    <a href="logout.php" class="btn-logout" style="margin-left:8px;">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="cta-btn btn-login">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="display-hero" style="background: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url('../assets/images/services.jpg') no-repeat center center/cover;">
        <div class="display-hero-content">
            <h1 class="display-heading">Services</h1>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <h3 class="light-text" style="margin-top: 40px;">Our Services</h3>

    <!-- Services Details -->
    <section class="services-details">
        <?php
        // list of services (title, image, key, description, icon)
        $services = [
            ['key'=>'plumbing','title'=>'Plumbing Services','img'=>'../assets/images/1-5.jpg','desc'=>'Tap leaks, pipe repairs, new fittings installations','icon'=>'fa-plug'],
            ['key'=>'electrical','title'=>'Electrical','img'=>'../assets/images/electrical1.jpg','desc'=>'Switches, wiring, lighting, sockets -- fast & safe.','icon'=>'fa-bolt'],
            ['key'=>'carpentry','title'=>'Carpentry','img'=>'../assets/images/Carpenter2.jpg','desc'=>'Furniture repair, fittings, custom shelving and more.','icon'=>'fa-hammer'],
            ['key'=>'painting','title'=>'Painting','img'=>'../assets/images/painting2.jpg','desc'=>'Wall, ceiling, and wood painting with clean finish.','icon'=>'fa-paintbrush'],
            ['key'=>'flooring','title'=>'Flooring','img'=>'../assets/images/flooring2.jpg','desc'=>'Quality flooring solutions for any room.','icon'=>'fa-shoe-prints'],
            ['key'=>'renovation','title'=>'Home Renovation','img'=>'../assets/images/renovation2.jpg','desc'=>'Quality renovation services for any room.','icon'=>'fa-wrench'],
            ['key'=>'salon','title'=>'Beauty & Salon','img'=>'../assets/images/salon2.jpg','desc'=>'Haircuts, facials, waxing, spa, manicure/pedicure.','icon'=>'fa-scissors'],
            ['key'=>'moving','title'=>'Moving & Packing','img'=>'../assets/images/moving2.jpg','desc'=>'House or office shifting services.','icon'=>'fa-truck'],
            ['key'=>'pest','title'=>'Pest Control','img'=>'../assets/images/pest2.jpg','desc'=>'Anti-termite, cockroach, bed bug, mosquito, or rodent treatments.','icon'=>'fa-bug'],
            ['key'=>'vehicle','title'=>'Vehicle Cleaning','img'=>'../assets/images/vehicle1.jpg','desc'=>'Car, bike, or any vehicle cleaning services.','icon'=>'fa-car'],
        ];

        foreach ($services as $s):
            $link = book_link_for($s['key']);
        ?>
            <div class="service-detail-card">
                <div class="service-detail-img"><img src="<?php echo $s['img']; ?>" alt="<?php echo htmlentities($s['title']); ?>"></div>
                <div class="service-detail-content">
                    <h2><?php echo htmlentities($s['title']); ?></h2>
                    <p><?php echo htmlentities($s['desc']); ?></p>
                    <a href="<?php echo $link; ?>" class="btn btn-secondary">Book Now</a>
                    <div class="service-detail-icon"><i class="fa-solid <?php echo $s['icon']; ?>"></i></div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <img src="../assets/images/logo_white.png" alt="HomEase logo white" />
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
                        <li><a href="../index.php?#about">About Us</a></li>
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
</body>
</html>
