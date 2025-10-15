<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "juwarahomestay1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$room = $_POST['room'];
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$total_price = $_POST['total_price'];

// Optional: link to user if exists
$userResult = $conn->query("SELECT id FROM users WHERE email='$email' LIMIT 1");
$user_id = ($userResult->num_rows > 0) ? $userResult->fetch_assoc()['id'] : NULL;

$sql = "INSERT INTO bookings (user_id, room, check_in, check_out, total_price)
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssd", $user_id, $room, $check_in, $check_out, $total_price);

if ($stmt->execute()) {
  echo "<script>
          alert('✅ Booking successful! Your stay has been recorded.');
          window.location.href='payment.php';
        </script>";
} else {
  echo "<script>
          alert('❌ Failed to save booking.');
          window.location.href='payment.php';
        </script>";
}

$stmt->close();
$conn->close();
?>
