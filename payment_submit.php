<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "juwarahomestay1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// --- Handle form submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullname'];
  $email    = $_POST['email'];
  $phone    = $_POST['phone'];
  $amount   = $_POST['amount'];

  // upload receipt
  $targetDir = "uploads/";
  if (!is_dir($targetDir)) mkdir($targetDir);
  $receipt = $targetDir . basename($_FILES["receipt"]["name"]);
  move_uploaded_file($_FILES["receipt"]["tmp_name"], $receipt);

  // Save to payments
  $stmt = $conn->prepare("INSERT INTO payments (fullname,email,phone,amount,receipt) VALUES (?,?,?,?,?)");
  $stmt->bind_param("ssdss", $fullname, $email, $phone, $amount, $receipt);
  $stmt->execute();

  // --- Auto-generate username & password ---
  $unique = rand(1000,9999);
  $username = "JUWARA" . $unique;
  $password_plain = "pass" . rand(1000,9999);
  $password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

  // Save new user
  $insert_user = $conn->prepare("INSERT INTO users (username,password,email,phone,role) VALUES (?,?,?,?, 'user')");
  $insert_user->bind_param("ssss", $username, $password_hash, $email, $phone);
  $insert_user->execute();

  echo "
  <html>
  <head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
  </head>
  <body class='bg-light text-center p-5'>
    <div class='card mx-auto shadow p-4' style='max-width:500px;'>
      <h2 class='text-success mb-3'>✅ Payment Successful!</h2>
      <p>Thank you, <b>$fullname</b>. Your payment has been received.</p>
      <hr>
      <h4>Your Login Account</h4>
      <p><b>Username:</b> $username</p>
      <p><b>Password:</b> $password_plain</p>
      <a href='login.php' class='btn btn-primary mt-3'>Login Now</a>
    </div>
  </body>
  </html>
  ";
}
?>
