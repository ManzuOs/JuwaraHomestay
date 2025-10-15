<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "juwarahomestay1";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("DB Error: " . $conn->connect_error);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("UPDATE payment SET status='Approved' WHERE id=$id");
    echo "<script>alert('✅ User approved successfully!'); window.location.href='admin.php';</script>";
}
?>
