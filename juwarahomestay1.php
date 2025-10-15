<?php
// juwara.php — Setup installer for JUWARA HOMESTAY

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "juwarahomestay1";

// Step 1: Connect to MySQL
$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die("<h3 style='color:red;'>❌ Connection failed: " . mysqli_connect_error() . "</h3>");
}

// Step 2: Create Database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";
if (mysqli_query($conn, $sql)) {
    echo "<p>✅ Database '<b>$dbname</b>' created or already exists.</p>";
} else {
    die("<p>❌ Error creating database: " . mysqli_error($conn) . "</p>");
}

// Step 3: Select Database
mysqli_select_db($conn, $dbname);

// Step 4: Create All Tables
$tables = [
    // Users Table
    "CREATE TABLE IF NOT EXISTS users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin','user') DEFAULT 'user',
        email VARCHAR(100),
        phone VARCHAR(30),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Bookings Table
    "CREATE TABLE IF NOT EXISTS bookings (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        guests INT(3) NOT NULL,
        check_in DATE NOT NULL,
        check_out DATE NOT NULL,
        total_price DECIMAL(10,2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Payments Table
    "CREATE TABLE IF NOT EXISTS payments (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        phone VARCHAR(20) NOT NULL,
        amount DECIMAL(10,2) NOT NULL,
        receipt VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

    // Devices Table (for future smart system integration)
    "CREATE TABLE IF NOT EXISTS devices (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        status ENUM('On','Off') DEFAULT 'Off',
        user_id INT NULL,
        last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )",

    // Device Logs Table
    "CREATE TABLE IF NOT EXISTS device_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        device_id INT,
        user_id INT,
        action ENUM('On','Off') NOT NULL,
        timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (device_id) REFERENCES devices(id) ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
    )"
];

// Step 5: Execute All Table Queries
foreach ($tables as $sql) {
    if (mysqli_query($conn, $sql)) {
        echo "<p>✅ Table created successfully.</p>";
    } else {
        echo "<p>❌ Error creating table: " . mysqli_error($conn) . "</p>";
    }
}

// Step 6: Create Default Admin User
$check_admin = mysqli_query($conn, "SELECT * FROM users WHERE username='admin'");
if (mysqli_num_rows($check_admin) == 0) {
    $hashed = password_hash('admin123', PASSWORD_DEFAULT);
    $insert_admin = "INSERT INTO users (username, password, role, email, phone)
                     VALUES ('admin', '$hashed', 'admin', 'admin@juwarahomestay.com', '0123456789')";
    mysqli_query($conn, $insert_admin);
    echo "<p>✅ Default admin added (username: <b>admin</b> | password: <b>admin123</b>)</p>";
} else {
    echo "<p>ℹ️ Admin account already exists.</p>";
}

// Step 7: Finish Setup
echo "<hr>
<h3>🎉 JUWARA HOMESTAY Database Setup Complete!</h3>
<ul>
    <li><a href='payment.php'>💳 Go to Payment Page</a></li>
    <li><a href='login.php'>🔐 Go to Login Page</a></li>
</ul>
<hr>
<p style='color:gray;'>✅ You can now safely delete this setup file (juwara.php) after running once.</p>";

mysqli_close($conn);
?>
