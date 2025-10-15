<?php
// user.php — User Dashboard
session_start();

if (!isset($_GET['role']) || $_GET['role'] !== 'user') {
  header("Location: login.php");
  exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "juwarahomestay1";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$user_name = $_SESSION['username'] ?? 'Guest';

// ✅ Toggle device status (AJAX request)
if (isset($_POST['toggle']) && isset($_POST['id'])) {
  $id = (int) $_POST['id'];
  $current = $_POST['toggle'] === 'On' ? 'Off' : 'On';
  $conn->query("UPDATE devices SET status='$current' WHERE id=$id");
  echo $current;
  exit;
}

// ✅ Fetch latest booking for this user
$booking_query = "
  SELECT check_in, check_out 
  FROM bookings 
  WHERE fullname = (
    SELECT username FROM users WHERE username = '$user_name' LIMIT 1
  )
  ORDER BY check_out DESC 
  LIMIT 1
";
$booking_result = $conn->query($booking_query);
$booking = $booking_result ? $booking_result->fetch_assoc() : null;

$remaining_message = "No active booking.";
if ($booking) {
  $now = new DateTime();
  $check_out = new DateTime($booking['check_out']);
  if ($check_out > $now) {
    $interval = $now->diff($check_out);
    $remaining_message = "⏰ " . $interval->d . " days, " . $interval->h . " hours, " . $interval->i . " minutes left before check-out.";
  } else {
    $remaining_message = "✅ You have already checked out.";
  }
}

// ✅ Fetch devices
$result = $conn->query("SELECT * FROM devices ORDER BY id ASC");
$devices = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JUWARA HOMESTAY - User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
    }

    .bg-blue {
      background: linear-gradient(90deg, #0d47a1, #1976d2, #42a5f5);
    }

    .text-white-custom {
      color: #fff !important;
    }

    .card-custom {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
    }

    .card-custom:hover {
      transform: scale(1.02);
    }

    .welcome-box {
      background: #1976d2;
      color: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
    }

    .countdown-box {
      border: 2px solid #1976d2;
      border-radius: 10px;
      padding: 15px;
      margin-top: 20px;
      background: #e3f2fd;
    }
  </style>
</head>

<body class="d-flex flex-column vh-100">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg bg-blue shadow">
    <div class="container">
      <a class="navbar-brand fw-bold text-white-custom" href="#">JUWARA HOMESTAY</a>
      <a href="login.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </nav>

  <div class="container my-5">
    <!-- Welcome Section -->
    <div class="welcome-box text-center">
      <h3>👋 Welcome, <?= htmlspecialchars($user_name) ?>!</h3>
      <p>Control your smart devices below.</p>
    </div>

    <!-- Remaining Time Box -->
    <div class="countdown-box text-center">
      <h5><?= $remaining_message ?></h5>
    </div>

    <!-- Device List -->
    <div class="row g-4 mt-4">
      <?php if (count($devices) === 0): ?>
        <p class="text-center text-muted">No devices found.</p>
      <?php else: ?>
        <?php foreach ($devices as $device): ?>
          <div class="col-md-6">
            <div class="card card-custom p-3 text-center">
              <h5><?= htmlspecialchars($device['name']) ?></h5>
              <p>Status: <span id="status<?= $device['id'] ?>" class="fw-bold"><?= htmlspecialchars($device['status']) ?></span></p>
              <button class="btn btn-primary toggle-btn" data-id="<?= $device['id'] ?>" data-status="<?= $device['status'] ?>">
                Turn <?= $device['status'] === 'On' ? 'Off' : 'On' ?>
              </button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>

  <footer class="bg-blue text-center text-white-custom py-3 mt-auto">
    <p class="mb-0">&copy; 2025 JUWARA HOMESTAY</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $(".toggle-btn").click(function () {
        const id = $(this).data("id");
        const currentStatus = $(this).data("status");
        const button = $(this);

        $.post("user.php?role=user", { id: id, toggle: currentStatus }, function (response) {
          $("#status" + id).text(response);
          button.text("Turn " + (response === "On" ? "Off" : "On"));
          button.data("status", response);
        });
      });
    });
  </script>

</body>
</html>
