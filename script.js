// Service Details Data
const serviceDetails = {
    plumbing: {
        title: 'Plumbing Services',
        description: 'Our expert plumbers handle everything from minor repairs to complete system installations.',
        images: ['../assets/images/plumber1.jpg', '../assets/images/plumber2.jpg', '../assets/images/plumber3.jpg'],
        cost: 199,
        features: [
            'Leak detection and repair',
            'Pipe installation and replacement',
            'Faucet and fixture installation',
            'Drain cleaning and maintenance',
            'Water heater services',
            'Emergency plumbing repairs'
        ]
    },
    electrical: {
        title: 'Electrical Services',
        description: 'Professional electrical work performed by certified technicians.',
        images: ['../assets/images/electrical1.jpg', '../assets/images/electrical2.jpg', '../assets/images/electrical3.jpg'],
        cost: 99,
        features: [
            'Outlet and switch installation',
            'Lighting installation and repair',
            'Circuit breaker repairs',
            'Electrical safety inspections',
            'Wiring and rewiring projects',
            'Generator installation'
        ]
    },
    carpentry: {
        title: 'Carpentry Services',
        description: 'Expert carpentry for all your woodworking needs.',
        images: ['../assets/images/Carpenter1.jpg', '../assets/images/Carpenter2.jpg', '../assets/images/Carpenter3.jpg'],
        cost: 299,
        features: [
            'Custom furniture building',
            'Shelving and storage solutions',
            'Door and frame installation',
            'Deck and patio construction',
            'Trim and molding work',
            'Cabinet refinishing'
        ]
    },
    painting: {
        title: 'Painting Services',
        description: 'Professional painting services for interior and exterior projects.',
        images: ['../assets/images/painting1.jpg', '../assets/images/painting2.jpg', '../assets/images/painting3.jpg'],
        cost: 149,
        features: [
            'Interior wall painting',
            'Exterior house painting',
            'Cabinet refinishing',
            'Accent wall design',
            'Pressure washing',
            'Stain and varnish work'
        ]
    },
    flooring: {
        title: 'Flooring Services',
        description: 'Quality flooring solutions for any room.',
        images: ['../assets/images/flooring1.jpg', '../assets/images/flooring2.jpg', '../assets/images/flooring3.jpg'],
        cost: 199,
        features: [
            'Hardwood flooring installation',
            'Laminate and vinyl flooring',
            'Tile installation',
            'Floor refinishing',
            'Carpet installation',
            'Subfloor repair'
        ]
    },
    renovation: {
        title: 'Home Renovation',
        description: 'Complete home renovation services to transform your space.',
        images: ['../assets/images/renovation1.jpg', '../assets/images/renovation2.jpg', '../assets/images/renovation3.jpg'],
        cost: 299,
        features: [
            'Kitchen remodeling',
            'Bathroom renovation',
            'Room additions',
            'Basement finishing',
            'Full home makeovers',
            'Custom design consultation'
        ]
    },
    salon: {
        title: 'Salon Services',
        description: 'Professional salon services for all your beauty needs.',
        images: ['../assets/images/salon1.jpg', '../assets/images/salon2.jpg', '../assets/images/salon3.jpg'],
        cost: 99,
        features: [
            'Haircuts and styling',
            'Hair coloring and highlights',
            'Hair treatments',
            'Makeup services',
            'Nail care',
            'Facial and skincare'
        ]
    },
    moving: {
        title: 'Moving Services',
        description: 'Professional moving services to relocate your belongings.',
        images: ['../assets/images/moving1.jpg', '../assets/images/moving2.jpg', '../assets/images/moving3.jpg'],
        cost: 199,
        features: [
            'Local and long-distance moves',
            'Packing and unpacking services',
            'Furniture disassembly and reassembly',
            'Loading and unloading',
            'Moving coordination',
            'Storage solutions'
        ]
    },
    pest: {
        title: 'Pest Control',
        description: 'Effective pest control solutions to keep your home safe.',
        images: ['../assets/images/pest1.jpg', '../assets/images/pest2.jpg', '../assets/images/pest3.jpg'],
        cost: 99,
        features: [
            'Rodent control',
            'Insect extermination',
            'Termite treatment',
            'Wasp and bee removal',
            'Flea and tick control',
            'Integrated pest management'
        ]
    },
    vehicle: {
        title: 'Vehicle cleaning',
        description: 'Professional vehicle cleaning services to keep your car looking its best.',
        images: ['../assets/images/vehicle1.jpg', '../assets/images/vehicle2.jpg', '../assets/images/vehicle3.jpg'],
        cost: 199,
        features: [
            'Interior and exterior cleaning',
            'Waxing and polishing',
            'Engine degreasing',
            'Tire and wheel cleaning',
            'Interior upholstery cleaning',
            'Window and glass cleaning'
        ]
    }
};

// Load service details on service-detail.html
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const service = urlParams.get('service');

    if (service && serviceDetails[service]) {
        const details = serviceDetails[service];
        const contentDiv = document.getElementById('serviceContent');

        if (contentDiv) {
            contentDiv.innerHTML = `
            <div class="service-detail-main">
                <div class="service-detail-section">
                    <div class="slider-img-list" id="sliderImgs">
                        <img src="${details.images[0]}" alt="${details.title} 1" class="slider-img active">
                        <img src="${details.images[1]}" alt="${details.title} 2" class="slider-img">
                        <img src="${details.images[2]}" alt="${details.title} 3" class="slider-img">
                    </div>
                    <div class="slider-controls" id="sliderDots">
                        <span class="slider-control-dot active" data-index="0"></span>
                        <span class="slider-control-dot" data-index="1"></span>
                        <span class="slider-control-dot" data-index="2"></span>
                    </div>
                </div>
                <div class="service-info-section">
                    <div class="service-title">${details.title}</div>
                    <div class="service-meta-list">
                        <div class="service-meta">
                            <i class="fa-regular fa-calendar-check"></i> Availability: <span>Mon-Sat, 9am-8pm</span>
                        </div>
                        <div class="service-meta">
                            <i class="fa-solid fa-clock"></i> Timing: <span>On-Demand (30-60 mins arrival)</span>
                        </div>
                        <div class="service-meta">
                            <div class="description">${details.description}</div>
                        </div>
                    </div>
                    <div class="service-cost">₹${details.cost}</div>
                    <button id="openBookNow" class="cta-btn btn-secondary" style="max-width: 150px;" data-service="${service}" data-price="${details.cost}"><i class="fa-solid fa-plus"></i> Book Now</button>
                </div>
            </div>
            <div class="service-detail-below">
                <div class="provider-info">
                    <div class="provider-info-title">Service Provider</div>
                    <img src="https://randomuser.me/api/portraits/men/52.jpg" class="provider-img" alt="Provider Photo">
                    <div class="provider-meta"><b>Name:</b> Ramesh Sharma</div>
                    <div class="provider-meta"><b>Rating:</b> 4.82 <span style="color:#ffb700;"><i class="fa-solid fa-star"></i></span></div>
                    <div class="provider-meta"><b>Experience:</b> 9 years</div>
                    <div class="provider-meta"><b>Jobs Done:</b> 350+</div>
                </div>
                <div class="service-description">
                    <div class="service-desc-title">Features</div>
                    <ul>
                        ${details.features.map(f => `<li>${f}</li>`).join("")}
                    </ul>
                </div>
                <div class="service-reviews">
                    <div class="review-title">Reviews</div>
                    <div class="review">
                        <span class="review-user">Priya Mehta </span>
                        <span class="review-rating"><i class="fa-solid fa-star"></i> 5.0</span>
                        <div class="review-txt">Very punctual and neat work. Consultancy was free and charges were genuine.</div>
                    </div>
                    <div class="review">
                        <span class="review-user">Vinod P.</span>
                        <span class="review-rating"><i class="fa-solid fa-star"></i> 4.7</span>
                        <div class="review-txt">Quickly solved the plumbing issue. Highly recommended for urgent repairs!</div>
                    </div>
                </div>
            </div>
            `;
        }
    }

    // Slider logic for dynamic HTML
    setTimeout(function(){
        const imgs = document.querySelectorAll('#sliderImgs img');
        const dots = document.querySelectorAll('.slider-control-dot');
        dots.forEach(dot => {
            dot.addEventListener('click', () => {
                let idx = parseInt(dot.dataset.index);
                imgs.forEach((im, i) => im.classList.toggle('active', i === idx));
                dots.forEach((d, i) => d.classList.toggle('active', i === idx));
            });
        });
    }, 0);

        document.getElementById('openBookNow').onclick = function(){
        var serviceName = this.getAttribute('data-service');
        var servicePrice = this.getAttribute('data-price');
        document.getElementById('serviceType').value = serviceName;
        document.getElementById('cost').value = servicePrice;
        document.getElementById('cost').readOnly = true;
        document.getElementById('serviceType').readOnly = true;
        
        // Set current time (format HH:MM)
        var now = new Date();
        var h = String(now.getHours()).padStart(2,'0');
        var m = String(now.getMinutes()).padStart(2,'0');
        document.getElementById('time').value = h + ":" + m;
        // Current date
        var y = now.getFullYear();
        var mo = String(now.getMonth()+1).padStart(2,'0');
        var d = String(now.getDate()).padStart(2,'0');
        document.getElementById('date').value = `${y}-${mo}-${d}`;
        
        document.getElementById('bookModalBackdrop').style.display = "flex";
        document.body.style.overflow = "hidden";
        
        };

        document.getElementById('cancelBookModal').onclick = function(){
        document.getElementById('bookModalBackdrop').style.display = "none";
        document.body.style.overflow = "auto";
        document.getElementById('modalStepBook').style.display = "block";
        document.getElementById('modalStepCheckout').style.display = "none";
        document.getElementById('bookingForm').reset();
        };
        // // Checkout/payment mock
        // document.getElementById('paymentForm').onsubmit = function(e) {
        // e.preventDefault();
        // alert("Payment successful! Your booking is confirmed.");
        // document.getElementById('bookModalBackdrop').style.display = "none";
        // document.body.style.overflow = "auto";
        // };

        document.getElementById('bookingForm').onsubmit = function(event) {
  event.preventDefault();
  // Show checkout step inside popup or redirect accordingly
  document.getElementById('modalStepBook').style.display = "none";
  document.getElementById('modalStepCheckout').style.display = "block";

  // Fill summary box with the details
  const service = document.getElementById('serviceType').value;
  const date = document.getElementById('date').value;
  const time = document.getElementById('time').value;
  const address = document.getElementById('address').value;
  const name = document.getElementById('name').value;
  const phone = document.getElementById('phone').value;
  const cost = document.getElementById('cost').value;

  document.getElementById('summaryBox').innerHTML = `
    <div><b>Service:</b> ${service}</div>
    <div><b>Name:</b> ${name}</div>
    <div><b>Date:</b> ${date}</div>
    <div><b>Time:</b> ${time}</div>
    <div><b>Address:</b> ${address}</div>
    <div><b>Phone:</b> ${phone}</div>
    <div><b>Total Cost:</b> ₹${cost}</div>
  `;
};
    // Form submission handlers
    const loginForm = document.querySelector('#loginForm form');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLoginSubmit);
    }

    const registerForm = document.querySelector('#registerForm form');
    if (registerForm) {
        registerForm.addEventListener('submit', handleRegisterSubmit);
    }

    // CTA buttons
    const ctaButtons = document.querySelectorAll('.btn-primary');
    ctaButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.textContent.includes('Quote') || this.textContent.includes('Started') || this.textContent.includes('Touch') || this.textContent.includes('Service')) {
                e.preventDefault();
                alert('Thank you for your interest! Please fill out the form or contact us directly.');
            }
        });
    });

    // Service card links
    const serviceLinks = document.querySelectorAll('.service-link');
    serviceLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const href = this.getAttribute('href');
            window.location.href = href;
        });
    });
});

// Toggle between login and register forms
function toggleForms() {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginForm && registerForm) {
        loginForm.classList.toggle('hidden');
        registerForm.classList.toggle('hidden');
    }
}

// Handle login form submission
function handleLoginSubmit(e) {
    e.preventDefault();

    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;

    if (email && password) {
        console.log('[v0] Login attempt:', { email });
        alert('Login successful! Welcome back to HomEase.');
        // Here you would typically send data to a server
        e.target.reset();
    }
}

// Handle register form submission
function handleRegisterSubmit(e) {
    e.preventDefault();

    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const phone = document.getElementById('registerPhone').value;
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('registerConfirm').value;

    if (password !== confirmPassword) {
        alert('Passwords do not match!');
        return;
    }

    if (name && email && phone && password) {
        console.log('[v0] Registration attempt:', { name, email, phone });
        alert('Account created successfully! Welcome to HomEase.');
        // Here you would typically send data to a server
        e.target.reset();
    }
}

// Smooth scroll for navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// Add active class to current nav link
document.addEventListener('DOMContentLoaded', function() {
    const currentLocation = location.pathname;
    const menuItems = document.querySelectorAll('.nav-link');

    menuItems.forEach(item => {
        if (item.getAttribute('href') === currentLocation) {
            item.classList.add('active');
        }
    });
});

// Custom cursor effect
(function(){
  const dot = document.querySelector('.cursor-dot');
  const outline = document.querySelector('.cursor-outline');
  let mouseX = -100, mouseY = -100;
  let posX = 0, posY = 0;
  const speed = 0.18; // smoothness factor

  document.addEventListener('mousemove', e => {
    mouseX = e.clientX;
    mouseY = e.clientY;
  });

  function loop(){
    posX += (mouseX - posX) * speed;
    posY += (mouseY - posY) * speed;

    dot.style.transform = `translate(${posX}px, ${posY}px) translate(-50%, -50%)`;
    outline.style.transform = `translate(${posX}px, ${posY}px) translate(-50%, -50%)`;

    requestAnimationFrame(loop);
  }
  loop();

  // Ripple click animation
  document.addEventListener('click', e => {
    const ripple = document.createElement('div');
    ripple.classList.add('ripple');
    ripple.style.left = e.clientX + 'px';
    ripple.style.top = e.clientY + 'px';
    document.body.appendChild(ripple);
    setTimeout(() => ripple.remove(), 600);
  });

  // Hover enlarge effect
  const hoverElements = ['button', 'a', 'input', 'textarea'];
  document.addEventListener('mouseover', e => {
    if (hoverElements.some(sel => e.target.closest(sel))) {
      document.body.classList.add('cursor-hover');
    }
  });
  document.addEventListener('mouseout', e => {
    if (hoverElements.some(sel => e.target.closest(sel))) {
      document.body.classList.remove('cursor-hover');
    }
  });

  // Hide on touch
  if ('ontouchstart' in window) {
    dot.style.display = 'none';
    outline.style.display = 'none';
    document.body.style.cursor = 'auto';
  }
})();

const container = document.querySelector(".testimonial-container");
  const cards = document.querySelectorAll(".testimonial-card");
  const dots = document.querySelectorAll(".dot");

  let index = 0;
  const visibleCards = 3;
  const totalCards = cards.length;

  // Clone first few cards to make looping smooth
  for (let i = 0; i < visibleCards; i++) {
    const clone = cards[i].cloneNode(true);
    container.appendChild(clone);
  }

  function slideTestimonials() {
    index++;
    const cardWidth = cards[0].offsetWidth + 40; // include gap
    container.style.transition = "transform 0.8s ease-in-out";
    container.style.transform = `translateX(-${index * cardWidth}px)`;

    // Update dots
    dots.forEach(dot => dot.classList.remove("active-dot"));
    dots[index % dots.length].classList.add("active-dot");

    // Reset when end is reached
    if (index === totalCards) {
      setTimeout(() => {
        container.style.transition = "none";
        container.style.transform = "translateX(0)";
        index = 0;
      }, 850);
    }
  }

  setInterval(slideTestimonials, 3500);
