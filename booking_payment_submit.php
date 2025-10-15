<?php
// booking_payment_submit.php — Handles combined booking & payment submission

$host = "localhost";
$user = "root";
$pass = "";
$db   = "juwarahomestay1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $guests = $_POST['guests'];
  $check_in = $_POST['check_in'];
  $check_out = $_POST['check_out'];
  $total_price = $_POST['total_price'];

  // Handle uploaded file
  $target_dir = "uploads/";
  if (!is_dir($target_dir)) mkdir($target_dir);
  $receipt = basename($_FILES["receipt"]["name"]);
  $target_file = $target_dir . $receipt;
  move_uploaded_file($_FILES["receipt"]["tmp_name"], $target_file);

  // Insert booking record
  $stmt1 = $conn->prepare("INSERT INTO bookings (fullname, email, phone, guests, check_in, check_out, total_price) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $stmt1->bind_param("sssissd", $fullname, $email, $phone, $guests, $check_in, $check_out, $total_price);

  // Insert payment record
  $stmt2 = $conn->prepare("INSERT INTO payments (fullname, email, phone, amount, receipt) VALUES (?, ?, ?, ?, ?)");
  $stmt2->bind_param("sssds", $fullname, $email, $phone, $total_price, $receipt);

  if ($stmt1->execute() && $stmt2->execute()) {
    echo "<script>alert('✅ Booking and Payment submitted successfully!'); window.location='payment.php';</script>";
  } else {
    echo "<script>alert('❌ Error saving data.');</script>";
  }

  $stmt1->close();
  $stmt2->close();
}

$conn->close();
?>
