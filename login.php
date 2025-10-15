<?php
ob_start();
session_start();
include 'db.php'; // sambungan ke database

$error = '';


if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    echo "<script>alert('✅ Successfully logged out!');</script>";
}

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 🔹 Fallback login manual (jika tiada database)
    if ($username === 'admin' && ($password === 'admin' || $password === 'admin123')) {
        $_SESSION['username'] = 'admin';
        $_SESSION['role'] = 'admin';
        header("Location: admin.php?role=admin");
        ob_end_flush();
        exit;
    } elseif ($username === 'user' && ($password === 'user' || $password === 'user123')) {
        $_SESSION['username'] = 'user';
        $_SESSION['role'] = 'user';
        header("Location: user.php?role=user");
        ob_end_flush();
        exit;
    } else {
        // 🔹 Semak dari database users
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: admin.php?role=admin");
                } else {
                    header("Location: user.php?role=user");
                }
                ob_end_flush();
                exit;
            } else {
                $error = "❌ Invalid username or password!";
            }
        } else {
            $error = "❌ User not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>JUWARA HOMESTAY - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
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
          <li class="nav-item"><a class="nav-link" href="gallery.php">🖼️ Gallery</a></li>
          <li class="nav-item"><a class="nav-link active" href="login.php">🔐 Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Desktop Sidebar -->
  <div class="sidebar d-none d-lg-flex">
    <div>
      <h3>JUWARA</h3>
      <a href="index.php">🏠 Home</a>
      <a href="payment.php">💳 Payment</a>
      <a href="gallery.php">🖼️ Gallery</a>
      <a href="login.php" class="active">🔐 Login</a>
    </div>
    <p class="text-center small mb-0">&copy; <?= date('Y') ?> JUWARA HOMESTAY</p>
  </div>

  <!-- Main Content -->
  <div class="content">
    <div class="login-card bg-white rounded shadow p-4">
      <h2 class="fw-bold text-primary text-center mb-4">Login</h2>

      <?php if ($error): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p class="mb-0">All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php ob_end_flush(); ?>
