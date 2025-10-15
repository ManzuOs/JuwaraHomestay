<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>JUWARA HOMESTAY</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
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
          <li class="nav-item"><a class="nav-link active" href="index.php">🏠 Home</a></li>
          <li class="nav-item"><a class="nav-link" href="payment.php">💳 Payment</a></li>
          <li class="nav-item"><a class="nav-link" href="gallery.php">🖼️ Gallery</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">🔐 Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Sidebar (Desktop) -->
  <div class="sidebar d-none d-lg-flex">
    <div>
      <h3>JUWARA</h3>
      <a href="index.php" class="active">🏠 Home</a>
      <a href="payment.php">💳 Payment</a>
      <a href="gallery.php">🖼️ Gallery</a>
      <a href="login.php">🔐 Login</a>
    </div>
    <p class="text-center small mb-0">&copy; 2025 JUWARA HOMESTAY</p>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="homestay-card bg-white rounded shadow p-4">
      <h2 class="fw-bold text-primary mb-3">JUWARA HOMESTAY</h2>
      <img src="images/1.webp" alt="JUWARA Homestay" class="img-fluid rounded mb-3">
      <img src="images/10.jpg" alt="JUWARA Homestay" class="img-fluid rounded mb-3">
      <p>Experience comfort and tranquility in our family-friendly homestay located close to the city. 
         Enjoy beautiful scenery, modern facilities, and a peaceful environment — perfect for family vacations or group gatherings.</p>

      <div class="mt-4">
        <h5 class="fw-bold text-primary">🏠 Location</h5>
        <p>Langgar, Alor Setar, Kedah, Malaysia</p>

        <h5 class="fw-bold text-primary">💰 Price per Night</h5>
        <p>RM 750</p>

        <h5 class="fw-bold text-primary">✨ Facilities</h5>
        <ul>
          <li>Fully air-conditioned rooms</li>
          <li>Wi-Fi & Smart TV</li>
          <li>Kitchen with cooking utensils</li>
          <li>Washing machine</li>
          <li>Private swimming pool</li>
          <li>Ample parking space</li>
        </ul>
      </div>
    </div>
  </div>

  <footer>
    <p class="mb-0">All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
