<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "homease_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id']) && isset($_POST['delete_type'])) {
    $id = intval($_POST['delete_id']);
    $type = $_POST['delete_type'];
    $table = ($type === 'user') ? 'users' : 'professionals';
    $idcol = 'id';
    $sql = "DELETE FROM $table WHERE $idcol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    // (Optional) redirect or show a success message
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login / Register - HomEase</title>
<link rel="stylesheet" href="../assets/css/style.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />


<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #F6F5ED;
    margin: 0;
    padding: 0;
  }
  section.admin-panel {
    max-width: 1150px;
    margin: 38px auto 70px auto;
    padding: 0 18px;
  }
  section.admin-panel h1 {
    color: #FF7700;
    font-weight: 700;
    margin-bottom: 28px;
  }
  section.admin-panel h2 {
    margin-top: 36px;
    margin-bottom: 14px;
    border-bottom: 2px solid #FF7700;
    padding-bottom: 6px;
    font-weight: 600;
    color: #312d3e;
  }
  .user-list, .pro-list, .bookings {
    display: flex;
    flex-direction: column;
    gap: 18px;
    background: #fff;
    padding: 14px 22px;

  }
  .user-card,.booking-card {
    padding: 4px 22px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 14px;
    font-size: 1rem;
    color: #222;
  }
  .pro-card{
    padding: 4px 12px;
    display: flex;
    flex-wrap: wrap;
    align-items: center;

    font-size: 1rem;
    color: #222;
  }
  .user-card span, .pro-card span, .booking-card span {
    flex: 1 1 180px;
  }
  .btn-secondary {
    background-color: #eee8fe;
    border: none;
    color: #623efd;
    padding: 8px 18px;
    font-weight: 600;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.22s;
  }
  .btn-secondary:hover {
    background-color: #5234d4;
    color: #fff;
  }
  .btn-delete {
    background-color: #FF7700;
    color: white;
    padding: 10px 20px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    margin-top: 18px;
  }
  .btn-delete:hover {
    background-color: #e6650d;
  }
  footer {
    background-color: #222042;
    color: #ccc;
    text-align: center;
    padding: 14px 0;
  }
  @media (max-width: 700px) {
    .user-card, .pro-card, .booking-card {
      flex-direction: column;
      align-items: flex-start;
      font-size: 0.95rem;
    }
  }
</style>
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <div class="navbar-content">
            <div class="logo">
                <span><img src="../assets/images/logo.png" alt=""></span>
            </div>
            <nav class="nav-menu">
                <a href="../index.html" class="nav-link">Home</a>
                <a href="admin.html" class="nav-link active">Admin</a>
            </nav>
        </div>
    </header>

<section class="admin-panel">
  <h1>Admin Management</h1>

  <h2>All Users</h2>
  <div class="user-list" id="userList">
      <?php
      $sql = "SELECT id, full_name, email, phone FROM users ORDER BY created_at DESC";
      $result = $conn->query($sql);
      if ($result && $result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              echo '<div class="user-card">';
              echo '<span>Name: ' . htmlspecialchars($row['full_name']) . '</span>';
              echo '<span>Email: ' . htmlspecialchars($row['email']) . '</span>';
              echo '<span>Phone: ' . htmlspecialchars($row['phone']) . '</span>';
              echo '<form method="post" style="display:inline;">
                <input type="hidden" name="delete_id" value="' . intval($row['id']) . '">
                <input type="hidden" name="delete_type" value="user">
                <button type="submit" class="btn-delete" onclick="return confirm(\'Delete this user?\');">Delete</button>
            </form>';
              echo '</div>';
          }
      } else {
          echo '<div class="user-card">No user records found.</div>';
      }
      ?>
  </div>

  <h2>All Professionals</h2>
  <div class="pro-list" id="proList">
    <?php
    $sql = "SELECT id,full_name, email, service, locality, phone FROM professionals ORDER BY created_at DESC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="pro-card">';
            echo '<span>' . htmlspecialchars($row['full_name']) . '</span>';
            echo '<span>' . htmlspecialchars($row['email']) . '</span>';
            echo '<span>' . htmlspecialchars($row['service']) . '</span>';
            echo '<span>' . htmlspecialchars($row['locality']) . '</span>';
            echo '<span>' . htmlspecialchars($row['phone']) . '</span>';
            echo '<form method="post" style="display:inline;">
                    <input type="hidden" name="delete_id" value="' . intval($row['id']) . '">
                    <input type="hidden" name="delete_type" value="pro">
                    <button type="submit" class="btn-delete" onclick="return confirm(\'Delete this professional?\');">Delete</button>
                </form>';
            echo '</div>';
        }
    } else {
        echo '<div class="pro-card">No professional records found.</div>';
    }
    ?>
  </div>

  <h2>All Bookings</h2>
  <div class="bookings" id="bookingList">
    <?php 
$sql = "SELECT o.id, u.full_name AS user_name, o.service_date, o.status, o.total_amount 
    FROM orders o 
    JOIN users u ON o.user_id = u.id 
    ORDER BY o.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<div class="bookings" id="bookingList">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="booking-card">';
        echo '<span> ' . htmlspecialchars($row['user_name']) . '</span><br>';
        echo '<span>' . htmlspecialchars($row['service_date']) . '</span><br>';
        echo '<span>Status: ' . htmlspecialchars($row['status']) . '</span><br>';
        echo '<span>Total: ₹' . htmlspecialchars($row['total_amount']) . '</span>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo "<p>No bookings found.</p>";
}

// Close connection at the end
$conn->close();
?>
  </div>

</section>

    <div class="cursor-dot"></div>
    <div class="cursor-outline"></div>
    <script src="../script.js"></script>
    <script>
        function approvePro(button) {
            const card = button.closest(".pro-card");
            card.querySelector("span:nth-child(3)").textContent = "Status: Approved";
            alert("Professional approved");
        }

        function rejectPro(button) {
            const card = button.closest(".pro-card");
            card.querySelector("span:nth-child(3)").textContent = "Status: Rejected";
            alert("Professional rejected");
        }

        function addNewService() {
            alert("Add new service feature coming soon!");
        }
    </script>

</body>
</html>

