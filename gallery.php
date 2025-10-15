<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "juwarahomestay1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$images = [
  "2.webp" => "Pool View",
  "3.webp" => "Kitchen",
  "4.webp" => "Front View",
  "5.webp" => "Bedroom",
  "6.webp" => "Wi-Fi",
  "7.webp" => "Washing Machine",
  "8.jpg" => "The Atmosphere By The Pool",
  "9.jpg" => "Dining Area",
  "11.jpg" => "Poolside Table"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JUWARA HOMESTAY - Gallery</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/gallery.css" rel="stylesheet">
</head>
<body>

  <!-- Mobile Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary d-lg-none">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">JUWARA</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mobileNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">🏠 Home</a></li>
          <li class="nav-item"><a class="nav-link" href="payment.php">💳 Payment</a></li>
          <li class="nav-item"><a class="nav-link active" href="gallery.php">🖼️ Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">🔐 Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Sidebar (Desktop) -->
  <div class="sidebar d-none d-lg-flex">
    <div>
      <h3>JUWARA</h3>
      <a href="index.php">🏠 Home</a>
      <a href="payment.php">💳 Payment</a>
      <a href="gallery.php" class="active">🖼️ Gallery</a>
      <a href="login.php">🔐 Login</a>
    </div>
    <p class="text-center small mb-0">&copy; 2025 JUWARA HOMESTAY</p>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="card shadow p-4 mb-4">
      <h3 class="fw-bold text-primary">JUWARA Homestay</h3>
      <p><strong>Location:</strong> Langgar, Alor Setar, Malaysia</p>
      <p><strong>Price per Night:</strong> RM 750</p>
      <p>JUWARA Homestay offers a comfortable and cozy stay with modern facilities including Wi-Fi, air-conditioning, swimming pool, and a fully equipped kitchen. Perfect for families and friends looking to relax and enjoy nature.</p>
    </div>

    <!-- Gallery Container -->
    <div class="gallery-container p-4 rounded shadow mb-4">
      <h4 class="fw-bold mb-3 text-primary">Photo Gallery</h4>
      <div class="row g-3">
        <?php foreach ($images as $file => $label): ?>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="gallery-card shadow-sm">
              <img src="images/<?= $file ?>" alt="<?= $label ?>" class="gallery-img">
              <div class="gallery-label"><?= $label ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <footer>
    <p class="mb-0">All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
