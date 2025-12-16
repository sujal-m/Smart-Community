<?php
session_start();
$isUserLoggedIn = isset($_SESSION['user_id']);
$isProLoggedIn  = isset($_SESSION['pro_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Service Details - HomEase</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body { background:#faf9f6; font-family:"Poppins",sans-serif; color:#333; }
    .login-warning {
      text-align:center; background:#fff5e5; border:1px solid #ffb84d;
      color:#b35b00; padding:20px; border-radius:10px; max-width:600px;
      margin:60px auto; font-size:1.1rem; font-weight:500;
    }
    .service-detail-main {
      display:flex; flex-wrap:wrap; align-items:start; justify-content:center;
      gap:40px; margin:50px auto; max-width:1200px;
    }
    .slider-img-list img {
      width:400px; height:300px; border-radius:15px; object-fit:cover;
      display:none;
    }
    .slider-img-list img.active { display:block; }
    .service-info-section { max-width:500px; }
    .service-title { font-size:2rem; font-weight:600; margin-bottom:10px; }
    .service-cost { font-size:1.4rem; font-weight:600; color:#ff6600; margin-top:10px; }
    .cta-btn {
      background:#ff6600; color:#fff; border:none; padding:10px 18px;
      border-radius:8px; font-weight:500; cursor:pointer; transition:0.2s;
    }
    .cta-btn:hover { background:#e25500; }

    /* Modal */
    .modal-backdrop {
      position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.6);
      display:none; align-items:center; justify-content:center; z-index:9999;
    }
    .modal-popup {
      background:#fff; border-radius:15px; padding:25px 35px; max-width:480px; width:90%;
    }
    .confirm-message {
      text-align:center; background:#e8ffe8; border:1px solid #a4d3a4;
      color:#256c25; padding:15px; border-radius:8px;
      margin:20px auto; max-width:600px; display:none;
    }
  </style>
</head>
<body>

<header class="navbar">
  <div class="navbar-content">
    <div class="logo"><img src="../assets/images/logo.png" alt="HomEase logo"></div>
    <nav class="nav-menu">
      <a href="../index.php" class="nav-link">Home</a>
      <a href="services.php" class="nav-link active">Services</a>
      <a href="contact.php" class="nav-link">Contact</a>
      <a href="blog.php" class="nav-link">Blog</a>
    </nav>
    <div class="navbar-right">
      <?php if ($isUserLoggedIn): ?>
        <a href="user_dashboard.php" class="cta-btn">Dashboard</a>
        <a href="logout.php" class="cta-btn" style="margin-left:10px;">Logout</a>
      <?php elseif ($isProLoggedIn): ?>
        <a href="pro_dashboard.php" class="cta-btn">Pro Dashboard</a>
        <a href="logout.php" class="cta-btn" style="margin-left:10px;">Logout</a>
      <?php else: ?>
        <a href="login.php" class="cta-btn">Login</a>
      <?php endif; ?>
    </div>
  </div>
</header>

<main>
  <div id="confirmMsg" class="confirm-message">✅ Booking confirmed! Redirecting to your dashboard...</div>
  <div id="serviceContent"></div>

  <?php if ($isUserLoggedIn): ?>
  <div class="modal-backdrop" id="bookModalBackdrop">
    <div class="modal-popup" id="bookModal">
      <h2>Book Your Service</h2>
      <form id="bookingForm">
        <div class="form-group">
          <label>Service</label>
          <input type="text" id="serviceType" readonly>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Date</label>
            <input type="date" id="date" required>
          </div>
          <div class="form-group">
            <label>Time</label>
            <input type="time" id="time" required>
          </div>
        </div>
        <div class="form-group">
          <label>Address</label>
          <textarea id="address" rows="2" required placeholder="Flat/Building, Area, City"></textarea>
        </div>
        <div class="form-group">
          <label>Phone</label>
          <input type="tel" id="phone" required pattern="[0-9]{10}">
        </div>
        <div class="form-group">
          <label>Cost</label>
          <input type="number" id="cost" readonly>
        </div>
        <div style="display:flex;gap:10px;margin-top:15px;">
          <button type="submit" class="cta-btn" style="flex:1;">Confirm Booking</button>
          <button type="button" id="cancelBookModal" class="cta-btn" style="background:#999;">Cancel</button>
        </div>
      </form>
    </div>
  </div>
  <?php elseif ($isProLoggedIn): ?>
    <div class="login-warning">🧰 Professionals cannot book services. Please use your dashboard.</div>
  <?php else: ?>
    <div class="login-warning">
      ⚠️ Please log in as a user to book services.<br>
      <a href="login.php" class="cta-btn" style="margin-top:10px;display:inline-block;">Login</a>
    </div>
  <?php endif; ?>
</main>

<footer class="footer">
  <div class="footer-bottom">
    <p>&copy; 2025 HomEase. All rights reserved.</p>
  </div>
</footer>

<script>
const serviceDetails = {
  plumbing:{title:"Plumbing Services",desc:"Tap leaks, pipe repairs, fittings installations.",img:["../assets/images/1-5.jpg"],cost:199,features:["Leak fixing","Pipe installation","Drain cleaning","Faucet replacement"]},
  electrical:{title:"Electrical",desc:"Switches, wiring, lighting, sockets — fast & safe.",img:["../assets/images/electrical1.jpg"],cost:149,features:["Wiring","Lighting","Switches","Fan installation"]},
  carpentry:{title:"Carpentry",desc:"Furniture repair, fittings, custom shelving.",img:["../assets/images/Carpenter2.jpg"],cost:249,features:["Furniture repair","Door fitting","Shelf making","Wood polishing"]},
  painting:{title:"Painting",desc:"Wall, ceiling, and wood painting with clean finish.",img:["../assets/images/painting2.jpg"],cost:299,features:["Interior painting","Exterior painting","Ceiling touch-up"]},
  flooring:{title:"Flooring",desc:"Quality flooring solutions for any room.",img:["../assets/images/flooring2.jpg"],cost:399,features:["Tile installation","Wood flooring","Marble polishing"]},
  renovation:{title:"Home Renovation",desc:"Complete renovation solutions for your home.",img:["../assets/images/renovation2.jpg"],cost:599,features:["Kitchen remodel","Bathroom upgrade","Wall work"]},
  salon:{title:"Beauty & Salon",desc:"Haircuts, facials, waxing, spa, manicure/pedicure.",img:["../assets/images/salon2.jpg"],cost:249,features:["Hair styling","Facial","Manicure","Spa"]},
  moving:{title:"Moving & Packing",desc:"House or office shifting services.",img:["../assets/images/moving2.jpg"],cost:499,features:["Packing","Transport","Unpacking"]},
  pest:{title:"Pest Control",desc:"Anti-termite, cockroach, bed bug treatments.",img:["../assets/images/pest2.jpg"],cost:299,features:["Termite control","Bedbug treatment","Cockroach removal"]},
  vehicle:{title:"Vehicle Cleaning",desc:"Car, bike, or any vehicle cleaning services.",img:["../assets/images/vehicle1.jpg"],cost:199,features:["Exterior wash","Interior vacuum","Polish"]}
};

// Display service dynamically
document.addEventListener('DOMContentLoaded',()=>{
  const params=new URLSearchParams(window.location.search);
  const key=params.get('service');
  const content=document.getElementById('serviceContent');
  if(key && serviceDetails[key]){
    const s=serviceDetails[key];
    content.innerHTML=`
      <div class="service-detail-main">
        <div class="slider-img-list">${s.img.map((i,j)=>`<img src="${i}" class="${j==0?'active':''}">`).join('')}</div>
        <div class="service-info-section">
          <div class="service-title">${s.title}</div>
          <p>${s.desc}</p>
          <ul>${s.features.map(f=>`<li>${f}</li>`).join('')}</ul>
          <div class="service-cost">₹${s.cost}</div>
          <?php if($isUserLoggedIn): ?><button id="openBookNow" class="cta-btn" style="margin-top:15px;">Book Now</button><?php endif; ?>
        </div>
      </div>`;
    if(<?php echo $isUserLoggedIn?'true':'false'; ?>){
      document.getElementById('openBookNow').addEventListener('click',()=>{
        document.getElementById('bookModalBackdrop').style.display='flex';
        document.getElementById('serviceType').value=s.title;
        document.getElementById('cost').value=s.cost;
      });
    }
  }else{
    content.innerHTML=`<p style="text-align:center;margin:60px;font-size:1.2rem;">Service not found.</p>`;
  }
  document.getElementById('cancelBookModal')?.addEventListener('click',()=>document.getElementById('bookModalBackdrop').style.display='none');
});

// Booking
<?php if($isUserLoggedIn): ?>
document.addEventListener('DOMContentLoaded',()=>{
  document.getElementById('bookingForm').addEventListener('submit',async e=>{
    e.preventDefault();
    const s=document.getElementById('serviceType').value;
    const d=document.getElementById('date').value;
    const t=document.getElementById('time').value;
    const a=document.getElementById('address').value;
    const p=document.getElementById('phone').value;
    const c=document.getElementById('cost').value;
    const dt=`${d} ${t}:00`;
    try{
      const res=await fetch('create_order.php',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({service:s,booking_datetime:dt,address:a,phone:p,cost:c})});
      const data=await res.json();
      if(data.success){
        document.getElementById('bookModalBackdrop').style.display='none';
        const msg=document.getElementById('confirmMsg');
        msg.style.display='block';
        setTimeout(()=>window.location.href='user_dashboard.php',2500);
      }else alert("⚠️ "+data.message);
    }catch(err){alert("❌ Error booking.");console.error(err);}
  });
});
<?php endif; ?>
</script>
</body>
</html>
