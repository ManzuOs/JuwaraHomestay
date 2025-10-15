<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "juwarahomestay1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $guests = $_POST['guests'];
  $check_in = $_POST['check_in'];
  $check_out = $_POST['check_out'];
  $total_price = $_POST['total_price'];

  $target_dir = "uploads/";
  if (!is_dir($target_dir)) {
      mkdir($target_dir);
  }
  $receipt = time() . "_" . basename($_FILES["receipt"]["name"]);
  $target_file = $target_dir . $receipt;
  move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file);

  $stmt1 = $conn->prepare("INSERT INTO bookings (fullname, email, phone, guests, check_in, check_out, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt1->bind_param("sssissd", $fullname, $email, $phone, $guests, $check_in, $check_out, $total_price);

  $stmt2 = $conn->prepare("INSERT INTO payments (fullname, email, phone, amount, receipt) VALUES (?, ?, ?, ?, ?)");
  $stmt2->bind_param("sssds", $fullname, $email, $phone, $total_price, $receipt);

  if ($stmt1->execute() && $stmt2->execute()) {
      echo "<script>alert('✅ Booking and payment submitted successfully!'); window.location='index.php';</script>";
  } else {
      echo "<script>alert('❌ Error: Unable to save booking/payment.');</script>";
  }

  $stmt1->close();
  $stmt2->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JUWARA HOMESTAY - Booking & Payment</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/payment.css">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
</head>
<body>

  <!-- ===== Mobile Navbar ===== -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary d-lg-none">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">JUWARA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mobileNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">🏠 Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="payment.php">💳 Payment</a></li>
          <li class="nav-item"><a class="nav-link" href="gallery.php">🖼️ Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">🔐 Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ===== Sidebar (Desktop) ===== -->
  <div class="sidebar d-none d-lg-flex flex-column justify-content-between">
    <div>
      <h3 class="text-center text-white fw-bold mt-3">JUWARA</h3>
      <a href="index.php">🏠 Home</a>
      <a href="payment.php" class="active">💳 Payment</a>
      <a href="gallery.php">🖼️ Gallery</a>
      <a href="login.php">🔐 Login</a>
    </div>
    <p class="text-center text-white-50 small mb-3">&copy; 2025 JUWARA HOMESTAY</p>
  </div>

  <!-- ===== Main Content ===== -->
  <div class="content">
    <div class="hero-section text-center text-white bg-primary bg-opacity-75 p-4 rounded mb-4">
      <h2>🏡 Book & Pay for Your Stay</h2>
    </div>

    <div class="card shadow-lg p-4 mb-5 bg-white bg-opacity-90">
      <!-- ✅ FORM UNCHANGED -->
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" placeholder="Enter your full name" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="e.g. 0123456789" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Number of Guests</label>
            <input type="number" name="guests" class="form-control" min="1" max="20" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Check-In Date</label>
            <input type="date" name="check_in" id="checkIn" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Check-Out Date</label>
            <input type="date" name="check_out" id="checkOut" class="form-control" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Total Price (RM)</label>
          <input type="number" name="total_price" id="totalPrice" class="form-control" readonly required>
          <small class="text-muted">* RM750 per night</small>
        </div>

        <div class="text-center my-4">
          <p class="fw-semibold">📱 Scan QR to Pay</p>
          <img src="images/juwara_qr.png" alt="QR Code" class="rounded shadow" width="200">
        </div>

        <div class="mb-3">
          <label class="form-label">Upload Payment Receipt</label>
          <input type="file" name="receipt" class="form-control" accept=".jpg,.jpeg,.png,.pdf" required>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-success px-4">✅ Submit Booking & Payment</button>
        </div>
      </form>
    </div>

    <div class="card shadow-lg p-4 bg-white bg-opacity-90">
      <h2 class="fw-bold text-success text-center mb-4">📅 Booking Calendar</h2>
      <div id="calendar"></div>
    </div>

    <footer>
      <p class="mb-0">&copy; 2025 JUWARA HOMESTAY. All Rights Reserved.</p>
    </footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: 'fetch_bookings.php',
      eventColor: '#198754',
      eventTextColor: '#fff',
      height: 'auto'
    });
    calendar.render();

    const checkIn = document.getElementById('checkIn');
    const checkOut = document.getElementById('checkOut');
    const totalPrice = document.getElementById('totalPrice');
    function calculatePrice() {
      const inDate = new Date(checkIn.value);
      const outDate = new Date(checkOut.value);
      const diffTime = outDate - inDate;
      const days = diffTime / (1000 * 60 * 60 * 24);
      if (days > 0) totalPrice.value = days * 750;
      else totalPrice.value = "";
    }
    checkIn.addEventListener('change', calculatePrice);
    checkOut.addEventListener('change', calculatePrice);
  });
  </script>
</body>
</html>
